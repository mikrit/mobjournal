<?php defined('SYSPATH') or die('No direct script access.');?>

<!DOCTYPE html>
<html lang="ru">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="">

		<title>Молекулярно - биологическая лаборатория</title>

		<?=Html::style('media/bootstrap/css/bootstrap.min.css')?>
		<?=Html::style('media/css/sticky-footer-navbar.css')?>
		<?=Html::style('media/css/ladda-themeless.min.css')?>

		<?=Html::script('media/js/jquery.js')?>
		<?=Html::script('media/js/login.js')?>
		<?=Html::script('media/js/spin.min.js')?>
		<?=Html::script('media/js/ladda.min.js')?>
		<?=Html::script('media/bootstrap/js/bootstrap.min.js')?>

		<link rel="apple-touch-icon" href="media/img/mikro.png">
		<link rel="icon" href="media/img/mikro.ico">
	</head>

    <body>
        <div class="navbar navbar-default navbar-fixed-top" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <!--button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button-->
                    <?=Html::image('media/img/logo_4.png', array('width' => 50, 'height' => 50));?>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </div>
                <div class="collapse navbar-collapse">
                    <?=$menu?>
                </div>
            </div>
        </div>

        <div class="container col-">
            <?=$content?>
        </div>

        <div class="footer" id="footer">
            <div class="footer-inner">
                <div class="container">
                    <div class="row">
                        <p class="text-muted text-center"><small><a href="http://www.ai-tech.ru">ai-tech.ru</a> &copy;2019<?=(date('Y') != 2019) ? '-'.date('Y') : ''?> All Rights Reserved.</small></p>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>