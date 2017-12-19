<?php
/**
 * @link https://github.com/yiimaker/yii2-email-templates
 * @copyright Copyright (c) 2017 Yii Maker
 * @license BSD 3-Clause License
 */

namespace ymaker\email\templates\controllers;

use Yii;
use yii\web\Controller;
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
    protected $service;


    /**
     * @inheritdoc
     */
    public function __construct($id, $module, ServiceInterface $service, $config = [])
    {
        $this->service = $service;
        parent::__construct($id, $module, $config);
    }

    /**
     * Renders models list.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index', [
            'dataProvider' => $this->service->getDataProvider(),
        ]);
    }

    /**
     * Creates new model.
     *
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        return $this->commonAction($this->service->getModel(), ['index'], 'create');
    }

    /**
     * Updates model.
     *
     * @param int $id
     * @return string|\yii\web\Response
     */
    public function actionUpdate($id)
    {
        return $this->commonAction(
            $this->service->getModel($id),
            ['view', 'id' => $id],
            'update'
        );
    }

    /**
     * Common code for create and update actions.
     *
     * @param \yii\db\ActiveRecord $model
     * @param array $redirectUrl
     * @param string $view
     * @return string|\yii\web\Response
     */
    protected function commonAction($model, $redirectUrl, $view)
    {
        $request = Yii::$app->getRequest();
        if ($request->getIsPost() && $this->service->save($request->post())) {
            return $this->redirect($redirectUrl);
        }
        return $this->render($view, compact('model'));
    }

    /**
     * Renders details about model.
     *
     * @param int $id Model ID.
     * @return string
     */
    public function actionView($id)
    {
        $model = $this->service->getModel($id);
        return $this->render('view', compact('model'));
    }

    /**
     * Delete model.
     *
     * @param int $id
     * @return \yii\web\Response
     */
    public function actionDelete($id)
    {
        $message = 'Error: banner not removed';
        if ($this->service->delete($id)) {
            $message = 'Removed successfully';
        }
        Yii::$app->getSession()->setFlash('yii2-email-templates', $message);

        return $this->redirect(['index']);
    }
}
