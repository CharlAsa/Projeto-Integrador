<?php

/* @var $this yii\web\View */

use yii\helpers\Url;
use yii\helpers\html;

use marekpetras\calendarview\CalendarView;

$this->title = 'My Yii Application';

$this->registerCssFile(
    '@web/css/calendario.css',
);

$lil = 1;

$this->registerJsFile(
    '@web/js/dafuq.js',
);

?>
<div class="site-index">

    <?php if (Yii::$app->session->hasFlash('warn')): ?>
        <div class="alert alert-warning alert-dismissable">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            <h4><i class="icon fa fa-check"></i>Erro!</h4>
            <?= Yii::$app->session->getFlash('error') ?>
        </div>
    <?php endif; ?>

    <!-- <div class="jumbotron">
        <h1>Congratulations!</h1>

        <p class="lead">You have successfully created your Yii-powered application.</p>

        <p><a class="btn btn-lg btn-success" href="http://www.yiiframework.com">Get started with Yii</a></p>
		
		<?php if(!Yii::$app->user->isGuest) {  ?>
		<p><a class="btn btn-lg btn-success" href="<?= Url::to(['usuario/cadastrarpaciente']) ?>">Cadastrar Paciente</a></p>
		<?php } ?>
	</div>

    -->
    <!--
    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/doc/">Yii Documentation &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/forum/">Yii Forum &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/extensions/">Yii Extensions &raquo;</a></p>
            </div>
        </div>

    </div>
    -->
    <!--
    <div class="container">
        <h2>Carousel Example</h2>  
        <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <!-- Indicators -->
        <!--<ol class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#myCarousel" data-slide-to="1"></li>
            <li data-target="#myCarousel" data-slide-to="2"></li>
        </ol>

        <!-- Wrapper for slides -->
        <!--<div class="carousel-inner">
            <div class="item active">
            <img src='img/img1.jpg' alt="Los Angeles">
            </div>

            <div class="item">
            <img src='img/img2.jpg' alt="Chicago">
            </div>

            <div class="item">
            <img src='img/img4.BMP' alt="New York">
            </div>
        </div>

        <!-- Left and right controls -->
        <!--<a class="left carousel-control" href="#myCarousel" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#myCarousel" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right"></span>
            <span class="sr-only">Next</span>
        </a>
        
        </div>
    </div> -->

<?php if($tempo != null){ ?>
    <?php if($tempo["op"] == 1) { ?>
        <table class="tabela">
                <tr>
                    <td colspan="7" class="car_bloco_ano_nome" id="car_bloco_ano_nome" value="<?php echo $tempo["valor"]["ano"] ?>"> <?php echo $tempo["valor"]["ano"]; ?> </td>
                </tr>
                <tr>
                    <td colspan="7" class="car_bloco_mes_nome" id="car_bloco_mes_nome" value="<?php echo $tempo["valor"]["mes"] ?>"> <?php echo ($tempo["valor"]["mes"] == 1) ? ( "Janeiro" ) : ($tempo["valor"]["mes"] == 2 ? ( "Fevereiro" ) : ($tempo["valor"]["mes"] == 3 ? ( "Março" ) : ($tempo["valor"]["mes"] == 4 ? ( "Abril" ) : ($tempo["valor"]["mes"] == 5 ? ( "Maio" ) : ($tempo["valor"]["mes"] == 6 ? ( "Junho" ) : ($tempo["valor"]["mes"] == 7 ? ( "Julho" ) : ($tempo["valor"]["mes"] == 8 ? ( "Agosto" ) : ($tempo["valor"]["mes"] == 9 ? ( "Setembro" ) : ($tempo["valor"]["mes"] == 10 ? ( "Outubro" ) : ($tempo["valor"]["mes"] == 11 ? ( "Novembro" ) : ($tempo["valor"]["mes"] == 12 ? ( "Dezembro" ) : "")))))))))))  ?> </td>
                </tr>
                <tr> 
                    <td class="car_bloco_dias_nome"> Domingo </td> 
                    <td class="car_bloco_dias_nome"> Segunda </td> 
                    <td class="car_bloco_dias_nome"> Terça </td> 
                    <td class="car_bloco_dias_nome"> Quarta </td> 
                    <td class="car_bloco_dias_nome"> Quinta </td> 
                    <td class="car_bloco_dias_nome"> Sexta </td> 
                    <td class="car_bloco_dias_nome"> Sabado </td> 
                </tr>
                <?php for($con = 0; $con < 6; $con++){ ?>
                    <tr>
                        <?php for($cons = $con * 7; $cons < ($con * 7) + 7; $cons++) { ?>
                                <td class="car_bloco_numero_nome" id="<?php if($tempo["valor"][$cons] != null){ echo $lil; $lil++; } else{echo -1;} ?>" onclick="evento(this)"> <?php echo $tempo["valor"][$cons]; ?> </td> 
                        <?php } ?>
                    </tr>
                <?php } ?>
                <tr> 
                     <table id="consultas" class="table table-hover" style='width:100%;'> 
                     
                     </table>
                </tr>
    <?php } else {?>

    <?php }?>
<?php } ?>

</div>