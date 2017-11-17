<?php
/**
 * @link https://github.com/yiimaker/yii2-email-templates
 * @copyright Copyright (c) 2017 Yii Maker
 * @license BSD 3-Clause License
 */

namespace ymaker\email\templates\widgets;

use Yii;
use yii\base\Widget;
use motion\i18n\LanguageProviderInterface;

/**
 * Renders list of languages from language provider.
 *
 * @property string $currentLanguage
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 * @since 1.0
 */
class LanguagesList extends Widget
{
    /**
     * @var string
     */
    protected $_currentLanguage;
    /**
     * @var array
     */
    protected $_languages = [];
    /**
     * @var string
     */
    protected $_currentLangLabel;


    /**
     * Setter for current language.
     *
     * @param string $value
     * @since 2.0
     */
    public function setCurrentLanguage($value)
    {
        $this->_currentLanguage = $value;
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        /** @var LanguageProviderInterface $provider */
        $provider = Yii::$container->get(LanguageProviderInterface::class);
        $this->_languages = $provider->getLanguages();

        if (!empty($this->_currentLanguage)) {
            foreach ($this->_languages as $key => $language) {
                if ($language['locale'] == $this->_currentLanguage) {
                    $this->_currentLangLabel = $language['label'];
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
            'currentLangLabel' => $this->_currentLangLabel,
        ]);
    }
}
