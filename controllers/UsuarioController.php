<?php

namespace app\controllers;

use Yii;
use app\models\Usuario;
use app\models\UsuarioSearch;
use app\models\Paciente;
use app\models\PacienteSearch;
use app\models\Consulta;
use app\models\ConsultaSearch;
use app\models\Contato;
use app\models\ContatoSearch;
use app\models\Endereco;
use app\models\EnderecoSearch;
use app\models\Medico;
use app\models\MedicoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\base\UserException;
use app\models\FotoUpload;
use yii\web\UploadedFile;

/**
 * UsuarioController implements the CRUD actions for Usuario model.
 */
class UsuarioController extends Controller
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
     * Lists all Usuario models.
     * @return mixed
     */
    public function actionIndex()
    {
        if(!Yii::$app->user->isGuest){
            if(Yii::$app->user->identity->id_Yii == 1)
			{
                $searchModel = new UsuarioSearch();
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
     * Displays a single Usuario model.
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
     * Creates a new Usuario model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if(!Yii::$app->user->isGuest){
            if(Yii::$app->user->identity->id_Yii == 1)
			{
                $model = new Usuario();
                $arrayEndereco = new Endereco();
                $arrayContato = new Contato();
                //$model2 = new Medico();

                if ($model->load(Yii::$app->request->post()) && $arrayContato->load(Yii::$app->request->post()) && $arrayEndereco->load(Yii::$app->request->post())) {

                    $model->agendamento_consulta = '1';

                    if($model->save())
                    {
                        $arrayContato->id_usuario = $model->id; 
                        $arrayEndereco->id_usuario = $model->id;
                        //$model2->id_usuario = $model->id;

                        if($arrayContato->save() && $arrayEndereco->save())
                        {
                            //if($model->id_Yii == 4){
                                //$model2->save();
                            //}
                            return $this->redirect(['view', 'id' => $model->id]);
                        }
                    }
                }

                return $this->render('create', [
                    'model' => $model,
                    //'model2' => $model2,
                    'arrayEndereco' => $arrayEndereco,
                    'arrayContato' => $arrayContato,
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
     * Updates an existing Usuario model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        if(!Yii::$app->user->isGuest){
            if(Yii::$app->user->identity->id_Yii == 1)
			{
                $model = Usuario::findOne($id);
                //$idContato = (new \yii\db\Query())->select(['id_usuario'])->from('contato')->where(['id_usuario' => $id]);
                //$idEndereco = (new \yii\db\Query())->select(['id_usuario'])->from('endereco')->where(['id_usuario' => $id]);
                //$model2 = (new \yii\db\Query())->select(['*'])->from('medico')->where(['id_usuario' => $id]);
                //$model2 = new Medico();
                //$aux = Medico::findOne($id);
                //if($aux != null){
                //    $model2 = $aux;
                //}
                $arrayContato = Contato::findOne($id);
                $arrayEndereco = Endereco::findOne($id);
                //$arrayContato = $this->findModelContato($idContato);
                //$arrayEndereco = $this->findModelEndereco($idEndereco);

                $model->nascimento = date('d-m-Y' , strtotime($model->nascimento));

                if($model->load(Yii::$app->request->post()) && $arrayEndereco->load(Yii::$app->request->post())
                && $arrayContato->load(Yii::$app->request->post())) 
                {
                    $model->nascimento = date('Y-m-d' , strtotime($model->nascimento));
                    if($model->save())
                    {
                        $arrayContato->id_usuario = $model->id; 
                        $arrayEndereco->id_usuario = $model->id;
                        if($arrayContato->save() && $arrayEndereco->save())
                        {
                            //if($model2 != null){
                                //$model2->id_usuario = $model->id;
                                //$model2->save();
                            //}
                            return $this->redirect(['view', 'id' => $model->id]);
                        }
                    }
                }


                return $this->render('update', [
                    'model' => $model,
                    'arrayContato' => $arrayContato,
                    'arrayEndereco' => $arrayEndereco,
                    //'model2'=>$model2,
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
     * Deletes an existing Usuario model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if(!Yii::$app->user->isGuest){
            if(Yii::$app->user->identity->id_Yii == 1)
			{
                if(Consulta::find()->where(['id_paciente' =>$id])->one()){
                    throw new UserException(Yii::t('app', 'Not possible delete user, contact developer.'));
                }
                //Paciente::findOne($id)->delete();
                Contato::findOne($id)->delete();
                Endereco::findOne($id)->delete();
                $m = Medico::findOne($id);
                if($m != null){
                    $m->delete();
                }
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
     * Creates a new Usuario model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCadastrar()
    {
		if(Yii::$app->user->isGuest){
				$model = new Usuario();
				$model2 = new Contato();
				$model3 = new Endereco();


				if ($model->load(Yii::$app->request->post()) &&  $model2->load(Yii::$app->request->post()) && $model3->load(Yii::$app->request->post())) {
                    $model->id_Yii = 2;

                    $model->nascimento = date('d-m-Y' , strtotime($model->nascimento));
                    
                    $transaction = Yii::$app->db->beginTransaction();
					if($model->save()){
						$model2->id_usuario = $model->id;
                        if($model2->save()){     
                            $model3->id_usuario = $model->id;
                            if($model3->save()){ 
                                $transaction->commit();
                                //Yii::$app->session->setFlash('success', "Cadastro realizado com sucesso.");
                                return $this->redirect(['site/login']);
                            }
                        }
                    }
                    $transaction->rollBack();
                    Yii::$app->session->setFlash('error', "Ocorreu um erro ao se cadastrar, por favor cadastre-se novamente.");
                    //return $this->redirect(['usuario/cadastrar']);
				}

				return $this->render('cadastrarpaciente', [
					'model' => $model,
					'model2' => $model2,
					'model3' => $model3,
				]);
		}
		else{
			return $this->redirect(['site/index']);
		}
    }

    /**
     * Upload de foto do usuário.
     * 
     * @return muitas coisas, veja a src
     */

    public function actionAssinaturaupload($id = null)
    {
        if(!Yii::$app->user->isGuest){
            $id_Yii = Yii::$app->user->identity->id_Yii;
			if($id_Yii == 4 || $id_Yii == 1){

                $model = new FotoUpload();

                if (Yii::$app->request->isPost) {
                    $id_medico = $id;
                    if($id_Yii == 4){
                        $id_medico = Yii::$app->user->identity->id;
                    }
                    else{
                        //Nessita do id_medico
                    }

                    if($id_medico != null){
                        $model->foto = UploadedFile::getInstance($model, 'foto');
                        if ($model->upload($id_medico)) {
                            Yii::$app->session->setFlash('success', "Upload da assinatura foi um sucesso.");
                            return $this->render('fotoupload', ['model' => $model]);
                        }
                        else{
                            Yii::$app->session->setFlash('error', "Upload da assinatura falhou.");
                            return $this->render('fotoupload', ['model' => $model]);
                        }
                    }
                    else{
                        throw new NotFoundHttpException(Yii::t('app', 'Médico não encontrado.'));
                    }
                }

                return $this->render('fotoupload', ['model' => $model]);
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
     * Deletes an existing Consulta model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDownload($id_usuario = null)
    {
		if(!Yii::$app->user->isGuest){
			if(Yii::$app->user->identity->id_Yii == 4)
			{
                if($id_usuario == null){
                    if(Yii::$app->user->identity->id_Yii == 2){
                        return $this->redirect(['site/index']);
                    }

                    $nome = Yii::$app->user->identity->nomedaassinatura;

                    return Yii::$app->response->sendFile('../uploads/fotos/'.$nome);
                }
                else{
                    throw new NotFoundHttpException(Yii::t('app', 'Não foi implementado.'));
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
     * Displays a single Usuario model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    //public function actionPaginainicial()
    //{
	//	$id = Yii::$app->user->identity->id;
    //    return $this->render('paginainicial', [
    //        'model' => $this->findModel($id),
    //    ]);
    //}

    /**
     * Finds the Usuario model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Usuario the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Usuario::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
