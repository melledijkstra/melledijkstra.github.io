<?php

use common\assets\HighLightAsset;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $guide \common\models\Guide */

// Highlight code with hljs library
HighLightAsset::register($this);
$this->registerJs('hljs.initHighlightingOnLoad();', View::POS_READY);

// Place this tag in your head or just before your close body tag.
$this->registerJsFile('https://apis.google.com/js/platform.js', [
    'async' => '',
    'defer' => '',
]);

// twitter stuff
$this->registerJs(<<<JS
window.twttr = (function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0],
    t = window.twttr || {};
  if (d.getElementById(id)) return t;
  js = d.createElement(s);
  js.id = id;
  js.src = "https://platform.twitter.com/widgets.js";
  fjs.parentNode.insertBefore(js, fjs);

  t._e = [];
  t.ready = function(f) {
    t._e.push(f);
  };

  return t;
}(document, "script", "twitter-wjs"));
JS
, View::POS_BEGIN);

// SEO stuff
$metastuff = [
    'keywords' => implode(' ', array_merge($guide->getCategories()->select('name')->column(),
        [$guide->language ? $guide->language->name : ''])),
    'twitter:card' => 'summary',
    'twitter:title' => $guide->title,
    'twitter:creator' => '@dijkstrascience',
];
if (!empty($guide->sneak_peek)) {
    $metastuff['description'] = $guide->sneak_peek;
    $metastuff['tag'] = $guide->sneak_peek;
    $metastuff['twitter:description'] = $guide->sneak_peek;
}
if ($guide->hasImage()) {
    $metastuff['twitter:image'] = $guide->getPublicLink(true);
}

foreach ($metastuff as $name => $content) {
    $this->registerMetaTag([
        'name' => $name,
        'content' => $content,
    ], $name);
}

$this->registerCss(<<<CSS
#disqus_thread {
    margin-top: 50px;
}
CSS
);

$this->title = $guide->title;

?>
<div id="guide-view-page">
    <div id="guide-view" class="container-fluid">
        <div class="jumbotron">
            <h1 class="guide-title"><?= $guide->title ?></h1>
            <div>
                <small class="guide-date"><?= Yii::$app->formatter->asDate($guide->created_at, 'medium'); ?>
                    - <?= $guide->createdBy->username; ?></small>
            </div>
            <div class="margin-10 guide-share-bar">
                <a class="twitter-share-button" href="https://twitter.com/intent/tweet?text=<?= $this->title ?>&url=<?= $guide->getLink(true); ?>&via=dijkstrascience">Tweet</a>
                <div class="g-plusone"></div>
                <!-- facebook share? -->
            </div>
        </div>
        <div class="guide-container">
            <?= $guide->renderGuide(); ?>
        </div>
        <div id="disqus_thread"></div>
        <script>
            /**
             *  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
             *  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables
             */
            var disqus_config = function () {
                this.page.url = "<?= \yii\helpers\Url::canonical(); ?>";  // Replace PAGE_URL with your page's canonical URL variable
                this.page.identifier = "<?= $guide->getTitle(true); ?>"; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
            };
            (function () { // DON'T EDIT BELOW THIS LINE
                var d = document, s = d.createElement('script');
                s.src = 'https://dev-melledijkstra.disqus.com/embed.js';
                s.setAttribute('data-timestamp', +new Date());
                (d.head || d.body).appendChild(s);
            })();
        </script>
        <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by
                Disqus.</a></noscript>
    </div>
</div>