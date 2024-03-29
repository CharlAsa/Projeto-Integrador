<?php

namespace app\controllers;

use Yii;
use app\models\Laudo;
use app\models\LaudoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\models\Clinica;


use yii\helpers\ArrayHelper;
use app\models\Usuario;
use app\models\Consulta;

use app\models\LaudoUpload;
use yii\web\UploadedFile;

require_once('../PDF/index.php');

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
            if(Yii::$app->user->identity->id_Yii != 2)
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
            if(Yii::$app->user->identity->id_Yii != 2)
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


                if ($model->load(Yii::$app->request->post())) {
                    $idPaciente = $model->id_consulta;

                    $idConsultas = (new \yii\db\Query())->
                    select(['id'])
                    ->from('consulta')
                    ->where(['id_paciente' => $model->id_consulta])
                    ->All();


                    $model->nova_consulta = date('Y-m-d', strtotime(str_replace('/', '-', $model->nova_consulta)));
                  
                    $idConsulta = null;

                    foreach($idConsultas as $id){
                        $aux = (new \yii\db\Query())->
                        select(['id_consulta'])
                        ->from('laudo')
                        ->where(['id_consulta' => $id])
                        ->One();
                        if($aux == null){
                            $idConsulta = $id;
                        }
                    }
                    
                    $model->id_consulta = $idConsulta['id'];

                    $transaction = Yii::$app->db->beginTransaction();

                    if($model->id_consulta != null){
                        $nome = \Yii::$app->security->generateRandomString().\Yii::$app->security->generateRandomString() . '.pdf';
                        //$url ='../uploads/laudo/' . $nome;
                        $model->nomedolaudo = $nome;
                        try{
                            if($model->save())
                            {
                                //
                                //$consult = Consulta::find()->where(['id' => $idConsulta])->One();
                                //$consult->updateAttributes(['estado' => 'r']);


                                $paciente = Usuario::find()->where(["id" => $idPaciente])->one();

                                $paciente->updateAttributes(['agendamento_consulta' => '0']);
                                $paciente->updateAttributes(['cadastro_laudo' => 'c']);

                                $consulta = Consulta::find()->limit(1)->where(['id'=>$model->id_consulta])->one();
                                
                                $assinatura = $consulta->medico->nomedaassinatura;
                                if($assinatura != null){
                                    $clinica = Clinica::find()->limit(1)->one();
                                    CriarPDF($nome, $assinatura, $clinica, $model);
                                }            
                                $transaction->commit();
                                return $this->redirect(['view', 'id' => $model->id_consulta]);
                            }
                        }
                        catch(Exception $e){
                            $transaction->rollBack();
                            var_dump($e);
                            die();
                        }
                    }
                    else{
                        return $this->redirect(['index']);
                    }
                }

                $arrayUsuario = ArrayHelper::map(
                    Usuario::find()
                    ->innerJoin('consulta','consulta.id_paciente=usuario.id')
                    //->innerJoin('consulta','consulta.id_usuario=usuario.id')
                    //->innerJoin('laudo','consulta.id=laudo.id_consulta')
                    ->where(['usuario.id_Yii' => '2'])
                    ->andWhere(['consulta.estado'=>'a'])
                    ->andWhere(['usuario.cadastro_laudo'=> 'n'])
                    ->all(), 
                    'id', 
                    'nome'
                );
                //Faltando a parte de agendar

                //var_dump($arrayUsuario);
                //die();

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

                if ($model->load(Yii::$app->request->post())) {
                    $aux = $this->findModel($id);
                    
                    $model->id_consulta = $aux->id_consulta;

                    $model->save();

                    return $this->redirect(['view', 'id' => $model->id_consulta]);
                }

                $arrayUsuario = (new \yii\db\Query())->select(['id_paciente'])->from('consulta')->where(['id' => $model->id_consulta])->one();

                $arrayUsuario = ArrayHelper::map(
                    Usuario::find()
                    ->innerJoin('consulta','consulta.id_paciente=usuario.id')
                    //->innerJoin('medico','medico.id_usuario=consulta.id')
                    ->where(['id_Yii' => '2'])
                    ->AndWhere(['consulta.id_paciente' => $arrayUsuario])
                    ->All(), 
                    'id', 
                    'nome'
                );

                $model->nova_consulta = date("d/m/Y", strtotime(str_replace('/', '-', $model->nova_consulta)));

                $teste = Consulta::find()->where(['id_medico' => Yii::$app->user->identity->id])->andWhere(['id' => $id])->one();
                if($teste != null){
                    return $this->render('update', [
                        'model' => $model,
                        'arrayUsuario' => $arrayUsuario,
                    ]);
                }
                else{
                    Yii::$app->session->setFlash('error', "Você não tem permissão para realizar essa operação.");
                    return $this->redirect(['laudo/index']);
                }
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
        $model = $this->findModel($id);
        if(!Yii::$app->user->isGuest){
            if(Yii::$app->user->identity->id_Yii != 2)
			{
                $usuario = (new \yii\db\Query())->select(['id_paciente'])->from('consulta')->where(['id' => $model->id_consulta])->one();

                //var_dump($usuario);
                //die();

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

    /**
     * Upload do laudo da consulta.
     * 
     * @return ?
     */

    public function actionLaudoupload()
    {
        $model = new LaudoUpload();

        if (Yii::$app->request->isPost) {
            $model->laudopdf = UploadedFile::getInstance($model, 'laudopdf');
            if ($model->upload()) {
                return;
            }
        }
        return $this->render('laudoupload', ['model' => $model]);
    }
}
