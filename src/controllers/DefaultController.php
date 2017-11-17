<?php
/**
 * @link https://github.com/yiimaker/yii2-email-templates
 * @copyright Copyright (c) 2017 Yii Maker
 * @license BSD 3-Clause License
 */

namespace ymaker\email\templates\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use ymaker\email\templates\services\ServiceInterface;

/**
 * CRUD controller for backend.
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 * @since 1.0
 */
class DefaultController extends Controller
{
    /**
     * Email templates service instance.
     * Instance will be gotten from DI container.
     *
     * @var ServiceInterface
     */
    protected $_service;


    /**
     * @inheritdoc
     */
    public function __construct($id, $module, ServiceInterface $service, $config = [])
    {
        $this->_service = $service;
        parent::__construct($id, $module, $config);
    }

    /**
     * Find email template model by ID.
     *
     * @param integer $id Model ID.
     * @return \ymaker\email\templates\models\entities\EmailTemplate
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        $model = $this->_service->getModel($id);
        if ($model->getIsNewRecord()) {
            throw new NotFoundHttpException('Email template not found!');
        }
        return $model;
    }

    /**
     * Renders data provider with all template models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = $this->_service->getDataProvider();
        return $this->render('index', compact('dataProvider'));
    }

    /**
     * Create email template model.
     *
     * @param null|string $lang Model language.
     * @return string|\yii\web\Response
     */
    public function actionCreate($lang = null)
    {
        $request = Yii::$app->getRequest();
        $template = $this->_service->getModel();
        $translation = $this->_service->getTranslationModel(null, $lang);

        if ($request->getIsPost()) {
            if ($this->_service->create($request->post())) {
                return $this->redirect(['index']);
            }
            $errors = $this->_service->getErrors();
        }

        return $this->render('create', compact([
            'errors',
            'template',
            'translation',
        ]));
    }

    /**
     * View email template models details.
     *
     * @param integer $id Model ID.
     * @param null|string $lang Model language.
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id, $lang = null)
    {
        $lang = $lang ?: Yii::$app->language;
        $template = $this->findModel($id);
        $translation = $this->_service->getTranslationModel($id, $lang);

        return $this->render('view', compact([
            'template',
            'translation',
        ]));
    }

    /**
     * Update email template model.
     *
     * @param integer $id Model ID.
     * @param null|string $lang Model language.
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id, $lang = null)
    {
        $request = Yii::$app->getRequest();
        $template = $this->findModel($id);
        $translation = $this->_service->getTranslationModel($id, $lang ?: Yii::$app->language);

        if ($request->getIsPost()) {
            if ($this->_service->update($request->post())) {
                return $this->redirect(['view', 'id' => $id]);
            }
            $errors = $this->_service->getErrors();
        }

        $defaultTranslation = $this->_service->getDefaultTranslationModel($id);

        return $this->render('update', compact([
            'errors',
            'template',
            'translation',
            'defaultTranslation',
        ]));
    }

    /**
     * Delete email template model.
     *
     * @param integer $id Model ID.
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws \Exception
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }
}
