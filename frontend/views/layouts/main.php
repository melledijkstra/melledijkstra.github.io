<?php

/* @var $this \yii\web\View */
/* @var $content string */

use common\models\Category;
use yii\helpers\Html;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);

$this->title = $this->title ? $this->title : 'A forgotten title';

// Set canonical for SEO
$this->registerLinkTag(['rel' => 'canonical', 'href' => \yii\helpers\Url::canonical()]);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" sizes="57x57" href="/favicons/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/favicons/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/favicons/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/favicons/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/favicons/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/favicons/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/favicons/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/favicons/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/favicons/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/favicons/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/favicons/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicons/favicon-16x16.png">
    <link rel="manifest" href="/favicons/manifest.json">
    <meta name="msapplication-TileColor" content="#E87B5A">
    <meta name="msapplication-TileImage" content="/favicons/ms-icon-144x144.png">
    <meta name="theme-color" content="#E87B5A">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) . ((isset(Yii::$app->params['titleSuffix'])) ? Yii::$app->params['titleSuffix'] : '') ?></title>
    <?php $this->head() ?>
    <script>
        (function (i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function () {
                    (i[r].q = i[r].q || []).push(arguments)
                }, i[r].l = 1 * new Date();
            a = s.createElement(o),
                m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.src = g;
            m.parentNode.insertBefore(a, m)
        })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

        ga('create', 'UA-61555186-3', 'auto');
        ga('send', 'pageview');
    </script>
</head>
<body>
<?php $this->beginBody() ?>
<div class="wrap">
    <?php
    //    NavBar::begin([
    //        'brandLabel' => 'Melle Dijkstra',
    //        'brandUrl' => Yii::$app->homeUrl,
    //        'options' => [
    //            'class' => 'mel-navbar',
    //        ],
    //    ]);
    //    $menuItems = [
    //        [
    //            'label' => '<span class="mdi mdi-buffer"></span> '.Yii::t('project', 'Projects'),
    //            'url' => ['/projects'],
    //            'active' => \Yii::$app->controller->id == 'projects',
    //        ],
    //        [
    //            'label' => '<span class="mdi mdi-book-open-page-variant"></span> '.Yii::t('guide', 'Guides'),
    //            'url' => ['/guides'],
    //            'active' => \Yii::$app->controller->id == 'guides',
    //        ],
    //        [
    //            'label' => '<span class="mdi mdi-account-card-details"></span> '.Yii::t('remaining', 'About Me'),
    //            'url' => ['/about'],
    //            'active' => \Yii::$app->request->url == '/about',
    //        ],
    //    ];
    //    echo Nav::widget([
    //        'options' => ['class' => 'navbar-nav navbar-right'],
    //        'encodeLabels' => false,
    //        'items' => $menuItems,
    //    ]);
    //    NavBar::end();
    ?>

    <div id="wrapper">
        <div id="sidebar-wrapper">
            <h1 class="text-center"><a class="no-link" href="/">Melle Dijkstra<span class="brand-dot">.</span></a><br/>
                <small>A place of thought</small>
            </h1>
            <ul class="sidebar-nav">
                <li class="sidebar-brand">
                    <a href="#">
                        Work in progress!!
                    </a>
                </li>
                <li>
                    <a href="/guides">Guides</a>
                </li>
                <li>
                    <a href="/projects">Projects</a>
                </li>
                <li>
                    <a href="/about">Who's behind all this?</a>
                </li>
            </ul>
            <h3 class="margin-20"><?= Yii::t('category', 'Categories'); ?></h3>
            <div class="margin-20">
                <u><?= implode('</u>, <u>', Category::find()->select('name')->column()); ?></u>
            </div>
            <div class="text-lg text-center shadow-text">
                <a target="_blank" href="https://github.com/MelleDijkstra"><span style="color: #333333;" class="mdi mdi-github-circle"></span></a>
                <a target="_blank" href="https://twitter.com/dijkstrascience"><span style="color: #50ABF1;" class="mdi mdi-twitter"></span></a>
                <a target="_blank" href="https://linkedin.com/in/melledijkstra"><span style="color: #0077B5;" class="mdi mdi-linkedin"></span></a>
                <a target="_blank" href="https://stackoverflow.com/users/3298540/melle-dijkstra"><span style="color: #F48024;" class="mdi mdi-stackoverflow"></span></a>
            </div>
        </div>
        <div id="page-content-wrapper">
            <div class="padding-10 wip-banner text-center">
                <span class="text-md mdi mdi-worker"></span>
                <p>This site is currently in progress, please browse around! But be aware of bugs or mispelled words.</p>
            </div>
            <div class="visible-xs">
                <button type="button" class="toggler navbar-toggle collapsed"
                        onclick="$('#wrapper').toggleClass('toggled');" data-toggle="collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    </div>

</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
