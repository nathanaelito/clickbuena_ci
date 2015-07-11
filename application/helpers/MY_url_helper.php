<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	if ( ! function_exists('cdn_url'))
	{
		function cdn_url()
		{
			$CI =& get_instance();
			return $CI->config->item('cdn_url');
		}
	}
	
	if ( ! function_exists('app_version'))
	{
		function app_version()
		{
			$CI =& get_instance();
			return $CI->config->item('version');
		}
	}
	
	if ( ! function_exists('fb_id'))
	{
		function fb_id()
		{
			$CI =& get_instance();
			$CI->config->load('facebook');
			return $CI->config->item('facebook_app_id');
		}
	}