<?php
/**
 * @link https://github.com/yiimaker/yii2-email-templates
 * @copyright Copyright (c) 2017 Yii Maker
 * @license BSD 3-Clause License
 */

namespace ymaker\email\templates\widgets;

use Yii;
use yii\base\Widget;
use yii2deman\tools\i18n\LanguageProviderInterface;

/**
 * Renders list of languages from language provider
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 * @since 1.0
 */
class LanguagesList extends Widget
{
    /**
     * @var string
     */
    public $currentLanguage;

    /**
     * @var array
     */
    protected $_languages = [];


    /**
     * @inheritdoc
     */
    public function init()
    {
        /** @var LanguageProviderInterface $provider */
        $provider = Yii::$container->get(LanguageProviderInterface::class);
        $this->_languages = $provider->getLanguages();

        if (!empty($this->currentLanguage)) {
            foreach ($this->_languages as $key => $language) {
                if ($language['locale'] == $this->currentLanguage) {
                    $this->currentLanguage = $language;
                    unset($this->_languages[$key]);
                    break;
                }
            }
        }
    }
    
    /**
     * @inheritdoc
     */
    public function run()
    {
        return $this->render('languages', [
            'languages' => $this->_languages,
        ]);
    }
}
