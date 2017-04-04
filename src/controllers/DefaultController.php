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
     * @param integer $id Email template ID
     * @return EmailTemplate
     * @throws NotFoundHttpException
     */
    protected function findTemplate($id)
    {
        if ($model = EmailTemplate::findOne($id)) {
            return $model;
        }

        throw new NotFoundHttpException('Email template not found!');
    }

    /**
     * Renders data provider with all templates
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => EmailTemplate::find()->with('translations')
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Create email template
     *
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $viewParams = [];
        $request = Yii::$app->getRequest();

        if ($request->getIsPost()) {
            $res = $this->_service->create($request->post());
            if (is_array($res)) {
                $viewParams['errors'] = $res;
            }
            else {
                return $this->redirect(['index']);
            }
        }

        $viewParams['template'] = $this->_service->getModel();
        $viewParams['translation'] = $this->_service->getTranslationModel();

        return $this->render('create', $viewParams);
    }

    /**
     * View email template detail
     *
     * @param integer $id
     * @param null|string $lang
     * @return string
     */
    public function actionView($id, $lang = null)
    {
        $lang = $lang ?: Yii::$app->language;
        $template = $this->findTemplate($id);
        $translation = $this->_service->getTranslationModel($id, $lang);

        return $this->render('view', [
            'template' => $template,
            'translation' => $translation
        ]);
    }

    /**
     * Update email template
     *
     * @param integer $id
     * @param null|string $lang
     * @return string|\yii\web\Response
     */
    public function actionUpdate($id, $lang = null)
    {
        $lang = $lang ?: Yii::$app->language;
        $template = $this->findTemplate($id);
        $translation = $this->_service->getTranslationModel($id, $lang);
        $request = Yii::$app->getRequest();

        if ($request->getIsPost()) {
            $res = $this->_service->update($template, $translation, $request->post());
            if (is_array($res)) {
                $viewParams['errors'] = $res;
            }
            else {
                return $this->redirect(['view', 'id' => $id]);
            }
        }

        return $this->render('update', [
            'template' => $template,
            'translation' => $translation
        ]);
    }

    public function actionDelete($id)
    {
        $this->findTemplate($id)->delete();
        return $this->redirect(['index']);
    }
}
