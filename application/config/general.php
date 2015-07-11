<?php
	$ci = &get_instance();
	$config['cdn_url'] = $ci->config->item("base_url");
	
	/* Sistema de pantalla de mantenimiento, Ej:
	$config['maintenance'] = false;
	$config['maintenance'] = true;
	$config['maintenance'] = array(
		"inicio" => array("index")
	);
	$config['maintenance'] = array(
		"usuario" => array("recupera","registro")
	);
	*/
	$config['maintenance'] = false;
	$config['version'] = "0.1";
