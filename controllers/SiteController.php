<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

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
            //retorna um array seconds, minutes, hours, mday (dia do mês), wday (dia da semana - 0 = domingo...), mon (mês), year, weekday,
            //month
            //$testar_data = getdate(time());
            //var_dump($testar_data);
            //die();
            $tempo = null;
            if(Yii::$app->user->identity->id_Yii == 4){
                //definir um array de 42 duas posições com o for
                for($con = 0; $con < 42; $con++){
                    $tempo["valor"][$con] = null;
                    Yii::trace($con);
                }

                $tempo["op"] = 1;

                //ultimo dia do mês em string, formato: 2019-09-30
                //var_dump(date("t",strtotime("2019-09-02")));
                //die();

                //retorna o ano mes e dia
                //var_dump(date("Y-m-t",strtotime("2019-09-02")));
                $hoje = getdate(time());
                //for($dia = $hoje['mday'] - 1; $dia > 0; $dia--){
                    //usar o select para selecionar e retornar o número de consultas
                    //Yii::trace($dia);
                //}

                $tempo["valor"]["mes"] = $hoje["mon"];
                $tempo["valor"]["ano"] = $hoje["year"];

                //var_dump($tempo["valor"]["mes"] == 8 ? "Janeiro"  : ($tempo["valor"]["mes"] == 2 ? "Fervereiro" : ""));
                //die();

                $ultimodia = date("t", strtotime($hoje["year"]."-".$hoje["mon"]."-".$hoje["mday"]));
                $primeirodia = date("w", strtotime($hoje["year"]."-".$hoje["mon"]."-"."1")); //0 - domingo...
                for($dia = 1; $dia <= $ultimodia; $dia++){
                    //usar o select para selecionar e retornar o número de consultas
                    $c = (new \yii\db\Query())
					->from('consulta')
					->where(['id_medico' => Yii::$app->user->identity->id])
					->andWhere(['between', 'data_consulta', $hoje["year"]."-".$hoje["mon"]."-".$dia, $hoje["year"]."-".$hoje["mon"]."-".$dia])
                    ->count();
                    $tempo["valor"][$primeirodia] = $c;
                    $primeirodia++;
                }
                //Yii::trace($tempo["valor"][3]);
                //Yii::trace("ok");
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
