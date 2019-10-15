<?php

use common\assets\HighLightAsset;
use yii\web\View;

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

$this->title = $guide->title;

?>
<div id="guide-view-page">
    <div id="guide-view" class="container-fluid">
        <div class="jumbotron">
            <h1 class="guide-title"><?= $guide->title ?></h1>
            <div>
                <small class="guide-date"><?= \Yii::$app->formatter->asDate($guide->created_at, 'medium'); ?>
                    - <?= $guide->createdBy->username; ?></small>
            </div>
            <div class="margin-10 guide-share-bar">
                <a class="twitter-share-button"
                   href="https://twitter.com/intent/tweet?text=<?= $this->title ?>&url=<?= $guide->getLink(true); ?>&via=dijkstrascience">Tweet</a>
                <div data-action="share" data-height="20" class="g-plus"></div>
            </div>
        </div>
        <div id="guide-container">
            <?= $guide->renderGuide(); ?>
        </div>
        <div class="series">
            <?php
            $prevGuide = $guide->previousGuide;
            $nextGuide = $guide->nextGuide;
            ?>
            <?php if ($prevGuide !== null): ?>
                <div class="pull-left">
                    <a class="btn btn-primary"
                       href="<?= $prevGuide->getLink(); ?>"><i class="mdi mdi-arrow-left"></i> <?= $prevGuide->title; ?>
                    </a>
                </div>
            <?php endif; ?>
            <?php if ($nextGuide !== null): ?>
                <div class="pull-right">
                    <a class="btn btn-primary" href="<?= $nextGuide->getLink(); ?>"><?= $nextGuide->title; ?>
                        <i class="mdi mdi-arrow-right"></i></a>
                </div>
            <?php endif; ?>
        </div>

    </div>
</div>