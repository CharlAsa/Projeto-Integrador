<?php

/**
 * @var string $content
 * @var \yii\web\View $this
 */

use yii\helpers\Html;
use yii\helpers\Url;

$bundle = yiister\gentelella\assets\Asset::register($this);

?>
<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta charset="<?= Yii::$app->charset ?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="nav-<?= !empty($_COOKIE['menuIsCollapsed']) && $_COOKIE['menuIsCollapsed'] == 'true' ? 'sm' : 'md' ?>" >
<?php $this->beginBody(); ?>
<div class="container body">

    <div class="main_container">

        <div class="col-md-3 left_col">
            <div class="left_col scroll-view">

                <div class="navbar nav_title" style="border: 0;">
                    <a href="/" class="site_title"><i class="fa fa-paw"></i> <span>Edite me!</span></a>
                </div>
                <div class="clearfix"></div>

                <!-- menu prile quick info -->
                <div class="profile">
                    <div class="profile_pic">
                        <img src="http://placehold.it/128x128" alt="..." class="img-circle profile_img">
                    </div>
                    <div class="profile_info">
                        <span>Seja bem vindo,</span>
                        <h2> <?php 
                        //Nome
                        if(!Yii::$app->user->isGuest)
                        { 
                            echo Yii::$app->user->identity->nome; 
                        } 
                        ?> </h2>
                    </div>
                </div>
                <!-- /menu prile quick info -->

                <br />

                <!-- sidebar menu -->
                <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

                    <div class="menu_section">
                        <!-- <h3> General</h3> -->
                        <h3> <br> <br> <br> <br> <br> </h3>
                        <?=
                        \yiister\gentelella\widgets\Menu::widget(
                            [
                                "items" => [
                                    ["label" => "Página Inicial", "url" => ['/site/index'], "icon" => "home"],
                                    
                                    Yii::$app->user->isGuest == false ? (
                                        Yii::$app->user->identity->id_Yii == 4 ? (
                                            [
                                                "label" => "Médico",
                                                "icon" => "user",
                                                "url" => "#",
                                                "items" => [
                                                    ["label" => "Agendar consulta", "url" => ["consulta/medicoagendaconsulta"]],
                                                    ["label" => "Ver todas as consultas", "url" => ["consulta/index"]],
                                                    ["label" => "Disponibilizar Laudo", "url" => ["consulta/disponibilizarlaudo"]],
                                                    ["label" => "Upload da Assinatura", "url" => ["usuario/assinaturaupload"]],
                                                ],
                                            ]
                                        ) : (
                                            Yii::$app->user->identity->id_Yii == 2 ? (
                                                [
                                                    "label" => "Paciente",
                                                    "icon" => "user",
                                                    "url" => "#",
                                                    "items" => [
                                                        ["label" => "Ver consultas", "url" => ["consulta/index"]],
                                                        ["label" => "Emitir laudo da ultima consulta", "url" => ["consulta/ultimaconsultadownload"]],
                                                    ],
                                                ]
                                            ) : (
                                                [
                                                    "label" => "Secretário",
                                                    "icon" => "user",
                                                    "url" => "#",
                                                    "items" => [
                                                        ["label" => "Agendar consulta", "url" => ["consulta/secretarioagendaconsulta"]],
                                                        ["label" => "Ver consultas", "url" => ["consulta/index"]],
                                                        ["label" => "Cadastrar usuário", "url" => ["usuario/create"]],
                                                    ],
                                                ]
                                            )
                                        )
                                    ) : (
                                        [
                                            
                                        ]
                                    )
                                    
                                ],
                            ]
                        )
                        ?>
                    </div>

                </div>
                <!-- /sidebar menu -->

                <!-- /menu footer buttons -->
                <div class="sidebar-footer hidden-small">
                    <a data-toggle="tooltip" data-placement="top" title="Sair" url= <?= Url::to(['site/logout'])?> data-method='POST'>
                        <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                    </a>
                </div>
                <!-- /menu footer buttons -->
            </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">

            <div class="nav_menu">
                <nav class="" role="navigation">
                    <div class="nav toggle">
                        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                    </div>

                    <ul class="nav navbar-nav navbar-right">
                        <li class="">
                            <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <img src="http://placehold.it/128x128" alt="">
                                <?php 
                                    //NOME
                                    if(!Yii::$app->user->isGuest)
                                    { 
                                        echo Yii::$app->user->identity->nome; 
                                    } 
                                ?>
                                <span class=" fa fa-angle-down"></span>
                            </a>
                            <ul class="dropdown-menu dropdown-usermenu pull-right">
                                <!-- <li><a href="javascript:;">  Profile</a>
                                </li>
                                <li>
                                    <a href="javascript:;">
                                        <span class="badge bg-red pull-right">50%</span>
                                        <span>Settings</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:;">Help</a>
                                </li> -->
                                <li>
                                <?php
                                    if(Yii::$app->user->isGuest){
                                        echo '<a href="'.
                                        Url::to(['site/login'])
                                        .'">Logar</a>';
                                    }
                                    else{
                                        //echo '<a>'. 
                                        //Html::beginForm(['/site/logout'], 'post')
                                        //. Html::submitButton(
                                        //    'Logout (' . Yii::$app->user->identity->nome . ')',
                                        //    ['class' => 'fa fa-sign-out pull-right']
                                        //)
                                        //. Html::endForm()
                                        //.'</a>';
                                        echo Html::a('<i class="fa fa-sign-out pull-right"></i>'.'Sair', Url::to(['site/logout']), ['data-method' => 'POST']);
                                    }
                                ?>
                                <!-- <li><a href="login.html"><i class="fa fa-sign-out pull-right"></i> Log Out</a> -->
                                </li>
                            </ul>
                        </li>

                        

                    </ul>
                </nav>
            </div>

        </div>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
            <?php if (isset($this->params['h1'])): ?>
                <div class="page-title">
                    <div class="title_left">
                        <h1><?= $this->params['h1'] ?></h1>
                    </div>
                    <div class="title_right">
                        <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search for...">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button">Go!</button>
                            </span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <div class="clearfix"></div>

            <?= $content ?>
        </div>
        <!-- /page content -->
        <!-- footer content -->

        <!-- /footer content -->
    </div>

</div>

<div id="custom_notifications" class="custom-notifications dsp_none">
    <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
    </ul>
    <div class="clearfix"></div>
    <div id="notif-group" class="tabbed_notifications"></div>
</div>
<!-- /footer content -->
<?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage(); ?>