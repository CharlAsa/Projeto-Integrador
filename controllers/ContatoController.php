<?php

namespace app\controllers;

use Yii;
use app\models\Contato;
use app\models\ContatoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ContatoController implements the CRUD actions for Contato model.
 */
class ContatoController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Contato models.
     * @return mixed
     */
    public function actionIndex()
    {
        if(!Yii::$app->user->isGuest){
			if(Yii::$app->user->identity->id_Yii == 2)
			{
                $searchModel = new ContatoSearch();
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

                return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                ]);
            }
            else{
                throw new NotFoundHttpException(Yii::t('app', 'Page not found.'));
            }
        }
    }

    /**
     * Displays a single Contato model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        if(!Yii::$app->user->isGuest){
			if(Yii::$app->user->identity->id_Yii == 2)
			{
                return $this->render('view', [
                    'model' => $this->findModel($id),
                ]);
            }
            else{
                throw new NotFoundHttpException(Yii::t('app', 'Page not found.'));
            }
        }

    }

    /**
     * Creates a new Contato model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if(!Yii::$app->user->isGuest){
			if(Yii::$app->user->identity->id_Yii == 2)
			{
                $model = new Contato();

                if ($model->load(Yii::$app->request->post()) && $model->save()) {
                    return $this->redirect(['view', 'id' => $model->id_usuario]);
                }

                return $this->render('create', [
                    'model' => $model,
                ]);
            }
            else{
                throw new NotFoundHttpException(Yii::t('app', 'Page not found.'));
            }
        }
    }

    /**
     * Updates an existing Contato model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        if(!Yii::$app->user->isGuest){
			if(Yii::$app->user->identity->id_Yii == 2)
			{
                $model = $this->findModel($id);

                if ($model->load(Yii::$app->request->post()) && $model->save()) {
                    return $this->redirect(['view', 'id' => $model->id_usuario]);
                }

                return $this->render('update', [
                    'model' => $model,
                ]);
            }
            else{
                throw new NotFoundHttpException(Yii::t('app', 'Page not found.'));
            }
        }
    }

    /**
     * Deletes an existing Contato model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if(!Yii::$app->user->isGuest){
			if(Yii::$app->user->identity->id_Yii == 2)
			{
                $this->findModel($id)->delete();

                return $this->redirect(['index']);
            }
            else{
                throw new NotFoundHttpException(Yii::t('app', 'Page not found.'));
            }
        }
    }

    /**
     * Finds the Contato model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Contato the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Contato::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
