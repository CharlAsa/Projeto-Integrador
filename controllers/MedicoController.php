<?php

namespace app\controllers;

use Yii;
use app\models\Medico;
use app\models\MedicoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MedicoController implements the CRUD actions for Medico model.
 */
class MedicoController extends Controller
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
     * Lists all Medico models.
     * @return mixed
     */
    public function actionIndex()
    {
        if(!Yii::$app->user->isGuest){
            $searchModel = new MedicoSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }
        else{
			return $this->redirect(['site/login']);
		}
    }

    /**
     * Displays a single Medico model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        if(!Yii::$app->user->isGuest){
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
        else{
			return $this->redirect(['site/login']);
		}
    }

    /**
     * Creates a new Medico model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if(!Yii::$app->user->isGuest){
            $model = new Medico();

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id_usuario]);
            }

            return $this->render('create', [
                'model' => $model,
            ]);
        }
        else{
			return $this->redirect(['site/login']);
		}
    }

    /**
     * Updates an existing Medico model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        if(!Yii::$app->user->isGuest){
            $model = $this->findModel($id);

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id_usuario]);
            }

            return $this->render('update', [
                'model' => $model,
            ]);
        }
        else{
			return $this->redirect(['site/login']);
		}
    }

    /**
     * Deletes an existing Medico model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if(!Yii::$app->user->isGuest){
            $this->findModel($id)->delete();

            return $this->redirect(['index']);
        }
        else{
			return $this->redirect(['site/login']);
		}
    }

    /**
     * Finds the Medico model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Medico the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Medico::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
