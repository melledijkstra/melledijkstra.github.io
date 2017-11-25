<?php
/**
 * Created by PhpStorm.
 * User: melle
 * Date: 17-11-2017
 * Time: 22:20
 *
 * @var $this \yii\web\View
 * @var $projectDataProvider \yii\data\ActiveDataProvider
 */

use common\models\Project;

$this->title = \Yii::t('portfolio', 'Portfolio');

?>
<div class="container-fluid">
    <div class="text-center">
        <h1 class="margin-">Portfolio</h1>
    </div>
    <?php
    if ($projectDataProvider->count > 0) {
        $index = 0;
        foreach ($projectDataProvider->models as $project) {
            /** @var $project Project */
            echo $this->render('project_view_v2', compact('project', 'index'));
            ++$index;
        }
    }
    ?>
</div>