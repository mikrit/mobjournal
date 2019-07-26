<?php defined('SYSPATH') or die('No direct script access.');?>

<div class="row">
	<div class="col-md-12">
		<h1>Молекулярно - биологическая лаборатория</h1>
	</div>
</div>

<style>
	#status{
		background-color: #dfdfdf;
		background-image: none;
		border: 1px solid #ccc;
		border-radius: 4px;
		box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset;
		color: #555;
		min-height: 34px;
		display: block;
		font-size: 14px;
		line-height: 1.42857;
		padding: 6px 12px;
		transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;
		width: 100%;
	}

	/* Small devices (tablets, 768px and up) */
	@media (min-width: @screen-xs-min) {
		#status{
			height: 68px;
		}
	}

	/* Small devices (tablets, 768px and up) */
	@media (min-width: @screen-sm-min) {
		#status{
			height: 68px;
		}
	}

	/* Medium devices (desktops, 992px and up) */
	@media (min-width: @screen-md-min) {
		#status{
			height: 34px;
		}
	}

	/* Large devices (large desktops, 1200px and up) */
	@media (min-width: @screen-lg-min) {
		#status{
			height: 34px;
		}
	}
</style>


<div class="row" style="padding-bottom: 10px;">
	<div class="col-md-8">
		<div class="jumbotron card">
			<h2>Проверить анализ</h2>
			<div id="error_fio" class="alert alert-danger" role="alert" style="display: none">
				<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
				<span class="sr-only">Error:</span> Проверьте правильность написания ФИО
			</div>
			<form id="search" class="form-signin" method="post">
				<?=Form::input('ФИО', '', array('type' => 'text', 'id' => 'fio', 'placeholder' => 'ФИО', 'class' => 'form-control', 'required' => ''));?>
				<?=Form::input('Номер анализа', '', array('type' => 'text', 'id' => 'number', 'placeholder' => '№ исследования', 'class' => 'form-control', 'required' => ''));?>
				<?=HTML::anchor('#', 'Проверить', array('id' => 'check_analiz', 'class' => 'btn btn-primary ladda-button', 'data-style' => 'zoom-in'));?>
			</form>
		</div>
	</div>

	<div class="col-md-4">
		<div class="card card-container">
			<h3>Статус:</h3>
			<br/>
			<div>
				<b id="status"></b>
			</div>
		</div>
	</div>
</div>

<script>
	$('#check_analiz').click(function(){
		var l = Ladda.create(document.querySelector('.ladda-button')).start();

		var fio = $('#fio').val();
		var number = $('#number').val();

		$('#fio').css({'border-color': '#ccc'});
		$('#number').css({'border-color': '#ccc'});

		$('#error_fio').hide();

		if(fio == '' || number == '')
		{
			if(fio == '')
			{
				$('#fio').css({'border-color': '#FF2D3F'});
			}

			if(number == '')
			{
				$('#number').css({'border-color': '#FF2D3F'});
			}

			l.stop();
		}
		else
		{
			var pat = /[А-ЯЁ][а-яё\-]+\s(\-?[А-ЯЁ]\.|[А-ЯЁ]-[А-ЯЁ]\.){2,}$/;

			if(pat.test(fio) == false)
			{
				$('#error_fio').show();
				l.stop();
			}
			else
			{
				$.ajax({
					type: "POST",
					url: "ajax/get_status",
					dataType: "json",
					data: {
						fio: fio,
						number: number
					},
					success: function(result){
						l.stop();
						$('#status').html(result);
					}
				});
			}
		}

		return false;
	});
</script>