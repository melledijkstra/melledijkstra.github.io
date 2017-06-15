<?php

/* @var $this yii\web\View */

$this->registerJsFile('//platform.twitter.com/widgets.js', [
    'async' => '',
    'charset' => 'utf-8',
]);

$this->title = 'About';

?>
<div class="site-about">
    <div class="jumbotron">
        <img style="height: 200px;width: auto;" src="/images/melle_mountains_square.jpg"
             class="mel-about-image img-circle" alt="image of myself"/>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col col-xs-12 col-md-6 col-lg-3">
                <div class="card">
                    text
                </div>
            </div>
            <div class="col col-xs-12 col-md-6 col-lg-3">
                <div class="card">
                    <p>Hi this is me!, bla die bla die bla</p>
                </div>
            </div>
            <div class="col col-xs-12 col-md-6 col-lg-3">
                <a href="https://twitter.com/intent/tweet?screen_name=dijkstrascience" class="twitter-mention-button"
                   data-related="" data-show-count="true">Tweet to @dijkstrascience</a>
            </div>
            <div class="col col-xs-12 col-md-6 col-lg-3">

            </div>
        </div>
    </div>
</div>
