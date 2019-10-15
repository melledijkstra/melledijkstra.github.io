<?php

$this->title = $this->title ?: 'A forgotten title';

// Set canonical for SEO
$this->registerLinkTag(['rel' => 'canonical', 'href' => \yii\helpers\Url::canonical()]);

?>
<body>
<?php $this->beginBody() ?>
<div id="wrap">
    <div id="page-content">
        <?= Alert::widget(); ?>
        <?= $content ?>
    </div>
</div>
<?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage(); ?>
