<?php

namespace app\controllers;

use Yii;
use app\models\ConsultaFake;
use app\models\Consulta;
use app\models\ConsultaSearch;
use app\models\Usuario;
use app\models\UsuarioSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;

use app\models\LaudoUpload;
use yii\web\UploadedFile;
/**
 * ConsultaController implements the CRUD actions for Consulta model.
 */
class ConsultaController extends Controller
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
     * Lists all Consulta models.
     * @return mixed
     */
    public function actionIndex()
    {
		if(!Yii::$app->user->isGuest){
			$searchModel = new ConsultaSearch();
			$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

			return $this->render('index', [
				'searchModel' => $searchModel,
				'dataProvider' => $dataProvider,
			]);
		}
    }

    /**
     * Displays a single Consulta model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id = null)
    {
		if(!Yii::$app->user->isGuest){
			if($id == null){
				return $this->redirect(['index']);
			}

			$model = $this->findModel($id);

			if($model->id_paciente == Yii::$app->user->identity->id){
				return $this->render('view', [
					'model' => $this->findModel($id),
				]);
			}
			else{
				if(Yii::$app->user->identity->id_Yii != 2){
					return $this->render('view', [
						'model' => $this->findModel($id),
					]);
				}
				throw new NotFoundHttpException(Yii::t('app', 'Page not found.'));
			}
		}
		else{
			return $this->redirect(['site/login']);
		}
    }

    /**
     * Creates a new Consulta model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
		if(!Yii::$app->user->isGuest){
			if(Yii::$app->user->identity->id_Yii == 999)
			{
				$model = new Consulta();

				if ($model->load(Yii::$app->request->post()) && $model->save()) {

					$paciente = Usuario::find()->where(["id" => $model->id_paciente])->one();

                    $paciente->updateAttributes(['agendamento_consulta' => '0']);

					return $this->redirect(['view', 'id' => $model->id]);
				}

				return $this->render('create', [
					'model' => $model,
				]);
			}
		}
		else{
			return $this->redirect(['site/login']);
		}
    }

    /**
     * Updates an existing Consulta model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id = null)
    {
		if(!Yii::$app->user->isGuest){
			$id_Yii = Yii::$app->user->identity->id_Yii;
			if($id_Yii != 2)
			{
				if($id == null){
					return $this->redirect(['index']);
				}

				$model = $this->findModel($id);

				if ($model->load(Yii::$app->request->post())) {

					//checa se existe outra consulta do paciente no mesmo horário
					$aux = date("Y-m-d", strtotime(str_replace('/', '-', $model->data_consulta)));

					$c = (new \yii\db\Query())
					->from('consulta')
					->where(['id_medico' => $model->id_medico])
					->andWhere(['id_paciente'=>$model->id_paciente])
					->andWhere(['between', 'data_consulta', $aux, $aux])
					->andWhere(['horario'=>$model->horario])
					->count();
					if($c == 1 || $c == 0){
						if($model->save()){
							return $this->redirect(['view', 'id' => $model->id]);
						}
					}
					else{
						return $this->redirect(['index']);
					}
				}

				$param1 = Yii::$app->request->post('param1', null);
				$param2 = Yii::$app->request->post('param2', null);

				$v["valor"] = null;
				$v["op"] = -1;

				$u = "o";

				if($param1 != null){ 
					if(strlen($param1) == 10){
						$param1 = str_replace('/', '-', $param1);
						$param1 = date("Y-m-d", strtotime($param1));					
						$v["valor"] = (new \yii\db\Query())
						->from('consulta')
						->where(['id_medico' => $model->id_medico])
						->andWhere(['between', 'data_consulta', $param1, $param1])
						//->andWhere(['data_consulta'=>$param1])
						->count();
						$v["op"] = 0;
					}
					else if(strlen($param1) == 5){
						$param1 = str_replace('.', ':', $param1);
						$v["valor"] = (new \yii\db\Query())
						->from('consulta')
						->where(['id_medico' => $model->id_medico])
						->andWhere(['horario'=>$param1])
						->count();
						$v["op"] = 1;
						$model->horario = $param1;
					}
				}

				$linhas = (new \yii\db\Query())
				->select(['id', 'nome'])
				->from('usuario')
				->where(['id_Yii' => 2])
				->all();

				$usuario = ArrayHelper::map(
					$linhas,
					'id',
					'nome'
				);

				$medico = null;
				if($id_Yii == 1){
					$linhasM = (new \yii\db\Query())
					->select(['id', 'nome'])
					->from('usuario')
					->where(['id_Yii' => 4])
					->all();


					$medico = ArrayHelper::map(
						$linhasM,
						'id',
						'nome'
					); 
				}

				//strtotime(str_replace('/', '-', $model->data_consulta))

				$model->data_consulta = date("d/m/Y", strtotime(str_replace('/', '-', $model->data_consulta)));

				return $this->render('update', [
					'model' => $model,
					'usuario' => $usuario,
					'v' => $v,
					'medico' => $medico,
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
     * Deletes an existing Consulta model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id = null)
    {
		if(!Yii::$app->user->isGuest){
			if(Yii::$app->user->identity->id_Yii != 2)
			{
				if($id == null){
					return $this->redirect(['index']);
				}


        		$consultaAgendada = Consulta::find()->where(["id" => $id])->one();



				$usuario = Usuario::find()->where(["id" => $consultaAgendada->id_paciente])->one();
			

				$usuario->updateAttributes(['agendamento_consulta' => '1']);

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
     * Deletes an existing Consulta model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDownload($id_consulta = null, $id_paciente = null)
    {
		if(!Yii::$app->user->isGuest){
			if(Yii::$app->user->identity->id_Yii == 2 || Yii::$app->user->identity->id_Yii == 4)
			{
				if($id_consulta == null){
					return $this->redirect(['consulta/index']);
				}

				if(Yii::$app->user->identity->id_Yii == 2){
					$id_paciente = Yii::$app->user->identity->id;
				}

				$consulta = $this->findModel($id_consulta);
				if(Yii::$app->user->identity->id_Yii == 2 && $consulta->id_paciente != $id_paciente){
					return $this->redirect(['consulta/index']);
				}

				$nome = $consulta->nomedoarquivo;

				return Yii::$app->response->sendFile('../uploads/laudo/'.$nome);
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
    public function actionUltimaconsultadownload()
    {
		if(!Yii::$app->user->isGuest){
			if(Yii::$app->user->identity->id_Yii == 2 )
			{
				$id_paciente = Yii::$app->user->identity->id;

				$consulta = Consulta::find()->limit(1)->orderBy(['id'=>SORT_DESC])->where(["id_paciente" => $id_paciente])->andWhere(["IS NOT", "nomedoarquivo", NULL])->one();

				if($consulta == null){
					Yii::$app->session->setFlash('warn', "Ainda não existe a ultima consulta.");
					return $this->redirect(['site/index']);
				}
				//yii::trace();

				$nome = $consulta->nomedoarquivo;

				return Yii::$app->response->sendFile('../uploads/laudo/'.$nome);
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
     * Creates a new Consulta model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionMedicoagendaconsulta()
	{  
		if(!Yii::$app->user->isGuest){
			if(Yii::$app->user->identity->id_Yii == 4)
			{
				$model = new Consulta();
				$param1 = Yii::$app->request->post('param1', null);
				//if(!Yii::$app->request->isAjax){
				if($param1 == null){
					if ($model->load(Yii::$app->request->post())) {
						$model->id_medico = Yii::$app->user->identity->id;
						$model->estado = 'a';

						//checa se existe outra consulta do paciente no mesmo horário
						$aux = date("Y-m-d", strtotime(str_replace('/', '-', $model->data_consulta)));

						$c = (new \yii\db\Query())
						->from('consulta')
						->where(['id_medico' => $model->id_medico])
						->andWhere(['id_paciente'=>$model->id_paciente])
						//->andWhere(['between', 'data_consulta', $aux, $aux])
						//->andWhere(['horario'=>$model->horario])
						->andWhere(['estado'=>'a'])
						->count();
						if($c == 0){
							if($model->save()){
								$paciente = Usuario::find()->where(["id" => $model->id_paciente])->one();

								$paciente->updateAttributes(['agendamento_consulta' => '0']);
								
								return $this->redirect(['view', 'id' => $model->id]);
							}
						}
						else{
							return $this->redirect(['index']);
						}
					}
				}

				$param2 = Yii::$app->request->post('param2', null);

				$v["valor"] = null;
				$v["op"] = -1;

				$u = "o";

				Yii::trace(Yii::$app->request->post('param1'));

				//$model->horario = $u;

				if($param1 != null){ 
					if(strlen($param1) == 10 && $param2 == 2){
						$param1 = str_replace('/', '-', $param1);
						$param1 = date("Y-m-d", strtotime($param1));					
						$v["valor"] = (new \yii\db\Query())
						->from('consulta')
						->where(['id_medico' => $model->id_medico])
						->andWhere(['between', 'data_consulta', $param1, $param1])
						//->andWhere(['data_consulta'=>$param1])
						->count();
						$v["op"] = 0;
					}
					else if(strlen($param1) == 5){
						$param1 = str_replace('.', ':', $param1);
						$v["valor"] = (new \yii\db\Query())
						->from('consulta')
						->where(['id_medico' => $model->id_medico])
						->andWhere(['horario'=>$param1])
						->count();
						$v["op"] = 1;
						$model->horario = $param1;
					}
					else if(strlen($param1) == 10 && $param2 == 3){
						$param1 = str_replace('/', '-', $param1);
						$param1 = date("Y-m-d", strtotime($param1));	
						$v["valor"] = array('07:00'=>'07:00', '08:00'=>'08:00');
						$v["op"] = 2;
						$temp = (new \yii\db\Query())
						->select('horario')
						->from('consulta')
						->where(['id_medico' => Yii::$app->user->identity->id])
						->andWhere(['estado'=>'a'])
						->andWhere(['between', 'data_consulta', $param1, $param1])
						->All();
						foreach($temp as $r){
							if(in_array($r["horario"], $v["valor"])){
								unset($v["valor"][$r["horario"]]);
							}
						}
						$model->horario = null;
					}
				}

				$linhas = (new \yii\db\Query())
				->select(['id', 'nome'])
				->from('usuario')
				->where(['id_Yii' => 2])
				->andWhere(['agendamento_consulta' => '1'])
				//->orwhere(['id_Yii'=>3])
				//->orwhere(['id_Yii'=>6])
				//->orwhere(['id_Yii'=>7])
				->all();

				$usuario = ArrayHelper::map(
					$linhas,
					'id',
					'nome'
				);
				return $this->render('medicoagendaconsulta', [
					'model' => $model,
					'usuario' => $usuario,
					'v' => $v,
				]);

			}
			else {
				throw new NotFoundHttpException(Yii::t('app', 'Page not found.'));
			}
		}

		else{
			return $this->redirect(['site/login']);
		}
    }
	
	/**
     * Creates a new Consulta model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionSecretarioagendaconsulta()
	{  
		if(!Yii::$app->user->isGuest){
			if(Yii::$app->user->identity->id_Yii == 1)
			{
				$model = new Consulta();

				if ($model->load(Yii::$app->request->post())) {
					//$model->id_medico = Yii::$app->user->identity->id;
					$model->estado = 'a';


					//checa se existe outra consulta do paciente no mesmo horário
					$aux = date("Y-m-d", strtotime(str_replace('/', '-', $model->data_consulta)));

					$c = (new \yii\db\Query())
					->from('consulta')
					->where(['id_medico' => $model->id_medico])
					->andWhere(['id_paciente'=>$model->id_paciente])
					->andWhere(['between', 'data_consulta', $aux, $aux])
					->andWhere(['horario'=>$model->horario])
					->count();
					if($c == 0){
						if($model->save()){
							return $this->redirect(['view', 'id' => $model->id]);
						}
					}
					else{
						return $this->redirect(['index']);
					}
				}

				$param1 = Yii::$app->request->post('param1', null);
				$param2 = Yii::$app->request->post('param2', null);

				$v["valor"] = null;
				$v["op"] = -1;

				//$u = "o";

				//Yii::trace($param1);

				//$model->horario = $u;

				if($param1 != null){ 
					if(strlen($param1) == 10){
						$param1 = str_replace('/', '-', $param1);
						$param1 = date("Y-m-d", strtotime($param1));					
						$v["valor"] = (new \yii\db\Query())
						->from('consulta')
						->where(['id_medico' => $model->id_medico])
						->andWhere(['between', 'data_consulta', $param1, $param1])
						//->andWhere(['data_consulta'=>$param1])
						->count();
						$v["op"] = 0;
					}
					else if(strlen($param1) == 5){
						$param1 = str_replace('.', ':', $param1);
						$v["valor"] = (new \yii\db\Query())
						->from('consulta')
						->where(['id_medico' => $model->id_medico])
						->andWhere(['horario'=>$param1])
						->count();
						$v["op"] = 1;
						$model->horario = $param1;
					}
				}

				$linhas = (new \yii\db\Query())
				->select(['id', 'nome'])
				->from('usuario')
				->where(['id_Yii' => 2])
				//->orwhere(['id_Yii'=>3])
				//->orwhere(['id_Yii'=>6])
				//->orwhere(['id_Yii'=>7])
				->all();
				
				$linhasM = (new \yii\db\Query())
				->select(['id', 'nome'])
				->from('usuario')
				->where(['id_Yii' => 4])
				->all();

				$usuario = ArrayHelper::map(
					$linhas,
					'id',
					'nome'
				);
				
				$medico = ArrayHelper::map(
					$linhasM,
					'id',
					'nome'
				); 
				
				return $this->render('secretarioagendaconsulta', [
					'model' => $model,
					'usuario' => $usuario,
					'v' => $v,
					'medico' => $medico,
				]);

			}
			else {
				throw new NotFoundHttpException(Yii::t('app', 'Page not found.'));
			}
		}

		else{
			return $this->redirect(['site/login']);
		}
	}
	
	/**
     * Lists all Consulta models.
     * @return mixed
     */
    public function actionVerconsulta()
    {
		//$searchModel = new ConsultaSearch();
		
		$id = Yii::$app->user->identity->id;
		$query = (new \yii\db\Query())
		->select('usuario.*, consulta.*')
		->from('consulta')
        ->innerJoin('medico','medico.id_usuario=consulta.id')
        ->innerJoin('usuario','usuario.id=medico.id_usuario')
		->where('usuario.id='.$id)
        //->distinct()
		;
		
		$dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        //$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('verconsulta', [
        //    'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
	}
	
	/**
     * Upload do laudo da consulta.
     * 
     * @return ?
     */
    public function actionLaudoupload($id = null)
    {
        if(!Yii::$app->user->isGuest){
            $id_Yii = Yii::$app->user->identity->id_Yii;
            if($id_Yii == 4)
			{
                $model = new LaudoUpload();

                if (Yii::$app->request->isPost) {
                    $model->laudopdf = UploadedFile::getInstance($model, 'laudopdf');
                    if ($model->upload($id)) {
						//mostra o laudo
						Yii::$app->session->setFlash('success', "Upload do laudo foi um sucesso.");
                        return $this->render('laudoupload', ['model' => $model]);
					}
					else{
						Yii::$app->session->setFlash('error', "Upload do laudo falhou.");
						return $this->render('laudoupload', ['model' => $model]);
					}
                }
                return $this->render('laudoupload', ['model' => $model]);
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
     * Upload do laudo da consulta utilizando o id do paciente.
     * 
     * @return ?
     */
    public function actionDisponibilizarlaudo()
    {
        if(!Yii::$app->user->isGuest){
            if(Yii::$app->user->identity->id_Yii == 4)
			{
                $model = new LaudoUpload();
				$model2 = new ConsultaFake();
				

                if ($model2->load(Yii::$app->request->post())) {
					$consulta = Consulta::find()->limit(1)->orderBy(['id'=>SORT_DESC])->where(["id_paciente" => $model2->id_paciente])->andWhere(["id_medico" => Yii::$app->user->identity->id])->one();

					if($consulta != null){
						$model->laudopdf = UploadedFile::getInstance($model, 'laudopdf');
						if ($model->upload($consulta->id)) {
							Yii::$app->session->setFlash('success', "Upload do laudo foi um sucesso.");
						}
						else{
							Yii::$app->session->setFlash('error', "Upload do laudo falhou.");
						}
					}
					else{
						Yii::$app->session->setFlash('error', "Paciente inválido.");
					}

					$usuario = null;

					foreach($linhasz as $cada){
						$usuario[$cada->paciente->id] = $cada->paciente->nome;
					}

					return $this->render('disponibilizarlaudo', ['model' => $model, 'usuario' => $usuario, 'model2'=>$model2]);
				}

				$linhasz = Consulta::find()
				->where(['id_medico'=>Yii::$app->user->identity->id])
				->AndWhere(['estado'=>'a'])
				->all();

				$usuario = null;

				foreach($linhasz as $cada){
					$usuario[$cada->paciente->id] = $cada->paciente->nome;
				}
				
                return $this->render('disponibilizarlaudo', ['model' => $model, 'usuario' => $usuario, 'model2'=>$model2]);
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
     * Finds the Consulta model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Consulta the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Consulta::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
	}
}
