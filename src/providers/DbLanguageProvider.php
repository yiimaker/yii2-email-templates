<?php
/**
 * @link https://github.com/yiimaker/yii2-email-templates
 * @copyright Copyright (c) 2017 Yii Maker
 * @license BSD 3-Clause License
 */

namespace ymaker\email\templates\providers;

use yii\db\Query;
use yii\di\Instance;

/**
 * Database language provider
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 * @since 1.0
 */
class DbLanguageProvider implements LanguageProviderInterface
{
    /**
     * @var \yii\db\Connection
     */
    public $db = 'db';
    /**
     * @var string
     */
    public $tableName = 'language';
    /**
     * @var string
     */
    public $localeField = 'locale';
    /**
     * @var string
     */
    public $nameField = 'name';
    /**
     * @var string
     */
    public $defaultField = 'is_default';


    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->db = Instance::ensure($this->db);
    }

    /**
     * @inheritdoc
     */
    public function getLanguages()
    {
        $languages = (new Query())
            ->select([$this->localeField, $this->nameField])
            ->from($this->tableName)
            ->all($this->db);

        $result = [];
        foreach ($languages as $language) {
            $result[] = [
                'locale' => $language->{$this->localeField},
                'title' => $language->{$this->nameField}
            ];
        }

        return $result;
    }

    /**
     * @inheritdoc
     */
    public function getDefaultLanguage()
    {
        $language = (new Query())
            ->select([$this->localeField, $this->nameField])
            ->from($this->tableName)
            ->where([$this->defaultField => true])
            ->one($this->db);

        return $language !== null
            ? [
                'locale' => $language->{$this->localeField},
                'title' => $language->{$this->nameField}
            ]
            : [];
    }
}
