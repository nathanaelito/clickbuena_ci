<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 3.2 Final//ES">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<h1>Mensaje de contacto para SITIO</h1>
<p>
	<strong>Nombre: </strong> <?=$name?><br>
	<strong>Correo: </strong> <?=$email?><br>
	<strong>Mensaje: </strong><br><?=$message?><br>
</p>
<p>
	<strong>Agent: </strong> <?=$agent?><br>
	<strong>Sesión: </strong><br/>
	<?
		if(!empty($logged_in)){
			foreach($logged_in as $k_log => $var_log){
				echo "\t".$k_log.":".$var_log."<br/>";
			}
		}
	?>
</p>
</body>
</html>