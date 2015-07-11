<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Email
| -------------------------------------------------------------------------
| This file lets you define parameters for sending emails.
| Please see the user guide for info:
|
|	http://codeigniter.com/user_guide/libraries/email.html
|
*/
$config['mailtype'] = 'html';
$config['charset'] = 'utf-8';
$config['newline'] = "\r\n";

$config['protocol']='smtp';
$config['smtp_host']='secure.emailsrvr.com';
$config['smtp_port']='25'; 
$config['smtp_timeout']='30';
$config['smtp_user']='no-reply@saladitas.com.mx';
$config['smtp_pass']='xnAS7od7mV7M5ig';


/* End of file email.php */
/* Location: ./application/config/email.php */