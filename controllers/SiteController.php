<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\helpers\Json;
use app\models\Consulta;
use yii\helpers\ArrayHelper;
use app\models\ConsultaSearch;

class SiteController extends Controller
{
	
	//public $layout = '@app/views/layouts/startbootstrap-landing-page-gh-pages/index';
    public $layout;
    
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        if (!Yii::$app->user->isGuest) {
            $tempo = null;
            $mes = Yii::$app->request->post('mes', null);
            $ano = Yii::$app->request->post('ano', null);
            $dia = Yii::$app->request->post('dia', null);
            if($mes != null && $ano != null && $dia != null){
                $mes = trim($mes);
                $ano = trim($ano);
                $dia = trim($dia);
                $mes = ($mes == "Janeiro") ? ("1") : (($mes == "Fevereiro") ? ("2") : (($mes == "Março") ? ("3") : (($mes == "Abril") ? ("4") : (($mes == "Maio") ? ("5") : (($mes == "Junho") ? ("6") : (($mes == "Julho") ? ("7") : (($mes == "Agosto") ? ("8") : (($mes == "Setembro") ? ("9") : (($mes == "Outubro") ? ("10") : (($mes == "Novembro") ? ("11") : ("12")))))))))));
                $c = (new \yii\db\Query())
                    ->select('consulta.*, usuario.nome')
                    ->from('consulta')
                    ->innerJoin('usuario', 'consulta.id_paciente = usuario.id')
					->where(['id_medico' => Yii::$app->user->identity->id])
                    ->andWhere(['between', 'data_consulta', $ano."-".$mes."-".$dia, $ano."-".$mes."-".$dia])
                    ->all();
                    
                return Json::encode($c);
            }

            if(Yii::$app->user->identity->id_Yii == 4){
                for($con = 0; $con < 42; $con++){
                    $tempo["valor"][$con] = null;
                }

                $tempo["op"] = 1;

                $hoje = getdate(time());

                $tempo["valor"]["mes"] = $hoje["mon"];
                $tempo["valor"]["ano"] = $hoje["year"];

                $ultimodia = date("t", strtotime($hoje["year"]."-".$hoje["mon"]."-".$hoje["mday"]));
                $primeirodia = date("w", strtotime($hoje["year"]."-".$hoje["mon"]."-"."1")); //0 - domingo...
                for($dia = 1; $dia <= $ultimodia; $dia++){
                    $c = (new \yii\db\Query())
					->from('consulta')
					->where(['id_medico' => Yii::$app->user->identity->id])
					->andWhere(['between', 'data_consulta', $hoje["year"]."-".$hoje["mon"]."-".$dia, $hoje["year"]."-".$hoje["mon"]."-".$dia])
                    ->count();
                    $tempo["valor"][$primeirodia] = $c;
                    $primeirodia++;
                }
            }

            $model = null;
            $medicos = null;
            $medicoLista = null;
            $v["valor"] = null;
            $v["op"] = -1;

            if(Yii::$app->user->identity->id_Yii == 2){
                $model = new Consulta();

                $param1 = Yii::$app->request->post('param1', null);

                if($param1 == null){
                    if($model->load(Yii::$app->request->post())){
                        $model->id_paciente = Yii::$app->user->identity->id;
                        
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
                
                if($param1 != null){ 
					if(strlen($param1) == 10  && $param2 == 2){
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
						$model->load(Yii::$app->request->post());
						$param1 = str_replace('/', '-', $param1);
						$param1 = date("Y-m-d", strtotime($param1));	
						$v["valor"] = array('07:00'=>'07:00', '08:00'=>'08:00');
						$v["op"] = 2;
						$temp = (new \yii\db\Query())
						->select('horario')
						->from('consulta')
						->where(['id_medico' => $model->id_medico])
						//->andWhere(['estado'=>'a'])
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

                $medicos = (new \yii\db\Query())
                            ->select(['id', 'nome'])
                            ->from('usuario')
                            ->where(['id_Yii' => 4])
                            ->all();

                $medicoLista = ArrayHelper::map(
                    $medicos,
                    'id',
                    'nome'
                );
                


            }

            return $this->render('index', [ 'tempo'=>$tempo, 'model'=>$model, 'medicos'=>$medicos, 'medicoLista'=>$medicoLista, 'v'=>$v ]);
        }

        return $this->redirect(['site/login']);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        $this->layout = '@app/views/layouts/login_main.php';
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
