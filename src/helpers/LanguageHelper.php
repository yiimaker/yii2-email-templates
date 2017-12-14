<?php
/**
 * @link https://github.com/yiimaker/yii2-email-templates
 * @copyright Copyright (c) 2017 Yii Maker
 * @license BSD 3-Clause License
 */

namespace ymaker\email\templates\helpers;

use Yii;
use motion\i18n\LanguageProviderInterface;

/**
 * Language helper.
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 * @since 3.0
 */
class LanguageHelper
{
    /**
     * Returns languages locales list.
     *
     * @return array
     */
    public static function getLocales()
    {
        /* @var LanguageProviderInterface $languageProvider */
        $languageProvider = Yii::$container->get(LanguageProviderInterface::class);
        return array_column($languageProvider->getLanguages(), 'locale');
    }
}
