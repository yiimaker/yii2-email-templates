<?php
/**
 * @link https://github.com/yiimaker/yii2-email-templates
 * @copyright Copyright (c) 2017 Yii Maker
 * @license BSD 3-Clause License
 */

namespace yii2deman\shop\common\widgets;

use Yii;
use yii\base\Widget;

use ymaker\email\templates\providers\LanguageProviderInterface;

/**
 * Renders list of languages from language provider
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 * @since 1.0
 */
class LanguagesList extends Widget
{
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
    }
    
    /**
     * @inheritdoc
     */
    public function run()
    {
        return $this->render('languages', [
            'languages' => $this->_languages
        ]);
    }
}
