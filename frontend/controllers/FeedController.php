<?php
/**
 * Created by PhpStorm.
 * User: Melle Dijkstra
 * Date: 7-3-2017
 * Time: 09:22
 */

namespace frontend\controllers;


use common\models\Guide;
use frontend\components\feed\Entry;
use frontend\components\feed\Feed;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Response;

class FeedController extends Controller
{
    public function actionAtom() {
        // Set corresponding headers for the feed
        Yii::$app->response->format = Response::FORMAT_XML;
        // Yii::$app->response->headers->add() doesn't work when returning nothing in this action
        // So I just used old fashioned php headers() function
        header('Content-Type: text/xml; charset=utf-8');

        $query = Guide::find()->orderBy(['created_at' => SORT_DESC, 'updated_at' => SORT_DESC]);

        // data provider for retrieving Guide models
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        // retrieve latest guide to check
        /** @var Guide $latestGuide */
        $latestGuide = $query->one();

        $updated = ($latestGuide !== null) ?  $latestGuide->updated_at : 1488923760;
        // create the actual feed
        $feed = new Feed(Url::to('', true), Yii::$app->params['siteTitle'], $updated);
        $feed->subtitle = Yii::$app->params['siteSubtitle'];
        $feed->author = 'Melle Dijkstra';
        $feed->authorEmail = 'melle.dev@gmail.com';
        $feed->categories = ['Tech', 'Computer Science'];

        foreach($dataProvider->models as $guide) {
            /** @var $guide Guide */
            $entry = new Entry($guide->getLink(true), $guide->title, $guide->updated_at);
            $entry->author = $guide->createdBy->username;
            $entry->summary = $guide->sneak_peek;
            $entry->link = $guide->getLink(true);
            $entry->content = $guide->renderGuide();
            if($guide->hasFile()) {
                $entry->logo = $guide->getPublicLink(true);
            }
            $entry->categories = $guide->getCategories()->select('name')->column();
            $entry->published = $guide->created_at;
            $feed->addEntry($entry);
        }

        echo $feed->render();
        die();
    }
}