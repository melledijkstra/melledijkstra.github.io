<?php

/**
 * @var $this \yii\web\View
 * @var $content string
 */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

$navItems = [
    'Projects' => [
        'route' => 'projects',
        'icon' => 'book-multiple'
    ],
    'Series' => [
        'route' => 'series',
        'icon' => 'book-multiple',
    ],
    'Guides' => [
        'route' => 'guides',
        'icon' => 'book-open-page-variant',
    ],
    'Categories' => [
        'route' => 'categories',
        'icon' => 'bookmark',
    ],
    'Languages' => [
        'route' => 'languages',
        'icon' => 'translate',
    ],
    'Subscriptions' => [
        'route' => 'subscriptions',
        'icon' => 'rss',
    ],
    'Resources' => [
        'route' => 'resources',
        'icon' => 'file-multiple',
    ],
];

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" sizes="76x76" href="/favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicons/favicon-16x16.png">
    <link rel="manifest" href="/favicons/manifest.json">
    <link rel="mask-icon" href="/favicons/safari-pinned-tab.svg" color="#46aac7">
    <link rel="shortcut icon" href="/favicons/favicon.ico">
    <meta name="msapplication-config" content="/favicons/browserconfig.xml">
    <meta name="theme-color" content="#ac9c80">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'Melle Dijkstra\'s Backend',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    } else {
        foreach ($navItems as $label => $info) {
            $menuItems[] = [
                'label' => "<span class=\"mdi mdi-{$info['icon']}\"></span> {$label}",
                'items' =>
                    [
                        [
                            'label' => "<span class=\"mdi mdi-view-list\"></span> {$label}",
                            'url' => ["/{$info['route']}"]
                        ],
                        ['label' => '<span class="mdi mdi-plus"></span> Create', 'url' => ["/{$info['route']}/create"]]
                    ]
            ];
        }

        $menuItems[] = '<li>'
            . Html::beginForm(['/site/logout'])
            . Html::submitButton(
                'Logout (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>';
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'encodeLabels' => false,
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
