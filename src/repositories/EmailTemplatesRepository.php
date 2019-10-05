<?php
/**
 * @link https://github.com/yiimaker/yii2-email-templates
 * @copyright Copyright (c) 2017-2019 Yii Maker
 * @license BSD 3-Clause License
 */

namespace ymaker\email\templates\repositories;

use Yii;
use yii\base\BaseObject;
use yii\data\ActiveDataProvider;
use yii\db\Connection;
use yii\di\Instance;
use ymaker\email\templates\entities\EmailTemplate;
use ymaker\email\templates\entities\EmailTemplateTranslation;

/**
 * Repository for email templates.
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 * @since 4.0
 */
class EmailTemplatesRepository extends BaseObject implements EmailTemplatesRepositoryInterface
{
    /**
     * @var array|Connection|string
     */
    private $_db = 'db';


    /**
     * @param array|Connection|string $db
     */
    public function setDb($db)
    {
        $this->_db = $db;
    }

    /**
     * Initialize connection to database.
     *
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        $this->_db = Instance::ensure($this->_db, Connection::class);
    }

    /**
     * Find email template entity by ID.
     *
     * @param int $id
     *
     * @return null|EmailTemplate
     */
    public function getById($id)
    {
        return EmailTemplate::find()
            ->where(['id' => $id])
            ->with('translations')
            ->one();
    }

    /**
     * Find template by key with translation.
     *
     * @param string $key
     * @param string $language
     *
     * @return null|EmailTemplate
     */
    public function getByKeyWithTranslation($key, $language)
    {
        return EmailTemplate::find()
            ->byKey($key)
            ->withTranslation($language)
            ->one();
    }

    /**
     * Find all language versions of template by key.
     *
     * @param string $key
     *
     * @return null|EmailTemplateTranslation[]
     */
    public function getAll($key)
    {
        $template = EmailTemplate::find()
            ->byKey($key)
            ->with('translations')
            ->one();

        return empty($template->translations) ? null : $template->translations;
    }

    /**
     * Returns data provider for email template entity.
     *
     * @return ActiveDataProvider
     */
    public function getDataProvider()
    {
        return new ActiveDataProvider([
            'db' => $this->_db,
            'query' => EmailTemplate::find()->with('translations'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function has($key)
    {
        return EmailTemplate::find()->byKey($key)->exists();
    }

    /**
     * Creates new email template model.
     *
     * @return EmailTemplate
     */
    public function create()
    {
        return (new EmailTemplate())->loadDefaultValues();
    }

    /**
     * Save entity.
     *
     * @param EmailTemplate $entity
     * @param array         $data
     *
     * @return bool
     */
    public function save($entity, array $data = [])
    {
        try {
            if (empty($data)) {
                return $entity->save();
            }

            $this->saveInternal($entity, $data);

            return true;
        } catch (\Exception $ex) {
            Yii::$app->getErrorHandler()->logException($ex);
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function delete($id)
    {
        try {
            if ($model = $this->getById($id)) {
                return (bool) $model->delete();
            }
        } catch (\Exception $ex) {
            Yii::$app->getErrorHandler()->logException($ex);
        }

        return false;
    }

    /**
     * Removes email template object.
     *
     * @param EmailTemplate $entity
     *
     * @return bool
     */
    public function deleteObject($entity)
    {
        try {
            return (bool) $entity->delete();
        } catch (\Exception $ex) {
            Yii::$app->getErrorHandler()->logException($ex);

            return false;
        }
    }

    /**
     * Save entity to database.
     *
     * @param EmailTemplate $entity
     * @param array $data
     *
     * @throws \DomainException
     * @throws \RuntimeException
     */
    protected function saveInternal(EmailTemplate $entity, array $data)
    {
        if ($entity->getIsNewRecord() && !$entity->load($data)) {
            throw new \DomainException('Cannot load data to primary model');
        }

        foreach ($data[EmailTemplateTranslation::internalFormName()] as $language => $dataSet) {
            $translationEntity = $entity->getTranslation($language);

            foreach ($dataSet as $attribute => $translation) {
                $translationEntity->$attribute = $translation;
            }
        }

        if (!$entity->save()) {
            throw new \RuntimeException();
        }
    }
}
