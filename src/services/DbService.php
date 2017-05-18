<?php
/**
 * @link https://github.com/yiimaker/yii2-email-templates
 * @copyright Copyright (c) 2017 Yii Maker
 * @license BSD 3-Clause License
 */

namespace ymaker\email\templates\services;

use Yii;
use yii\base\Object;
use yii\db\Connection;
use yii\di\Instance;
use yii\helpers\ArrayHelper;

use ymaker\email\templates\models\entities\EmailTemplate;
use ymaker\email\templates\models\entities\EmailTemplateTranslation;

/**
 * Database service
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 * @since 1.0
 */
class DbService extends Object implements ServiceInterface
{
    /**
     * Database connection instance
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
     * @inheritdoc
     */
    public function init()
    {
        $this->db = Instance::ensure($this->db, Connection::class);
    }

    /**
     * @inheritdoc
     */
    public function getModel()
    {
        return new EmailTemplate();
    }

    /**
     * @inheritdoc
     */
    public function getTranslationModel($modelId = null, $language = null)
    {
        if ($modelId !== null && $language !== null) {
            $params = [
                'templateId' => $modelId,
                'language' => $language
            ];
            $model = EmailTemplateTranslation::findOne($params);

            return $model ?: new EmailTemplateTranslation($params);
        }

        return new EmailTemplateTranslation();
    }

    /**
     * Load and validate data in models
     *
     * @param array $data Array with data for models
     * @return array|bool
     */
    protected function processData($data)
    {
        if ($this->_template->load($data) && $this->_translation->load($data)) {
            if ($this->_template->getIsNewRecord()) {
                $this->_translation->templateId = 0;
                $this->_translation->language = Yii::$app->language;
            }
            $validationErrors = [];
            if (!$this->_template->validate()) {
                $validationErrors = $this->_template->getErrors();
            }
            if (!$this->_translation->validate()) {
                return ArrayHelper::merge($validationErrors, $this->_translation->getErrors());
            }

            return true;
        }

        return false;
    }

    /**
     * Save model in database
     *
     * @param array $data
     * @return array|bool
     * @throws \Exception
     */
    public function create($data)
    {
        $this->_template = $this->getModel();
        $this->_translation = $this->getTranslationModel();

        $processRes = $this->processData($data);
        if (is_array($processRes)) {
            return $processRes;
        } elseif ($processRes === true) {
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
     * Save updates models data in database
     *
     * @param EmailTemplate $model
     * @param EmailTemplateTranslation $translation
     * @param array $data
     * @return array|bool
     * @throws \Exception
     */
    public function update($model, $translation, $data)
    {
        $this->_template = $model;
        $this->_translation = $translation;

        $processRes = $this->processData($data);
        if (is_array($processRes)) {
            return $processRes;
        } elseif ($processRes === true) {
            $transaction = $this->db->beginTransaction();
            try {
                $isSaved = $this->_template->save(false);
                $isSaved = $this->_translation->save(false) && $isSaved;
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
}
