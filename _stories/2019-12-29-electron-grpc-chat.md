---
title: "Electron gRPC Chat"
date: 2019-12-29 14:26:00 +0200
categories: javscript grpc
image: 
language:
    color: f0db4f
    name: Javascript
---
An electron application with gRPC connected with a python chatting server.
<!--more-->
Find the repository for this article here:
<table class="table table-condensed">
    <tr>
        <td><i class="mdi mdi-github-circle"></i></td>
        <td><a target="_blank" href="https://github.com/melledijkstra/electron-grpc">github.com/melledijkstra/electron-grpc</a></td>
    </tr>
</table>

A while ago I wrote [another article](/stories/2019-11-24-chatting-with-grpc-in-python) about the creation of a simple python bi-directional chatting server and client.
I created the application in python as a case study to see if how easy it is to create a bi-directional streaming application.
Why? Because another project of mine to control a music player from a distance also required bi-directional streaming.
These small projects are perfect to figure out if it works for the bigger picture.

So what about this project? After some time working on the music player application I thought of new idea because I read an article about gRPC going to javascript (for node, not yet the web).
And this made me believe I could create a music controller for the desktop which is also cross-platform! Electron is perfect for creating cross platform application. Now that there is gRPC version
for node.js applications this is perfect to test the combination of the two.

Instead of immediately creating a big electron application as a controller for the music player I wanted to start small to see the possibilities of electron.
So for that reason I will be creating an additional gRPC client for the chat application I created before in python. The server will stay exactly the same, actually, the proto file will also
stay exactly the same because it will define the whole protocol of the whole application. As a client it only has to combine the frontend part and connect with the generated backend code.
It should be as easy as that. Let's see how easy it will be to combine the two technologies!

First step, I am creating an empty electron application and play around to get it starting and working and see the project structure it uses
Most of the guidelines and information that I will be following and gathering for the setup of the electron application are from [https://electronjs.org/docs](https://electronjs.org/docs).
I will be mainly focused on the combination of the gRPC and electron. I will not be repeating others who have probably explained it better anyway already!

First setup the electron app by following: [https://electronjs.org/docs/tutorial/first-app](https://electronjs.org/docs/tutorial/first-app)
```bash
# create this file structure
your-app/
├── package.json
├── main.js
└── index.html

# run this command (or you can also let webstorm/phpstorm create the node application and it will fill the package.json
npm init

npm install --save-dev electron
```

> **Note:** make sure the correct main is stated in your package.json to startup the electron app

> **Note:** also make sure you are running the application with the electron runtime and 
not node (please refer to the official guides if you don't know what this is about)

![Electron Hello World](/assets/images/story-images/electron-hello-world.png)

Now that the setup of the electron app is done we have many ways you can discover further what is possible.
When you have a look at [https://github.com/sindresorhus/awesome-electron](https://github.com/sindresorhus/awesome-electron) you can find an amazing list of tools and packages free to use with electron.
For me, I just want to make sure I can implement the gRPC part as fast a possible, so installing gRPC in our current environment is the next step.

When I google for "grpc node install electron" I don't see a lot of happy articles. Instead there seem to be quite some issues with combining the two. The reason for this is, is that the gRPC library
is under the hood written lower languages (c++) as far as I know and this needs compiling of the source code for every particular system you want to run it on (linux, windows, android, mac).
So with gRPC and electron you are actually implementing a not so cross compatible library with an environment made for cross-compilation. Well, at least the articles provide answers and it's worth the try.

After following some more links and gathering some more info I found the following webpage [https://grpc.github.io/grpc/node/](https://grpc.github.io/grpc/node/).
It seems they have their own github pages and here they have explained that electron needs a different install procedure.

Also, they deliberately state here that it's basically not a good idea to use gRPC with electron 😢.
See the following quote from their website:

> While the reasons behind this are technically good - many native extensions won't be packaged to work properly with electron - the gRPC source code is fairly difficult to build from source due to its complex nature, and we're also providing working electron pre-built binaries. Therefore, we recommend that you do not follow this model for using gRPC with electron.<br />
>
> -- <cite>grpc.github.io</cite>

So actually the creators of gRPC already explain that it's hard to use the two in combination and basically encourage not to continue.

But hey, does this discourage me to continue trying? No!
So I continue reading and basically they provide the following solution:

Run this:
```bash
npm install grpc
``` 

And put the following line in your `package.json`.
```json
{
    ...
    "postinstall": "npm rebuild --target=7.1.7 --runtime=electron --dist-url=https://atom.io/download/electron"
}
```

> **Note:** Make sure you put the correct electron version! I am using 7.1.7 at the time of writing

So I added that file and ran `npm install` but the postinstall didn't ran. Probably that `postinstall` key does not work.
I just took the command on my own and ran it in the command line to check if it runs correctly.

![gRPC electron install](/assets/images/story-images/grpc-install.png)

Okay, it seems there are no pre-build libraries yet for electron version 7.1.7 so it's starting to compile on it's own now...<br/>
...<br/>
...<br/>
...<br/>

In the mean time let's copy the proto file which I used for the python part of the application.
It is a really simple protobuf file.

```proto
syntax = "proto3";

package grpc;

message Empty {}

// I called it Note because 'message Message' sounds complicated
message Note {
    string name = 1;
    string message = 2;
}

service ChatServer {
    // This bi-directional stream makes it possible to send and receive Notes between 2 persons
    rpc ChatStream (Empty) returns (stream Note);
    rpc SendNote (Note) returns (Empty);
}
```

As you can see we have a `Note` object which holds information about the actual message and the person who send it.
Then there is a service called `ChatServer` which has a rpc call named `ChatStream` which clients register on and the server
will stream the Notes to the clients from this call.

Alright! it finished building, got some warnings but no big issues to continue building further.

On the official [grpc website](https://grpc.io/docs/tutorials/basic/node/) they describe that there are two ways of using protobuf in javascript with Node.
Dynamically and static. Apparently you can load in your proto files dynamically and generate code at runtime.
This seems very nice, however for now I am continuing to create the static files with the protoc compiler.

To generate the static script I referred to the examples of the [grpc github page](https://github.com/grpc/grpc/tree/master/examples/node/static_codegen)
I put it in a script and voila!

```bash
#!/bin/bash
echo "Generating proto..."

grpc_tools_node_protoc --js_out=import_style=commonjs,binary:. --grpc_out=. --plugin=protoc-gen-grpc=`which grpc_tools_node_protoc_plugin` ./proto/chat.proto
```

This will generate the proto files in the `./proto` directory

<img class="img-responsive" style="height: 200px; width: auto;" src="/assets/images/story-images/proto-compiled.png" alt="Static proto compiled" />

The proto generated files are ready to be used and we can start with creating a structure for the electron application.
