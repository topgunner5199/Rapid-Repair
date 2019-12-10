<?php

error_reporting(E_ERROR | E_PARSE);
$web_root = "http://".$_SERVER['HTTP_HOST']."/";
 ?>
<!DOCTYPE html>

<html>

 <head>

  <meta charset="UTF-8">

  <title>Rapid Response Auto Service</title>

  <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>
  
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>

  <script src="<?php echo $web_root; ?>lib/js/footable.js" type="text/javascript"></script>
  <script src="<?php echo $web_root; ?>lib/js/footable.paginate.js" type="text/javascript"></script>
  <link href="<?php echo $web_root; ?>lib/css/footable.core.min.css" rel="stylesheet" type="text/css" />
  <script src="<?php echo $web_root; ?>lib/chosen/chosen.jquery.js" type="text/javascript"></script>
  <link href="<?php echo $web_root; ?>lib/chosen/chosen.min.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" type="text/css" href="<?php echo $web_root; ?>lib/css/style.css">

  <script src="<?php echo $web_root; ?>lib/js/main.js"></script>


 </head>

 <body>

	<div id="Wrapper">

		<header>
    <h6>Logged in as <?php echo htmlentities($_SESSION['user']['EMP_USERNAME'], ENT_QUOTES, 'UTF-8'); ?>.</h6><br /> 

			<img id="Logo" src="<?php echo $web_root; ?>assets/logo.png">

			<nav>

				<?php require("menu.php"); ?>

			</nav>

			<div class="clear"></div>

		</header>