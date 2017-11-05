<?php

/* @var $this \yii\web\View */

/* @var $content string */

use yii\helpers\Html;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);

$this->title = $this->title ? $this->title : 'A forgotten title';

// Set canonical for SEO
$this->registerLinkTag(['rel' => 'canonical', 'href' => \yii\helpers\Url::canonical()]);
$this->registerCssFile('/css/portfolio.css');

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
    <title><?= Html::encode($this->title) . (isset(Yii::$app->params['titleSuffix']) ? Yii::$app->params['titleSuffix'] : '') ?></title>
    <?php $this->head() ?>
    <!-- Google Analytics -->
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
    <div id="wrapper">
        <div class="row no-margin">
            <div id="side-menu" class="affix">
                <div class="text-center">
                    <a href="/">
                        <h3>Melle Dijkstra.</h3>
                    </a>
                    <p>A place of thought</p>
                </div>
                <div>
                    <a href="#">Home page</a><br />
                    <a href="#">Resume</a>
                </div>
                <div id="social-buttons">
                    <i class="mdi mdi-dribbble"></i>
                    <i class="mdi mdi-stackoverflow"></i>
                    <i class="mdi mdi-email"></i>
                    <i class="mdi mdi-facebook"></i>
                    <i class="mdi mdi-linkedin"></i>
                </div>
                <p>Website created with:</p>
                <p>Yii2</p>
                <p>© All rights reserved</p>
            </div>
            <div id="page-content">
                <?= Alert::widget() ?>
                <?= $content ?>
            </div>
        </div>
    </div>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
