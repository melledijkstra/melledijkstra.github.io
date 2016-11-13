<?php
/**
 * Created by PhpStorm.
 * User: melle
 * Date: 13-11-2016
 * Time: 18:03
 */

namespace common\components;


use yii\i18n\MissingTranslationEvent;

class TranslationEventHandler
{
    public static function handleMissingTranslation(MissingTranslationEvent $event) {
        $event->translatedMessage = "@MISSING: {$event->category}.{$event->message} FOR LANGUAGE {$event->language} @";
    }
}