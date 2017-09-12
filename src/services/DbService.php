<?php
/**
 * @link https://github.com/yiimaker/yii2-email-templates
 * @copyright Copyright (c) 2017 Yii Maker
 * @license BSD 3-Clause License
 */

namespace ymaker\email\templates\services;

use Yii;
use yii\base\Object;
use yii\data\ActiveDataProvider;
use yii\db\Connection;
use yii\di\Instance;
use yii\helpers\ArrayHelper;
use ymaker\email\templates\models\entities\EmailTemplate;
use ymaker\email\templates\models\entities\EmailTemplateTranslation;

/**
 * Database service.
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 * @since 1.0
 */
class DbService extends Object implements ServiceInterface
{
    /**
     * Database connection instance.
     *
     * @var \yii\db\Connection
     */
    public $db = 'db';

    /**
     * @var EmailTemplate
     */
    protected $_template;
    /**
     * @var EmailTemplateTranslation
     */
    protected $_translation;
    /**
     * @var array errors from model.
     * @since 2.1
     */
    private $_errors = [];


    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->db = Instance::ensure($this->db, Connection::class);
    }

    /**
     * @inheritdoc
     */
    public function getModel($id = null)
    {
        if ($id !== null && ($model = EmailTemplate::findOne($id))) {
            return $model;
        }
        return new EmailTemplate();
    }

    /**
     * @inheritdoc
     */
    public function getTranslationModel($modelId = null, $language = null)
    {
        $params = [
            'templateId' => $modelId,
            'language' => $language ?: Yii::$app->language,
        ];

        if (($modelId !== null && $language !== null) &&
            $model = EmailTemplateTranslation::findOne($params)) {
            return $model;
        }

        return new EmailTemplateTranslation($params);
    }

    /**
     * @inheritdoc
     */
    public function getDefaultTranslationModel($modelId)
    {
        return EmailTemplateTranslation::findOne(['templateId' => $modelId]);
    }

    /**
     * @inheritdoc
     */
    public function getDataProvider()
    {
        return new ActiveDataProvider([
            'query' => EmailTemplate::find()->with('translations'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function getErrors()
    {
        return $this->_errors;
    }

    /**
     * Load and validate data in models.
     *
     * @param array $data Array with data for models.
     * @return array|bool
     */
    protected function processData(array $data)
    {
        if ($this->_template->load($data) && $this->_translation->load($data)) {
            if ($this->_template->validate() && $this->_translation->validate()) {
                return true;
            } else {
                $this->_errors = ArrayHelper::merge(
                    $this->_template->getErrors(),
                    $this->_translation->getErrors()
                );
            }
        }
        return false;
    }

    /**
     * Save model in database.
     *
     * @param array $data
     * @return bool
     * @throws \Exception
     */
    public function create($data)
    {
        $this->_template = $this->getModel();
        $this->_translation = $this->getTranslationModel();
        $this->_translation->templateId = 0;

        if ($this->processData($data)) {
            $transaction = $this->db->beginTransaction();
            try {
                $isSaved = $this->_template->insert(false);
                $this->_translation->templateId = $this->_template->id;
                $isSaved = $this->_translation->insert(false) && $isSaved;
                if ($isSaved) {
                    $transaction->commit();
                    return true;
                }
                $transaction->rollBack();
            } catch (\Exception $ex) {
                $transaction->rollBack();
                throw $ex;
            }
        }

        return false;
    }

    /**
     * Save updates models data in database.
     *
     * @param EmailTemplateTranslation $translation
     * @param array $data
     * @return array|bool
     * @throws \Exception
     */
    public function update($translation, $data)
    {
        $this->_translation = $translation;

        if ($this->_translation->load($data)) {
            if (!$this->_translation->validate()) {
                return $this->_translation->getErrors();
            }
            return $this->_translation->save(false);
        }

        return false;
    }
}
