<?php


/* @var $this yii\web\View */
use yii\helpers\Url;

/* @var $project \common\models\Project */

$this->title = $project->title;

?>
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <h1><?= $project->title ?>
                <small class="badge"><?= Yii::$app->formatter->asDate($project->created_at); ?></small>
            </h1>
        </div>
        <div class="col-sm-<?= (count($project->guides) > 0) ? '10' : '12' ?>">
            <img src="<?= $project->getPublicLink(); ?>"/>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci consequuntur cum distinctio dolor
                eaque eius exercitationem inventore necessitatibus numquam odio, officiis pariatur placeat quia
                repellendus repudiandae sit veniam vero voluptatum.</p>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci consequuntur cum distinctio dolor
                eaque eius exercitationem inventore necessitatibus numquam odio, officiis pariatur placeat quia
                repellendus repudiandae sit veniam vero voluptatum.</p>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci consequuntur cum distinctio dolor
                eaque eius exercitationem inventore necessitatibus numquam odio, officiis pariatur placeat quia
                repellendus repudiandae sit veniam vero voluptatum.</p>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci consequuntur cum distinctio dolor
                eaque eius exercitationem inventore necessitatibus numquam odio, officiis pariatur placeat quia
                repellendus repudiandae sit veniam vero voluptatum.</p>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci consequuntur cum distinctio dolor
                eaque eius exercitationem inventore necessitatibus numquam odio, officiis pariatur placeat quia
                repellendus repudiandae sit veniam vero voluptatum.</p>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci consequuntur cum distinctio dolor
                eaque eius exercitationem inventore necessitatibus numquam odio, officiis pariatur placeat quia
                repellendus repudiandae sit veniam vero voluptatum.</p>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci consequuntur cum distinctio dolor
                eaque eius exercitationem inventore necessitatibus numquam odio, officiis pariatur placeat quia
                repellendus repudiandae sit veniam vero voluptatum.</p>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci consequuntur cum distinctio dolor
                eaque eius exercitationem inventore necessitatibus numquam odio, officiis pariatur placeat quia
                repellendus repudiandae sit veniam vero voluptatum.</p>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci consequuntur cum distinctio dolor
                eaque eius exercitationem inventore necessitatibus numquam odio, officiis pariatur placeat quia
                repellendus repudiandae sit veniam vero voluptatum.</p>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci consequuntur cum distinctio dolor
                eaque eius exercitationem inventore necessitatibus numquam odio, officiis pariatur placeat quia
                repellendus repudiandae sit veniam vero voluptatum.</p>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci consequuntur cum distinctio dolor
                eaque eius exercitationem inventore necessitatibus numquam odio, officiis pariatur placeat quia
                repellendus repudiandae sit veniam vero voluptatum.</p>
        </div>
        <?php if (count($project->guides) > 0): ?>
            <div class="col-sm-2">
                <ul class="affix">
                    <li><b>Related Guides</b></li>
                    <?php foreach ($project->guides as $guide): ?>
                        <li><a href="<?= Url::to('/guides/' . $guide->getTitle(true)) ?>"><?= $guide->title; ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
    </div>
</div>