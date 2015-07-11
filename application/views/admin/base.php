<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title></title>
        <meta name="description" content="">

		<link rel="shortcut icon" href="<?=base_url()?>favicon.ico" type="image/x-icon">
		<link rel="icon" href="<?=base_url()?>favicon.ico" type="image/x-icon">
		
		<link rel="stylesheet" type="text/css" href="<?=base_url()?>include/css/smoothness/jquery-ui-1.10.4.custom.min.css" />
		<link rel="stylesheet" type="text/css" href="<?=base_url()?>include/css/bootstrap.css">
		<link rel="stylesheet" type="text/css" href="<?=base_url()?>include/css/font-awesome.css">
        <link rel="stylesheet" type="text/css" href="<?=base_url()?>include/css/main.css">

		<link rel="stylesheet" type="text/css" href="<?=base_url()?>include/css/bootstrap-modal-bs3patch.css" />
		<link rel="stylesheet" type="text/css" href="<?=base_url()?>include/css/bootstrap-modal.css" />

		<link rel="stylesheet" type="text/css" href="<?=base_url()?>include/css/alertify.core.css" />
		<link rel="stylesheet" type="text/css" href="<?=base_url()?>include/css/alertify.bootstrap.css" />
		
		<link rel="stylesheet" type="text/css" href="<?=base_url()?>include/css/dataTables.bootstrap.css" />
		<link rel="stylesheet" type="text/css" href="<?=base_url()?>include/css/datatables.responsive.css" />
		<link rel="stylesheet" type="text/css" href="<?=base_url()?>include/css/TableTools.css" />
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<script>window.jQuery || document.write('<script src="<?=base_url()?>include/js/vendor/jquery-1.10.2.min.js"><\/script>')</script>
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
		<script src="<?=base_url()?>include/js/jquery-ui-1.10.3.custom.min.js"></script>
		<script src="<?=base_url()?>include/js/vendor/bootstrap.min.js"></script>
		
		<script src="<?=base_url()?>include/js/bootstrap-modalmanager.js"></script>
		<script src="<?=base_url()?>include/js/bootstrap-modal.js"></script>
		
		<script src="<?=base_url()?>include/js/alertify.js"></script>
		<script src="<?=base_url()?>include/js/jquery.form.js"></script>
		
		<script src="<?=base_url()?>include/js/jquery.dataTables.min.js"></script>
		<script src="<?=base_url()?>include/js/jquery.dataTables.columnFilter.js"></script>
		<script src="<?=base_url()?>include/js/TableTools.min.js"></script>
		<script src="<?=base_url()?>include/js/datatables.bootstrap.js"></script>
		<script src="<?=base_url()?>include/js/datatables.responsive.js"></script>
		
		<script>
			var base_url = "<?=base_url()?>";
			var admin = {};
		</script>
		<script src="<?=base_url()?>include/js/admin.builder.js"></script>
    </head>
    <body>
		<div class="main_wrapper">
			<header class="navbar navbar-default navbar-fixed-top" role="navigation">
			  <div class="container">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<a class="navbar-brand" href="#"><img src="//placehold.it/200x50" id="main_logo" /></a>
					</div>
					<div class="collapse navbar-collapse">
						<ul class="nav navbar-nav pull-right">
							<li><a href="<?=site_url("user/logout")?>"><i class="fa fa-close"></i> Logout</a></li>
						</ul>
					</div><!--/.nav-collapse -->
				</div>
			</header>
			<section id="contenido" class="container">
				<!--[if lt IE 7]>
				<div class="row">
					<div class="alert alert-warning" role="alert">
						You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.
					</div>
				</div>	
				<![endif]-->
				<div class="row">
					<ul class="nav nav-tabs" role="tablist">
						<li class="<?=($this->router->method == "recipes")?"active":""?>"><a href="<?=site_url("panel/recipes")?>">Recipes</a></li>
						<li class="<?=($this->router->method == "pictures")?"active":""?>"><a href="<?=site_url("panel/pictures")?>">Pictures</a></li>
						<li class="<?=($this->router->method == "categories")?"active":""?>"><a href="<?=site_url("panel/categories")?>">Categories</a></li>
						<? if( $logged_in['role']==1 ){?>
						<li class="<?=($this->router->method == "users")?"active":""?>"><a href="<?=site_url("panel/users")?>">Users</a></li>
						<?}?>
						<li class="<?=($this->router->method == "banners")?"active":""?>"><a href="<?=site_url("panel/banners")?>">Banners</a></li>
						<li class="<?=($this->router->method == "videos")?"active":""?>"><a href="<?=site_url("panel/videos")?>">Videos</a></li>
					</ul>
				</div>
				<div class="row">
					<?=$contenido?>
				</div>
			</section>
			<footer class="container">
				<div class="row">
					<hr/>
					<p>COMERCIALIZADORA PEPSICO MEXICO S. DE RL. DE C.V. ®PepsiCo. Inc México 2014. Todos los derechos reservados.</p>
				</div>
			</footer>
			<div id="meta_modal"></div>
		</div>
		<script>
			$(function(){
				$.fn.modal.defaults.spinner = $.fn.modalmanager.defaults.spinner = 
				  '<div class="loading-spinner" style="width: 200px; margin-left: -100px;">' +
					'<div class="progress progress-striped active">' +
					  '<div class="progress-bar" style="width: 100%;"></div>' +
					'</div>' +
				  '</div>';

				$.fn.modalmanager.defaults.resize = true;
				
				$.datepicker.setDefaults({
					dateFormat:"dd/mm/yy",
					changeMonth: true,
					changeYear: true,
					yearRange: "-10:+10"
				});

				$(document).on('focus',".datepicker", function(){
					$(this).datepicker({
						dateFormat:"dd/mm/yy",
						changeMonth: true,
						changeYear: true,
						yearRange: "-10:+10"
					});
				});
			});
		</script>
	</body>
</html>