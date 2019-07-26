<?php defined('SYSPATH') or die('No direct script access.');?>

<div class="col-md-4">
	<div class="card card-container">
		<h3><strong>Вход</strong></h3>
		<br/>
		<div id="error"></div>
		<form class="form-signin" method="post" action="rrr.php">
			<?=Form::input('login', '', array('type' => 'text', 'id' => 'login', 'placeholder' => 'Ваш логин', 'class' => 'form-control', 'required' => ''));?>
			<?=Form::password('password', '', array('type' => 'password', 'id' => 'password', 'placeholder' => 'Ваш пароль', 'class' => 'form-control', 'required' => ''));?>
			<?=HTML::anchor('#', 'Войти', array('id' => 'login_ajax', 'class' => 'btn btn-primary ladda-button', 'data-style' => 'zoom-in'));?>
		</form>
		<div class="text-center">
			<a href="#" data-toggle="modal" data-target="#myModal2">
				Забыли пароль?
			</a>
		</div>
	</div>
</div>

<!-- Modal -->
<div id="myModal" class="modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-sm2">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title" id="myModalLabel">Регистрация</h4>
			</div>
			<div id="error_reg"></div>
			<div class="modal-body">
				<form action="#" method="post" class="form" role="form">
					<input class="form-control form-control2" name="username" id="username" placeholder="Логин" type="text">
					<div id="error_username"></div>
					<input class="form-control form-control2" name="email" id="email" placeholder="Email" type="email">
					<div id="error_email"></div>
					<input class="form-control form-control2" name="password_reg" id="password_reg" placeholder="Пароль" type="password">
					<div id="error_password_reg"></div>
					<input class="form-control form-control2" name="password_confirm_reg" id="password_confirm_reg" placeholder="Повторите пароль" type="password">
					<div id="error_password_confirm_reg"></div>
					<?= HTML::anchor('#', 'Регистрация', array('id' => 'registration_ajax', 'class' => 'btn btn-lg btn-primary btn-block btn-block2'));?>
					<!--button class="btn btn-lg btn-primary btn-block btn-block2" type="submit">Регистрация</button-->
				</form>
			</div>
		</div>
	</div>
</div>

<div id="myModal2" class="modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-sm2">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Вспомнить пароль</h4>
			</div>
			<div class="modal-body">
				<form action="#" method="post" class="form" role="form">
					<input class="form-control form-control2" name="username" placeholder="Логин" type="text" required autofocus />
					<input class="form-control form-control2" name="email" placeholder="Email" type="email" />
					<button class="btn btn-lg btn-primary btn-block btn-block2" type="submit">Вспомнить</button>
				</form>
			</div>
		</div>
	</div>
</div>