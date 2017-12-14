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
use yii\web\NotFoundHttpException;
use ymaker\email\templates\models\entities\EmailTemplate;
use ymaker\email\templates\models\entities\EmailTemplateTranslation;

/**
 * Email template service.
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 * @since 3.0
 */
class EmailTemplateService extends Object implements ServiceInterface
{
    /**
     * @var string|array|Connection
     */
    private $_db = 'db';
    /**
     * @var EmailTemplate
     */
    private $_model;


    /**
     * @param string|array|Connection $db
     */
    public function setDb($db)
    {
        $this->_db = $db;
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->_db = Instance::ensure($this->_db, Connection::class);
    }

    /**
     * @return \yii\data\ActiveDataProvider
     */
    public function getDataProvider()
    {
        return new ActiveDataProvider([
            'db' => $this->_db,
            'query' => EmailTemplate::find()->with('translations'),
        ]);
    }

    /**
     * @param int $id
     * @return EmailTemplate
     * @throws NotFoundHttpException
     */
    private function findModel($id)
    {
        if ($model = EmailTemplate::findOne($id)) {
            return $model;
        }
        throw new NotFoundHttpException();
    }

    /**
     * Returns primary model object.
     *
     * @param null|int $id
     * @return EmailTemplate
     * @throws NotFoundHttpException
     */
    public function getModel($id = null)
    {
        if ($id === null) {
            $model = new EmailTemplate();
            $model->loadDefaultValues();
            $this->_model = $model;
        } else {
            $this->_model = $this->findModel($id);
        }

        return $this->_model;
    }

    /**
     * Save banner to database.
     *
     * @param array $data
     * @throws \DomainException
     * @throws \RuntimeException
     */
    protected function saveInternal(array $data)
    {
        if ($this->_model->getIsNewRecord() && !$this->_model->load($data)) {
            throw new \DomainException('Cannot load data to primary model');
        }
        foreach ($data[EmailTemplateTranslation::internalFormName()] as $language => $dataSet) {
            $model = $this->_model->getTranslation($language);
            foreach ($dataSet as $attribute => $translation) {
                $model->$attribute = $translation;
            }
        }

        if (!$this->_model->save()) {
            throw new \RuntimeException();
        }
    }

    /**
     * Save banner and log exceptions.
     *
     * @param array $data
     * @return bool
     */
    public function save(array $data)
    {
        try {
            $this->saveInternal($data);
            return true;
        } catch (\Exception $ex) {
            Yii::$app->getErrorHandler()->logException($ex);
        }
        return false;
    }

    /**
     * Removes banner.
     *
     * @param int $id
     * @return bool
     * @throws NotFoundHttpException
     */
    public function delete($id)
    {
        $model = $this->findModel($id);
        try {
            return (bool)$model->delete();
        } catch (\Exception $ex) {
            Yii::$app->getErrorHandler()->logException($ex);
        }
        return false;
    }
}
