<?php

namespace common\components;

use yii\i18n\MissingTranslationEvent;

/**
 * Created by PhpStorm.
 * User: Melle Dijkstra
 * Date: 20-8-2016
 * Time: 18:27
 */
class TranslationEventHandler {

    public static function handleMissingTranslation(MissingTranslationEvent $event) {
        $event->translatedMessage = "!TRANSLATION MISSING ({$event->category}.{$event->message}) LANGUAGE ({$event->language})!";
    }

}