<?php
class MY_Form_validation extends CI_Form_validation
{
    function __construct($config = array())
    {
        parent::__construct($config);
    }
	
	public function is_words_only($str)
	{
		return (bool) preg_match( '/^[a-záéíóúäëïöüñâêîôû\'\s\-]+$/i', $str);
	}
	
	public function words_only($str)
	{
		return preg_replace( '/[^a-záéíóúäëïöüñâêîôû\'\s\-]/i', '', $str);
	}
}