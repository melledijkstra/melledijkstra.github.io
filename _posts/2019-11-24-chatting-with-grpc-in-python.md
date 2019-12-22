---
layout: post
title:  "Chatting with gRPC in python"
date:   2019-11-24 18:36:00 +0200
categories: python grpc
image: /assets/images/stories/2019-11-24.png
language:
    color: 3572A5
    name: Python
---
As a study for bi-directional gRPC connection I thought it would be fun to create a simple chat application. Because a chat is one of the simplest examples of bi-directional communication.
<!--more-->

I wrote this chat application a while ago as I was interested in the technology called gRPC.
So what exactly is [gRPC](https://grpc.io/)? It is combination of google protobufs and RPC.
Google protobufs is basically a neutral platform and language structure created by Google for serializing structured data.

It works a little bit like JSON or XML in the sence that it has a fixed structure and it doesn't matter which programming language you interpret it, it should always give the same result.
However, the data is serialized on a way lower level so it makes the data super compact and... super fast! 
And because it's super small and fast means it's perfect to use this structure to send it over the network because there size of packets and speed are important.
That is why using protocol buffers are a good idea for IoT communication.

Then RPC stands for Remote Procedure Call. This is a technique used to run a specific command on device which is not itself.
For example a Java client application which sends a command to a Java server to run a specific function. That is RPC.
Now RPC is mostly language specific and between languages this is hard to implement. Now that is a problem gRPC fixes.
With gRPC you specify your data structures **and** also your remote calls which are possible from the outside! 

Here is how protocol buffers are written, instantiated in Java and interpreted in C++
This example can be found on the official [protobufs homepage](https://developers.google.com/protocol-buffers)

<div class="fat">
    <div class="row">
        <div class="col-sm-12 col-md-4">
        <i>The protobug language</i>
            {% highlight protobuf %}
message Person {
  required string name = 1;
  required int32 id = 2;
  optional string email = 3;
}
{% endhighlight %}
        </div>
        <div class="col-sm-12 col-md-4">
        <i>The instantiation in Java</i>
{% highlight java %}
Person john = Person.newBuilder()
    .setId(1234)
    .setName("John Doe")
    .setEmail("jdoe@example.com")
    .build();
output = new FileOutputStream(args[0]);
john.writeTo(output);
{% endhighlight %}
        </div>
        <div class="col-sm-12 col-md-4">
        <i>The interpretation in C++</i>
{% highlight cpp %}
Person john;
fstream input(argv[1],
    ios::in | ios::binary);
john.ParseFromIstream(&input);
id = john.id();
name = john.name();
email = john.email();
{% endhighlight %}
        </div>
    </div>
</div>

This makes communication super simple between different devices and also programming languages. It is very powerful
way of constructing a communication protocol. I started using it in personal project like my wireless music player which you
can find on my github.

So now for the chat there has to be a basic structure for the protocol. A `.proto` file has all the info about the protocol
written in the protobuf language. This is what I came up with:

{% highlight protobuf %}
syntax = "proto3"; // the version at the time of writing

package grpc;

message Empty {}

// I called it Note because message Message sounds complicated
message Note { // this is the actual message that the server is receiving and sends to all the other users in the 'room'
    string name = 1; // name of the person who wrote the message
    string message = 2; // the actual message
}

service ChatServer {
    // This bi-directional stream makes it possible to send and receive Notes between 2 persons
    rpc ChatStream (Empty) returns (stream Note); // the call which is streaming (open connection)
    rpc SendNote (Note) returns (Empty);
}
{% endhighlight %}

As you can see there is also a `service` defined in the protobuf file. That is gRPC specific and will provide a service
for us to use that has the given RPC calls implemented. How this exactly works you can read some small examples [here](https://grpc.io/docs/guides/concepts/).
On that page is also described how the normal streaming, bi-directional streaming and synchronous vs. asynchronous RPC calls exactly work.

We will use bi-directional streaming as that is what the whole case study is all about. In this case I want to test if I
can have multiple connections open (streaming) connected to a server. But also that all the clients **including the server** can
initiate a call!

Now the actual implementation in python. However, remember that with the `.proto` file you should theoretically be able to apply
this to all the languages supported by gRPC.

> Note: I have removed some lines like imports from the code below to make it more readable, please refer to the repo
> for the full implementation

Instead of breaking the code into multiple pieces and let them fly around the page I think it's better to keep it as one piece
and put enough comments to the code to make it readable and understandable! Please let me know in the comments if breaking the code
up in multiple pieces is better way to go.

### Server

```python
class ChatServer(rpc.ChatServerServicer):  # inheriting here from the protobuf rpc file which is generated

    def __init__(self):
        # List with all the chat history
        self.chats = []

    # The stream which will be used to send new messages to clients
    def ChatStream(self, request_iterator, context):
        """
        This is a response-stream type call. This means the server can keep sending messages
        Every client opens this connection and waits for server to send new messages

        :param request_iterator:
        :param context:
        :return:
        """
        lastindex = 0
        # For every client a infinite loop starts (in gRPC's own managed thread)
        while True:
            # Check if there are any new messages
            while len(self.chats) > lastindex:
                n = self.chats[lastindex]
                lastindex += 1
                yield n

    def SendNote(self, request: chat.Note, context):
        """
        This method is called when a clients sends a Note to the server.

        :param request:
        :param context:
        :return:
        """
        # this is only for the server console
        print("[{}] {}".format(request.name, request.message))
        # Add it to the chat history
        self.chats.append(request)
        return chat.Empty()  # something needs to be returned required by protobuf language, we just return empty msg


if __name__ == '__main__':
    port = 11912  # a random port for the server to run on
    # the workers is like the amount of threads that can be opened at the same time, when there are 10 clients connected
    # then no more clients able to connect to the server.
    server = grpc.server(futures.ThreadPoolExecutor(max_workers=10))  # create a gRPC server
    rpc.add_ChatServerServicer_to_server(ChatServer(), server)  # register the server to gRPC
    # gRPC basically manages all the threading and server responding logic, which is perfect!
    print('Starting server. Listening...')
    server.add_insecure_port('[::]:' + str(port))
    server.start()
    # Server starts in background (in another thread) so keep waiting
    # if we don't wait here the main thread will end, which will end all the child threads, and thus the threads
    # from the server won't continue to work and stop the server
    while True:
        time.sleep(64 * 64 * 100)
```

### Client

```python
class Client:

    def __init__(self, u: str, window):
        # the frame to put ui components on
        self.window = window
        self.username = u
        # create a gRPC channel + stub
        channel = grpc.insecure_channel(address + ':' + str(port))
        self.conn = rpc.ChatServerStub(channel)
        # create new listening thread for when new message streams come in
        threading.Thread(target=self.__listen_for_messages, daemon=True).start()
        self.__setup_ui()
        self.window.mainloop()

    def __listen_for_messages(self):
        """
        This method will be ran in a separate thread as the main/ui thread, because the for-in call is blocking
        when waiting for new messages
        """
        for note in self.conn.ChatStream(chat.Empty()):  # this line will wait for new messages from the server!
            print("R[{}] {}".format(note.name, note.message))  # debugging statement
            self.chat_list.insert(END, "[{}] {}\n".format(note.name, note.message))  # add the message to the UI

    def send_message(self, event):
        """
        This method is called when user enters something into the textbox
        """
        message = self.entry_message.get()  # retrieve message from the UI
        if message is not '':
            n = chat.Note()  # create protobug message (called Note)
            n.name = self.username  # set the username
            n.message = message  # set the actual message of the note
            print("S[{}] {}".format(n.name, n.message))  # debugging statement
            self.conn.SendNote(n)  # send the Note to the server

    def __setup_ui(self):
        self.chat_list = Text()
        self.chat_list.pack(side=TOP)
        self.lbl_username = Label(self.window, text=self.username)
        self.lbl_username.pack(side=LEFT)
        self.entry_message = Entry(self.window, bd=5)
        self.entry_message.bind('<Return>', self.send_message)
        self.entry_message.focus()
        self.entry_message.pack(side=BOTTOM)


if __name__ == '__main__':
    root = Tk()  # I just used a very simple Tk window for the chat UI, this can be replaced by anything
    frame = Frame(root, width=300, height=300)
    frame.pack()
    root.withdraw()
    username = None
    while username is None:
        # retrieve a username so we can distinguish all the different clients
        username = simpledialog.askstring("Username", "What's your username?", parent=root)
    root.deiconify()  # don't remember why this was needed anymore...
    c = Client(username, frame)  # this starts a client and thus a thread which keeps connection to server open
```

That is how simple it is to implement gRPC in a bi-directional streaming application. I hope it is clear how every piece
of code connects into the whole structure. If not, please let me know in the comments section! 

Here is a small demonstration of the working product.

![Chat interation demo](/assets/images/story-images/chat-system-inaction.gif)

Thank you for reading and good luck with any gRPC projects! :D

