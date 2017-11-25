<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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

        $menuItems[] = ['label' => '<span class="mdi mdi-book-multiple"></span> Series', 'items' =>
            [
                ['label' => '<span class="mdi mdi-view-list"></span> Series', 'url' => ['/series']],
                ['label' => '<span class="mdi mdi-plus"></span> Create', 'url' => ['/series/create']]
            ]
        ];
        $menuItems[] = ['label' => '<span class="mdi mdi-book-open-page-variant"></span> Guides', 'items' =>
            [
                ['label' => '<span class="mdi mdi-view-list"></span> Overview', 'url' => ['/guides']],
                ['label' => '<span class="mdi mdi-plus"></span> Create', 'url' => ['/guides/create']]
            ]
        ];
        $menuItems[] = ['label' => '<span class="mdi mdi-bookmark"></span> Categories', 'items' =>
            [
                ['label' => '<span class="mdi mdi-view-list"></span> Overview', 'url' => ['/categories']],
                ['label' => '<span class="mdi mdi-plus"></span> Create', 'url' => ['/categories/create']]
            ]
        ];
        $menuItems[] = ['label' => '<span class="mdi mdi-translate"></span> Languages', 'items' =>
            [
                ['label' => '<span class="mdi mdi-view-list"></span> Overview', 'url' => ['/languages']],
                ['label' => '<span class="mdi mdi-plus"></span> Create', 'url' => ['/languages/create']]
            ]
        ];
        $menuItems[] = ['label' => '<span class="mdi mdi-file-multiple"></span> Resources', 'items' =>
            [
                ['label' => '<span class="mdi mdi-view-list"></span> Overview', 'url' => ['/resources']],
            ]
        ];

        $menuItems[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
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
