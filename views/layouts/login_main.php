<?php 
    use app\widgets\Alert;
    use yii\helpers\Html;
    use yii\bootstrap\Nav;
    use yii\bootstrap\NavBar;
    use yii\widgets\Breadcrumbs;
    use app\assets\AppAsset;
    use yii\helpers\Url;

    AppAsset::register($this);
    $this->registerCssFile('@web/css/login.css'); 
    $this->registerCssFile("@web/css/menu.css");
?>
<?php $this->beginPage() ?>
<html>

<head>
  <link rel="stylesheet" href="css/style.css">
  <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
  <title>Entrar no Sistema</title>
  <?php $this->head() ?>
</head>

<body>
<?php $this->beginBody() ?>
  <div class="main">
    <!-- <p class="sign" align="center">Sign in</p>
    <form class="form1">
      <input class="un " type="text" align="center" placeholder="Username">
      <input class="pass" type="password" align="center" placeholder="Password">
      <a class="submit" align="center">Sign in</a>
      <p class="forgot" align="center"><a href="#">Forgot Password?</p> -->
      <?= $content ?>
                
    </div>
     
<?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>
