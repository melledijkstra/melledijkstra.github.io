<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>
<div class="container-fluid">
    <div class="site-error">

        <h1><?= Html::encode($this->title) ?> <i class="mdi mdi-flash"></i></h1>

        <div class="alert alert-danger">
            <?= nl2br(Html::encode($message)) ?>
        </div>
        <p>
            The above error occurred while the Web server was processing your request.
        </p>
        <p>
            Please <a href="mailto:dev.melle@gmail.com">contact me</a> if you think this is a server error. Thank you. <i class="mdi mdi-thumb-up"></i>
        </p>
        <div class="text-center">
            <i class="mdi mdi-emoticon-dead text-center" style="font-size: 4em"></i>
        </div>

    </div>
</div>