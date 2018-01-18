<?php

namespace frontend\controllers;

use Yii;
use common\models\Car;
use frontend\models\CarSearch;
use frontend\models\CarForm;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * CarController implements the CRUD actions for Car model.
 */
class CarController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'view'],
                        'allow' => true,
                        'roles' => ['?', '@'],
                    ],
                    [
                        'actions' => ['create', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Car models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CarSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Car model.
     * @param string $url
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($url)
    {
        return $this->render('view', [
            'model' => $this->findModelByUrl($url),
        ]);
    }

    /**
     * Creates a new Car model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Car();
        $model->status = Car::STATUS_ACTIVE;
        $form = new CarForm($model);

        if ($form->load(Yii::$app->request->post()) && $form->save()) {
            return $this->redirect(['view', 'url' => $form->url]);
        }

        return $this->render('create', [
            'model' => $form,
        ]);
    }

    /**
     * Updates an existing Car model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $form = new CarForm($model);

        if ($form->load(Yii::$app->request->post()) && $form->save()) {
            return $this->redirect(['view', 'url' => $form->url]);
        }

        return $this->render('update', [
            'model' => $form,
        ]);
    }

    /**
     * Deletes an existing Car model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $form = new CarForm($model);
        $form->deleteModelFile($model);
        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Car model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Car the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Car::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    /**
     * Finds the Car model based on its internal URL.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $url
     * @return Car the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModelByUrl($url)
    {
        if (($model = Car::find()->where(['url' => $url])->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
