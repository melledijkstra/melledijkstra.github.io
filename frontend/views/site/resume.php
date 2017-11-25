<?php
/**
 * Created by PhpStorm.
 * User: melle
 * Date: 11-11-2017
 * Time: 23:44
 *
 * @var $this \yii\web\View
 */

$this->registerCss('css/resume.css');
$this->title = 'Resume';

$skills = [
    'Problem Solving' => 80,
    'Design Patterns' => 60,
    'Web Development' => 60,
    'Android (Java)' => 90,
    'Javascript/jQuery' => 45,
    'PHP/MySQL' => 100,
    'Photoshop' => 20
];

$this->registerCss(<<<CSS
#page-content {
    position: relative;
    background-color: #070909;
    color: #fefefe;
}
CSS
);

?>
<!--<iframe class="block background-sketch full-height affix" src="--><? //= \yii\helpers\Url::to(['/sketches/ConnectedLines/index.html']); ?><!--"></iframe>-->
<div id="resume-page">
    <div id="slanted-box">
        <div class="row">
            <div class="col col-xs-12"><span class="text-lg">Hi,</span></div>
        </div>
        <div class="row margin-tb-10">
            <div class="col col-lg-6 col-md-6">
                <p>
                    My name is <strong>Melle Dijkstra</strong>. A enthusiastic computer scientist who's passionate
                    for all kinds of science - <i class="mdi mdi-lab"></i> Physics, Biology and Astrophysics and the
                    relation in them. Also love
                    traveling and Philosophy.
                </p>
                <p>
                    Currently I'm studying computer science at Hanze Hogeschool Groningen.
                </p>
            </div>
            <div class="col col-xs-12 col-md-6 margin-t-20">
                <ul id="contact-list" class="list-unstyled">
                    <li><i class="mdi mdi-phone"></i> <a href="tel:+31611666686">+31611666686</a></li>
                    <li><i class="mdi mdi-email"></i> <a href="mailto:dev.melle@gmail.com">dev.melle@gmail.com</a></li>
                    <li><i class="mdi mdi-download"></i> <a target="_blank"
                                                            href="/files/CV-Europass-Melle-Dijkstra-EN.pdf">Europass
                            CV</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="relative">
        <img id="photo-of-myself" src="/images/resume/melle-working.jpg" alt="Personal photo"/>
    </div>
    <div id="resume-part-2" class="container-fluid padding-tb-20">
        <div class="row">
            <div class="col col-sm-12 col-md-6">
                <h3>· Skills</h3>
                <ul class="list-unstyled">
                    <?php foreach ($skills as $skill => $progress): ?>
                        <li>
                            <div class="margin-tb-20">
                                <p class="no-margin"><?= $skill ?></p>
                                <small class="no-margin text-grey">Installed multiple webservers</small>
                            </div>
                            <div class="skill-container">
                                <div class="skill" style="width: <?= $progress; ?>%;"></div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <p class="margin-tb-20">
                    <small>These skills are demonstrated in the <a href="/guides">guides</a> on
                        this site.
                    </small>
                </p>
            </div>
            <div class="col col-sm-12 col-md-6">
                <h3>· Education</h3>
                <table class="resume-table">
                    <tbody>
                    <tr>
                        <td>
                            <a href="https://www.hanze.nl/eng">
                                <img class="resume-logo" src="/images/resume/logo-hanze-white.png"
                                     alt="Logo Hanzehogeschool Groningen"/>
                            </a>
                        </td>
                        <td>
                            <h4>Hanze Hogeschool Groningen</h4>
                            <p>
                                <small>Computer and Information Sciences, Bachelor of Science</small>
                            </p>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <h3>· Experience</h3>
                <table class="resume-table">
                    <tbody>
                    <tr>
                        <td>
                            <a target="_blank" href="https://bouw7.nl">
                                <img class="resume-logo" src="/images/resume/logo-bouw7-white.png"
                                     alt="Logo Bouw7"/>
                            </a>
                        </td>
                        <td>
                            <h4>Bouw7</h4>
                            <p>
                                <small>PHP Developer (Yii2 Framework)</small>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <img class="resume-logo" src="/images/resume/logo-stroetenga-design-white.png"
                                 alt="Logo Stroetenga Design"/>
                        </td>
                        <td>
                            <h4>Stroetenga Design</h4>
                            <p>
                                <small>Internship Application Developer</small>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <img class="resume-logo" src="/images/resume/logo-kweekvijvernoord-white.jpg"
                                 alt="Logo Kweekvijvernoord"/>
                        </td>
                        <td>
                            <h4>Kweekvijvernoord</h4>
                            <p>
                                <small>Internship Application Developer</small>
                            </p>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col col-xs-12">
                <h3>· Software & Tools I <span class="mdi mdi-heart"></span></h3>
            </div>
            <div class="col col-xs-12">
                <div id="software-container">
                    <div class="pull-left text-center margin-lr-20">
                        <img class="resume-logo" src="/images/resume/software/logo-jetbrains.png"/>
                        <p>Jetbrains Products</p>
                    </div>
                    <div class="pull-left text-center margin-lr-20">
                        <img class="resume-logo" src="/images/resume/software/logo-phpstorm.png"/>
                        <p>PHPStorm</p>
                    </div>
                    <div class="pull-left text-center margin-lr-20">
                        <img class="resume-logo" src="/images/resume/software/logo-yii2.png"/>
                        <p>Yii2 Framework</p>
                    </div>
                    <div class="pull-left text-center margin-lr-20">
                        <img class="resume-logo" src="/images/resume/software/logo-arduino.png"/>
                        <p>Arduino</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Unsplash Credits -->
        <div class="margin-tb-10 text-center">
            <small>
                Background by <a
                        href="https://unsplash.com/photos/fUd_0iyYFVg?utm_source=unsplash&utm_medium=referral&utm_content=creditCopyText">Joshua
                    Newton</a> on <a
                        href="https://unsplash.com/?utm_source=unsplash&utm_medium=referral&utm_content=creditCopyText">Unsplash</a>
            </small>
        </div>
    </div>
</div>
