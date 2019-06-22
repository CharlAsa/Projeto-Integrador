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
        $searchModel = new UsuarioSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Usuario model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
			'response' => date('H:i:s'),
        ]);
    }

    /**
     * Creates a new Usuario model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Usuario();
        $arrayEndereco = new Endereco();
        $arrayContato = new Contato();
        $model2 = new Medico();

        if ($model->load(Yii::$app->request->post()) && $arrayContato->load(Yii::$app->request->post()) && $arrayEndereco->load(Yii::$app->request->post()) && $model2->load(Yii::$app->request->post())) {
            if($model->save())
            {
                $arrayContato->id_usuario = $model->id; 
                $arrayEndereco->id_usuario = $model->id;
                $model2->id_usuario = $model->id;

                if($arrayContato->save() && $arrayEndereco->save())
                {
                    Yii::trace($model2);
                    if($model->id_Yii == 4){
                        $model2->save();
                    }
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
            'model2' => $model2,
            'arrayEndereco' => $arrayEndereco,
            'arrayContato' => $arrayContato,
        ]);
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
        $model = Usuario::findOne($id);
        $contato = new Contato();
        $idContato = (new \yii\db\Query())->select(['id_usuario'])->from('contato')->where(['id_usuario' => $id]);
        $idEndereco = (new \yii\db\Query())->select(['id_usuario'])->from('endereco')->where(['id_usuario' => $id]);
        $model2 = (new \yii\db\Query())->select(['*'])->from('medico')->where(['id_usuario' => $id]);

        $arrayContato = $this->findModelContato($idContato);
        $arrayEndereco = $this->findModelEndereco($idEndereco);


        $model->nascimento = date('d-m-Y' , strtotime($model->nascimento));

        if($model->load(Yii::$app->request->post()) && $arrayEndereco->load(Yii::$app->request->post())
        && $arrayContato->load(Yii::$app->request->post()) && $model2->load(Yii::$app->request->post()))
        {

            $model->nascimento = date('Y-m-d' , strtotime($model->nascimento));
             if($model->save())
            {
                $arrayContato->id_usuario = $model->id; 
                $arrayEndereco->id_usuario = $model->id;
                if($arrayContato->save() && $arrayEndereco->save())
                {
                    $model2->save();
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        }


        return $this->render('update', [
            'model' => $model,
            'arrayContato' => $arrayContato,
            'arrayEndereco' => $arrayEndereco,
            'model2'=>$model2,
        ]);
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
	
	/**
     * Creates a new Usuario model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCadastrarpaciente()
    {
		if(!Yii::$app->user->isGuest){
			if(Yii::$app->user->identity->id_Yii == 1 || Yii::$app->user->identity->id_Yii == 100){
				$model = new Usuario();
				$model2 = new Contato();
				$model3 = new Endereco();


				if ($model->load(Yii::$app->request->post())) {
					$model->id_Yii = 2;
					//Inserir também na tabela paciente
					
					if($model->save()){
						$p = new Paciente();
						$p->id_usuario = $model->id;
						$p->save();
						
						$model2->id_usuario = $model->id;
						$model2->save();
						
						$model3->id_usuario = $model->id;
						$model3->save();
						
						return $this->redirect(['view', 'id' => $model->id]);
					}
				}

				return $this->render('cadastrarpaciente', [
					'model' => $model,
					'model2' => $model2,
					'model3' => $model3,
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
     * Displays a single Usuario model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionPaginainicial()
    {
		$id = Yii::$app->user->identity->id;
        return $this->render('paginainicial', [
            'model' => $this->findModel($id),
        ]);
    }

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
