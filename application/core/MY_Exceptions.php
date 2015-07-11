<?php  if (! defined('BASEPATH')) exit('No direct script access allowed');
// application/core/MY_Exceptions.php
class MY_Exceptions extends CI_Exceptions {
    function show_404($page = '', $log_error = TRUE)
	{
		// By default we log this, but allow a dev to skip it
		if ($log_error)
		{
			log_message('error', '404 Page Not Found --> '.$page);
		}

		$CI =& get_instance();
		$CI->output->set_status_header('404');
        $CI->load->view('screen/error_404');
        echo $CI->output->get_output();
		exit;
	}
}