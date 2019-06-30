<?php

namespace app\controllers;

use Yii;
use app\models\Consulta;
use app\models\ConsultaSearch;
use app\models\Usuario;
use app\models\UsuarioSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;

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
        $searchModel = new ConsultaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Consulta model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Consulta model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
		$model = new Consulta();

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->id]);
		}

		return $this->render('create', [
			'model' => $model,
		]);
    }

    /**
     * Updates an existing Consulta model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Consulta model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
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

				if ($model->load(Yii::$app->request->post())) {
					$model->id_medico = Yii::$app->user->identity->id;
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
						return $this->redirect('index');
					}
				}

				$param1 = Yii::$app->request->post('param1', null);
				$param2 = Yii::$app->request->post('param2', null);

				$v["valor"] = null;
				$v["op"] = -1;

				$u = "o";

				//Yii::trace($param1);

				//$model->horario = $u;

				if($param1 != null){ 
					if(strlen($param1) == 10){
						$param1 = str_replace('/', '-', $param1);
						$param1 = date("Y-m-d", strtotime($param1));					
						$v["valor"] = (new \yii\db\Query())
						->from('consulta')
						->where(['id_medico' => Yii::$app->user->identity->id])
						->andWhere(['between', 'data_consulta', $param1, $param1])
						//->andWhere(['data_consulta'=>$param1])
						->count();
						$v["op"] = 0;
					}
					else if(strlen($param1) == 5){
						$param1 = str_replace('.', ':', $param1);
						$v["valor"] = (new \yii\db\Query())
						->from('consulta')
						->where(['id_medico' => Yii::$app->user->identity->id])
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
						return $this->redirect('index');
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
				//->orwhere(['id_Yii'=>3])
				//->orwhere(['id_Yii'=>6])
				//->orwhere(['id_Yii'=>7])
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
