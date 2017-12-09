<?php

/* @var $this \yii\web\View */
/* @var $content string */

use common\models\Category;
use yii\helpers\Html;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use yii\widgets\ActiveForm;

AppAsset::register($this);

$this->title = $this->title ?: 'A forgotten title';

// Set canonical for SEO
$this->registerLinkTag(['rel' => 'canonical', 'href' => \yii\helpers\Url::canonical()]);

$this->registerJs(<<<JS
    $('#subscription-form').on('beforeSubmit', function(event, jqXHR, settings) {
        var form = $(this);
        
        $.ajax({
            url: form.attr('action'),
            type: form.attr('method'),
            data: form.serialize(),
            dataType: 'json',
            success: function(result, status, xhr) {
                if(result.status === "OK") {
                    form.replaceWith("<div class=' text-lg text-center'><span class='mdi mdi-emoticon-excited'></span> Thank you!</div>");
                } else if(result.status === "ERROR") {
                    alert(result.message);
                }
            }
        });
    }).on('submit', function(e) {
        e.preventDefault();
    });
JS
);

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
    <meta name="msapplication-TileColor" content="#ac9c80">
    <meta name="msapplication-TileImage" content="/favicons/ms-icon-144x144.png">
    <meta name="theme-color" content="#ac9c80">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) . (Yii::$app->params['titleSuffix'] ?? '') ?></title>
    <?php $this->head() ?>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-61555186-3"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-61555186-3');
    </script>
</head>
<body>
<?php $this->beginBody() ?>
<div id="wrap">
    <div id="sidebar-wrapper">
        <h1 class="text-center"><a class="no-link" href="/">Melle Dijkstra<span class="brand-dot">.</span></a><br/>
            <small>A place of thought</small>
        </h1>
        <ul class="sidebar-nav">
            <li>
                <a href="/guides"><i class="mdi mdi-book-open-page-variant"></i> <span
                            class="text-right">Guides</span></a>
            </li>
            <li>
                <a href="/portfolio"><i class="mdi mdi-pencil"></i> <span class="text-right">Portfolio</span></a>
            </li>
            <li>
                <a href="/resume"><i class="mdi mdi-account-card-details"></i> <span
                            class="text-right">Resume</span></a>
            </li>
        </ul>
        <!-- EMAIL SUBSCRIBE FORM -->
        <?php
        $subscriber = new \common\models\Subscription();

        $form = ActiveForm::begin([
            'action' => '/site/add-subscription',
            'id' => 'subscription-form',
            'enableClientValidation' => true,
            'method' => 'post',
            'validateOnBlur' => false,
            'options' => [
                'class' => 'margin-tb-10',
            ]
        ]);

        echo $form->field($subscriber, 'email')
            ->label('Get notified about new guides', [
                'class' => '',
            ])
            ->input('email', ['placeholder' => 'Your fantastic email']);

        echo Html::submitButton('SUBSCRIBE', ['class' => 'btn btn-primary btn-block']);

        ActiveForm::end();
        ?>
        <!-- SOCIAL MEDIA -->
        <div class="margin-tb-20 text-lg text-center social-buttons">
            <a class="github" target="_blank" href="https://github.com/MelleDijkstra"><span
                        class="mdi mdi-github-circle"></span><span class="hidden">My github account</span></a>
            <a class="twitter" target="_blank" href="https://twitter.com/dijkstrascience"><span
                        class="mdi mdi-twitter"></span><span class="hidden">My twitter account</span></a>
            <a class="linkedin" target="_blank" href="https://linkedin.com/in/melledijkstra"><span
                        class="mdi mdi-linkedin"></span><span class="hidden">My linkedin account</span></a>
            <a class="stackoverflow" target="_blank"
               href="https://stackoverflow.com/users/3298540/melle-dijkstra"><span
                        class="mdi mdi-stackoverflow"></span><span
                        class="hidden">My stackoverflow account</span></a>
        </div>
        <div class="text-center">
            <small>
                Copyright &copy; 2016 - <?= date('Y'); ?> Melle Dijkstra<br/>
                All rights reserved
            </small>
        </div>
    </div>

    <div id="page-content">
        <!-- WIP BANNER -->
<!--        <div class="padding-10 wip-banner text-center">-->
<!--            <span class="text-md mdi mdi-worker"></span>-->
<!--            <p>This site is currently in progress, please browse around! But be aware of bugs or misspelled-->
<!--                words.</p>-->
<!--        </div>-->
        <!-- SIDEBAR TOGGLER -->
        <button type="button" class="navbar-toggle collapsed"
                onclick="$('#wrap').toggleClass('toggled');" data-toggle="collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
