<?php
/**
 * @link https://github.com/yiimaker/yii2-email-templates
 * @copyright Copyright (c) 2017-2018 Yii Maker
 * @license BSD 3-Clause License
 */

namespace ymaker\email\templates\controllers;

use Yii;
use yii\web\Controller;
use ymaker\email\templates\Module as TemplatesModule;
use ymaker\email\templates\repositories\EmailTemplatesRepositoryInterface;

/**
 * CRUD controller for backend.
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 * @since 1.0
 */
class DefaultController extends Controller
{
    /**
     * Email templates repository instance.
     * Instance will be gotten from DI container.
     *
     * @var EmailTemplatesRepositoryInterface
     */
    protected $repository;


    /**
     * {@inheritdoc}
     */
    public function __construct($id, $module, EmailTemplatesRepositoryInterface $repository, $config = [])
    {
        $this->repository = $repository;

        parent::__construct($id, $module, $config);
    }

    /**
     * Renders entities list.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index', ['dataProvider' => $this->repository->getDataProvider()]);
    }

    /**
     * Creates new entity.
     *
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        return $this->commonAction($this->repository->create(), ['index'], 'create');
    }

    /**
     * Updates entity.
     *
     * @param int $id
     *
     * @return string|\yii\web\Response
     */
    public function actionUpdate($id)
    {
        return $this->commonAction($this->repository->getById($id), ['view', 'id' => $id], 'update');
    }

    /**
     * Renders entity details.
     *
     * @param int $id
     *
     * @return string
     */
    public function actionView($id)
    {
        return $this->render('view', ['model' => $this->repository->getById($id)]);
    }

    /**
     * Delete entity.
     *
     * @param int $id
     *
     * @return \yii\web\Response
     */
    public function actionDelete($id)
    {
        $message = $this->repository->delete($id)
            ? TemplatesModule::t('Removed successfully')
            : TemplatesModule::t('Error: banner not removed');

        Yii::$app->getSession()->setFlash('yii2-email-templates', $message);

        return $this->redirect(['index']);
    }

    /**
     * Common code for create and update actions.
     *
     * @param mixed $model
     * @param array $redirectUrl
     * @param string $view
     *
     * @return string|\yii\web\Response
     */
    protected function commonAction($model, $redirectUrl, $view)
    {
        $request = Yii::$app->getRequest();

        if ($request->getIsPost() && $this->repository->save($model, $request->post())) {
            return $this->redirect($redirectUrl);
        }

        return $this->render($view, compact('model'));
    }
}
