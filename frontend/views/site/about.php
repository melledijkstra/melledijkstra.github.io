<?php

/* @var $this yii\web\View */

use frontend\assets\P5Asset;

P5Asset::register($this);

$this->registerJsFile('//platform.twitter.com/widgets.js', [
    'async' => '',
    'charset' => 'utf-8',
]);

$this->title = 'About';

?>
<div class="site-about">
    <iframe class="block background-sketch full-height affix" src="<?= \yii\helpers\Url::to(['/sketches/ConnectedLines/index.html']); ?>"></iframe>
    <div class="jumbotron">
        <img src="/images/me_in_mountains.jpg"
             class="mel-about-image img-circle" alt="image of myself"/>
    </div>
    <div class="container-fluid padding-tb-20">
        <div class="row">
            <div class="col col-xs-12 col-md-6 col-lg-3">
                <div class="card">
                    <div class="card-content">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid animi aperiam aspernatur culpa doloribus eius, fuga ipsa iste magnam natus numquam odio officia porro quas quidem rem sed sit totam.
                    </div>
                </div>
            </div>
            <div class="col col-xs-12 col-md-6 col-lg-3">
                <div class="card">
                    <div class="card-content">
                        Hi this is me!, bla die bla die bla
                    </div>
                </div>
            </div>
            <div class="col col-xs-12 col-md-6 col-lg-3">
                text
            </div>
            <div class="col col-xs-12 col-md-6 col-lg-3">

            </div>
            <div class="col col-xs-12 col-md-6 col-lg-3">
                <div class="card">
                    <div class="card-content">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid animi aperiam aspernatur culpa doloribus eius, fuga ipsa iste magnam natus numquam odio officia porro quas quidem rem sed sit totam.
                    </div>
                </div>
            </div>
            <div class="col col-xs-12 col-md-6 col-lg-3">
                <div class="card">
                    <div class="card-content">
                        Hi this is me!, bla die bla die bla
                    </div>
                </div>
            </div>
            <div class="col col-xs-12 col-md-6 col-lg-3">
                <a href="https://twitter.com/intent/tweet?screen_name=dijkstrascience" class="twitter-mention-button"
                   data-related="" data-show-count="true">Tweet to @dijkstrascience</a>
            </div>
            <div class="col col-xs-12 col-md-6 col-lg-3">

            </div>
            <div class="col col-xs-12 col-md-6 col-lg-3">
                <div class="card">
                    <div class="card-content">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid animi aperiam aspernatur culpa doloribus eius, fuga ipsa iste magnam natus numquam odio officia porro quas quidem rem sed sit totam.
                    </div>
                </div>
            </div>
            <div class="col col-xs-12 col-md-6 col-lg-3">
                <div class="card">
                    <div class="card-content">
                        Hi this is me!, bla die bla die bla
                    </div>
                </div>
            </div>
            <div class="col col-xs-12 col-md-6 col-lg-3">
                text
            </div>
            <div class="col col-xs-12 col-md-6 col-lg-3">

            </div>
            <div class="col col-xs-12 col-md-6 col-lg-3">
                <div class="card">
                    <div class="card-content">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid animi aperiam aspernatur culpa doloribus eius, fuga ipsa iste magnam natus numquam odio officia porro quas quidem rem sed sit totam.
                    </div>
                </div>
            </div>
            <div class="col col-xs-12 col-md-6 col-lg-3">
                <div class="card">
                <div class="card-content">
                        Hi this is me!, bla die bla die bla
                    </div>
                </div>
            </div>
            <div class="col col-xs-12 col-md-6 col-lg-3">
                text
            </div>
            <div class="col col-xs-12 col-md-6 col-lg-3">

            </div>
            <div class="col col-xs-12 col-md-6 col-lg-3">
                <div class="card">
                    <div class="card-content">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid animi aperiam aspernatur culpa doloribus eius, fuga ipsa iste magnam natus numquam odio officia porro quas quidem rem sed sit totam.
                    </div>
                </div>
            </div>
            <div class="col col-xs-12 col-md-6 col-lg-3">
                <div class="card">
                    <div class="card-content">
                        Hi this is me!, bla die bla die bla
                    </div>
                </div>
            </div>
            <div class="col col-xs-12 col-md-6 col-lg-3">
                text
            </div>
            <div class="col col-xs-12 col-md-6 col-lg-3">

            </div>
        </div>
    </div>
</div>
