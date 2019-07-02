<?php

namespace app\controllers;

use Yii;
use app\models\Laudo;
use app\models\LaudoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\helpers\ArrayHelper;
use app\models\Usuario;

/**
 * LaudoController implements the CRUD actions for Laudo model.
 */
class LaudoController extends Controller
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
     * Lists all Laudo models.
     * @return mixed
     */
    public function actionIndex()
    {
        if(!Yii::$app->user->isGuest){
            if(Yii::$app->user->identity->id_Yii == 1)
			{
                $searchModel = new LaudoSearch();
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
        else{
			return $this->redirect(['site/login']);
		}
    }

    /**
     * Displays a single Laudo model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        if(!Yii::$app->user->isGuest){
            if(Yii::$app->user->identity->id_Yii == 1)
			{
                return $this->render('view', [
                    'model' => $this->findModel($id),
                ]);
            }
			else{
				throw new NotFoundHttpException(Yii::t('app', 'Page not found.'));
			}
        }
        else{
			return $this->redirect(['site/login']);
		}
    }

    /**
     * Creates a new Laudo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if(!Yii::$app->user->isGuest){
            if(Yii::$app->user->identity->id_Yii != 2)
			{
                $model = new Laudo();

                //CÓDIGO TESTE
                $arrayUsuario = ArrayHelper::map(Usuario::find()->where(['id_Yii' => '2'])->all(), 'id', 'nome');


                if ($model->load(Yii::$app->request->post())) {
                    $idConsulta = (new \yii\db\Query())->select(['id'])->from('consulta')->where(['id_paciente' => $model->id_consulta])->One();
                    
                    $model->id_consulta = $idConsulta['id'];

                    if($model->save())
                    {
                        return $this->redirect(['view', 'id' => $model->id_consulta]);
                    }
                }

                return $this->render('create', [
                    'model' => $model,
                    'arrayUsuario' => $arrayUsuario,
                ]);
            }
			else{
				throw new NotFoundHttpException(Yii::t('app', 'Page not found.'));
			}
        }
        else{
			return $this->redirect(['site/login']);
		}
    }

    /**
     * Updates an existing Laudo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        if(!Yii::$app->user->isGuest){
            if(Yii::$app->user->identity->id_Yii != 2)
			{
                $model = $this->findModel($id);

                if ($model->load(Yii::$app->request->post()) && $model->save()) {
                    return $this->redirect(['view', 'id' => $model->id_consulta]);
                }

                return $this->render('update', [
                    'model' => $model,
                ]);
            }
			else{
				throw new NotFoundHttpException(Yii::t('app', 'Page not found.'));
			}
        }
        else{
			return $this->redirect(['site/login']);
		}
    }

    /**
     * Deletes an existing Laudo model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if(!Yii::$app->user->isGuest){
            if(Yii::$app->user->identity->id_Yii != 2)
			{
                $this->findModel($id)->delete();

                return $this->redirect(['index']);
            }
			else{
				throw new NotFoundHttpException(Yii::t('app', 'Page not found.'));
			}
        }
        else{
			return $this->redirect(['site/login']);
		}
    }

    /**
     * Finds the Laudo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Laudo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Laudo::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
