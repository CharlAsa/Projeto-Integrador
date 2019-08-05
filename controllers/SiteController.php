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
            return $this->render('index', [ 'tempo'=>$tempo ]);
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
