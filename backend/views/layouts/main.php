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
            'class' => 'mel-navbar navbar-fixed-top',
        ],
    ]);
    $menuItems = [];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    } else {

        $menuItems[] = ['label' => '<i class="mdi mdi-buffer"></i> Projects', 'items' =>
            [
                ['label' => '<i class="mdi mdi-view-list"></i> Overview', 'url' => ['/projects']],
                ['label' => '<i class="mdi mdi-plus"></i> Create', 'url' => ['/projects/create']]
            ]
        ];
        $menuItems[] = ['label' => '<i class="mdi mdi-book-open-page-variant"></i> Guides', 'items' =>
            [
                ['label' => '<i class="mdi mdi-view-list"></i> Overview', 'url' => ['/guides']],
                ['label' => '<i class="mdi mdi-plus"></i> Create', 'url' => ['/guides/create']]
            ]
        ];
        $menuItems[] = ['label' => '<i class="mdi mdi-bookmark"></i> Categories', 'items' =>
            [
                ['label' => '<i class="mdi mdi-view-list"></i> Overview', 'url' => ['/categories']],
                ['label' => '<i class="mdi mdi-plus"></i> Create', 'url' => ['/categories/create']]
            ]
        ];
        $menuItems[] = ['label' => '<i class="mdi mdi-translate"></i> Languages', 'items' =>
            [
                ['label' => '<i class="mdi mdi-view-list"></i> Overview', 'url' => ['/languages']],
                ['label' => '<i class="mdi mdi-plus"></i> Create', 'url' => ['/languages/create']]
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
