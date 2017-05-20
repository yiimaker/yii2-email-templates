<?php
/**
 * @link https://github.com/yiimaker/yii2-email-templates
 * @copyright Copyright (c) 2017 Yii Maker
 * @license BSD 3-Clause License
 */

namespace ymaker\email\templates\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use ymaker\email\templates\models\entities\EmailTemplate;
use ymaker\email\templates\services\ServiceInterface;

/**
 * CRUD controller for backend
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 * @since 1.0
 */
class DefaultController extends Controller
{
    /**
     * Email templates service instance.
     * Instance will be gotten from DI container
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
     * Find email template model by ID
     *
     * @param integer $id Model ID
     * @return EmailTemplate
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if ($model = EmailTemplate::findOne($id)) {
            return $model;
        }

        throw new NotFoundHttpException('Email template not found!');
    }

    /**
     * Renders data provider with all template models
     *
     * @return string
     */
    public function actionIndex()
    {
        $query = EmailTemplate::find()->with('translations');
        $dataProvider = $this->_service->getDataProvider($query);

        return $this->render('index', compact('dataProvider'));
    }

    /**
     * Create email template model
     *
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $request = Yii::$app->getRequest();
        if ($request->getIsPost()) {
            $res = $this->_service->create($request->post());
            if (is_array($res)) {
                $errors = $res;
            } else {
                return $this->redirect(['index']);
            }
        }
        $template = $this->_service->getModel();
        $translation = $this->_service->getTranslationModel();

        return $this->render('create', compact([
            'errros',
            'template',
            'translation',
        ]));
    }

    /**
     * View email template models detail
     *
     * @param integer $id
     * @param null|string $lang
     * @return string
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
     * Update email template model
     *
     * @param integer $id Model ID
     * @param null|string $lang Model language
     * @return string|\yii\web\Response
     */
    public function actionUpdate($id, $lang = null)
    {
        $lang = $lang ?: Yii::$app->language;
        $template = $this->findModel($id);
        $translation = $this->_service->getTranslationModel($id, $lang);

        $request = Yii::$app->getRequest();
        if ($request->getIsPost()) {
            $res = $this->_service->update($template, $translation, $request->post());
            if (is_array($res)) {
                $errors = $res;
            } else {
                return $this->redirect(['view', 'id' => $id]);
            }
        }

        return $this->render('update', compact([
            'errors',
            'template',
            'translation',
        ]));
    }

    /**
     * Delete email template model
     *
     * @param integer $id Model ID
     * @return \yii\web\Response
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }
}
