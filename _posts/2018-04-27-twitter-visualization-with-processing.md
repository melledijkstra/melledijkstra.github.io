---
layout: post
title:  "Twitter visualization with Processing"
date:   2018-04-27 22:53:32 +0200
categories: twitter processing
image: /assets/images/stories/2018-04-27.jpg
language:
    color: e76f00
    name: Java
---
Twitter visualization of the latest trends created with the Java programming language. Created with Processing and the twitter4j library.
<!--more-->

With the Twitter4j library, you can retrieve Twitter data in the Java programming language fairly simple. In addition, the processing framework lets you create artful visualizations very easy, also with the Java language.

I wanted to combine the two, create a Twitter visualization. I choose to retrieve the newest trends from the whole world and let them slide on the window. The Twitter4j library can be found [here](http://twitter4j.org/en/index.html). And Processing [here](https://processing.org).

The actual code and repository can be found here:

https://github.com/MelleDijkstra/TwitterWave

The sketch exists of 2 files. The first is the actual sketch file and the other has the logic for every individual Trend on the screen. The actual sketch file called `twitterwave.pde` does a few things: 

1. Sets up the Twitter communication
2. Retrieves the trends
3. Contains the update & draw loop

File: *twitterwave.pde*

{% highlight java %}
ArrayList<FloatingTrend> trends = new ArrayList<FloatingTrend>();

void setup() {
  // Set twitter stuff
  cb.setOAuthConsumerKey(<KEY>);
  cb.setOAuthConsumerSecret(<TOKEN>);
  cb.setOAuthAccessToken(<ATOKEN>);
  cb.setOAuthAccessTokenSecret(<ASECRET>);
  
  fullScreen(2);
  
  Twitter twitter = new TwitterFactory(cb.build()).getInstance();
  TrendsResources trendResources = twitter.trends();
  try {
    // Retrieve latest trending Trends from WOEID 1 (which is the world)
    Trends latestTrends = trendResources.getPlaceTrends(1);
    Trend[] latesttrends = latestTrends.getTrends();
    for(int i = 0; i < latesttrends.length; i++) {
      trends.add(new FloatingTrend(latesttrends[i],random(width, width + 400), random(height), (int)random(8,20)));
    }
  } catch(TwitterException e) {
    e.printStackTrace();
    System.out.println("Could not gather Trends");
  }
}

void draw() {
  background(50);
  for(FloatingTrend trend : trends) {
    trend.update();
    trend.show();
  }
}
{% endhighlight %}

The `FloatingTrend.pde` file contains the logic for every trend on the screen. Every trend is rendered with the `text()` function. The speed at which the trend moves depends on how big the font size is for the trend. A bigger font will move slower than a trend with a smaller font size. This gives the illusion of depth.

File: *FloatingTrend.pde*

```java
class FloatingTrend {
  
  // uses a twitter4j Trend
  private Trend trend;
  private PVector pos;
  private float speed;
  private int textSize;
  // The textWidth of the trend name
  private float textWidth;
  
  public FloatingTrend(Trend trend, float x, float y, int textSize) {
    this.textSize = textSize;
    this.trend = trend;
    // specify textSize before calculating the width of the text
    textSize(textSize);
    textWidth = textWidth(trend.getName());
    // The textSize specifies how fast the text flows over the screen
    speed = textSize * 0.1;
    pos = new PVector(x,y);
  }
  
  public void update() {
    this.pos.x -= speed;
    if(this.pos.x + textWidth < 0) {
      this.pos.x = width;
    }
  }
  
  public void show() {
    fill(255, map(textSize, 8, 20, 50, 150));
    textSize(textSize);
    text(trend.getName(), pos.x, pos.y);
  }
  
}
```

### Impression

![Twitter Wave](/assets/images/story-images/twitterwave.png)

**Improvements**

1. Use a continues stream of Twitter trends instead of retrieving them once as I do now. (You could use a separate thread for handling this functionality)
2. The bigger trends should have the bigger font sizes. This gives a better representation of the trends and how famous a trend is on Twitter.