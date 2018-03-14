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
    'Problem Solving' => [
        80,
        '',
    ],
    'Design Patterns' => [
        75,
        'It doesn\'t matter which language you use, it matters how you use it',
    ],
    'Web Development' => [
        95,
        'Frontend, Backend. You name it, I\'ve mastered the web'
    ],
    'Computer Networks' => [
        60,
        'I\'ve setup multiple servers and like to work with IoT'
    ],
    'Android (Java)' => [
        65,
        'Made several Android apps for remote controlling arduino, music player, etc.'
    ],
    'Javascript' => [
        86,
        'Javascript was the first language I started with!'
    ],
    'Photoshop / Illustrator' => [
        30,
        'I use it for personal projects and to improve arty skills!'
    ],
];

$softwareList = [
    'Jetbrains Products' => '/images/resume/software/logo-jetbrains.png',
    'PHPStorm' => '/images/resume/software/logo-phpstorm.png',
    'Yii2 Framework' => '/images/resume/software/logo-yii2.png',
    'Arduino' => '/images/resume/software/logo-arduino.png',
    'PyCharm' => '/images/resume/software/logo-pycharm.png',
    'Git' => '/images/resume/software/logo-git.png',
];

$this->registerCss(<<<CSS
#page-content {
    position: relative;
    background-color: #070909;
    color: #fefefe;
}
CSS
);

$this->registerMetaTag([
    'name' => 'description',
    'content' => 'Hi! My name is Melle Dijkstra. A enthusiastic computer scientist who\'s passionate for all kinds of science',
]);

$CVFile = '/files/CV-Melle-Dijkstra-EN.pdf';

?>
<div id="resume-page">
    <div id="slanted-box">
        <div class="row more-padding">
            <div class="col col-xs-12"><span class="text-lg">Hi,</span></div>
        </div>
        <div class="row more-padding margin-tb-10">
            <div class="col col-lg-6 col-md-6">
                <p>
                    My name is <strong>Melle Dijkstra</strong>. An enthusiastic computer scientist who's passionate
                    for all kinds of science - Physics, Biology and Astrophysics and the
                    relation in them. Also love
                    traveling and Philosophy.
                </p>
                <p>
                    Currently I'm studying computer science at the Hanze University of Applied Sciences in Groningen.
                </p>
            </div>
            <div class="col col-xs-12 col-md-6 margin-t-20">
                <ul id="contact-list" class="list-unstyled">
                    <li><i class="mdi mdi-phone"></i> <a href="tel:+31611666686">(+31)611666686</a></li>
                    <li><i class="mdi mdi-email"></i> <a href="mailto:dev.melle@gmail.com">dev.melle@gmail.com</a></li>
                    <li><i class="mdi mdi-download"></i> <a target="_blank"
                                                            href="<?= $CVFile ?>">Europass
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
        <div class="row more-padding">
            <div class="col col-sm-12 col-md-6">
                <h3>· Skills</h3>
                <ul class="list-unstyled">
                    <?php foreach ($skills as $skill => $info): ?>
                        <li>
                            <div class="margin-tb-20">
                                <p class="no-margin"><?= $skill ?></p>
                                <small class="no-margin text-lightgrey"><?= $info[1]; ?></small>
                            </div>
                            <div class="skill-container">
                                <div class="skill" style="width: <?= $info[0]; ?>%;"></div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <p class="margin-tb-20">
                    <small class="text-sm">
                        These skills are demonstrated in the <a href="/guides">guides</a> I write on
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
                            <a target="_blank" href="https://www.hanze.nl/eng">
                                <img class="resume-logo grayscale" src="/images/resume/logo-hanze.png"
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
                                <img class="resume-logo grayscale" src="/images/resume/logo-bouw7.png"
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
                            <img class="resume-logo grayscale" src="/images/resume/logo-stroetenga-design.png"
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
                            <a target="_blank" href="http://kweekvijvernoord.com/">
                                <img class="resume-logo grayscale" src="/images/resume/logo-kweekvijvernoord.jpg"
                                     alt="Logo Kweekvijvernoord"/>
                            </a>
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
                <div class="text-center">
                    Please <a target="_blank" href="<?= $CVFile ?>">download <i class="mdi mdi-download"></i></a> my
                    resume for more in-depth information about my experiences
                </div>
            </div>
        </div>
        <div class="row more-padding">
            <div class="col col-xs-12">
                <h3>· Software & Tools I <span class="mdi mdi-heart"></span></h3>
            </div>
            <div class="col col-xs-12">
                <div id="software-container">
                    <div class="row no-gutter">
                        <?php foreach ($softwareList as $name => $url): ?>
                            <div class="software-item col-xs-6 col-md-3 col-lg-2 text-center">
                                <img class="resume-logo grayscale" src="<?= $url ?>"/>
                                <p><?= $name ?></p>
                            </div>
                        <?php endforeach; ?>
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
