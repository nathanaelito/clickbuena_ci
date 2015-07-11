<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Captcha extends MY_Controller {
	public function __construct(){
		parent::__construct();
	}

	public function index( $width=0, $height=0 ){
		$width += 0;
		$height += 0;

		$this->load->library('securimage');

		//$this->securimage->ttf_file        = './Quiff.ttf';
		//$this->securimage->captcha_type    = Securimage::SI_CAPTCHA_MATHEMATIC; // show a simple math problem instead of text
		//$this->securimage->case_sensitive  = true;                              // true to use case sensitve codes - not recommended
		$this->securimage->image_height    = (is_int($height) && $height>0 && $height<=200)?$height:40;                                // width in pixels of the image
		$this->securimage->image_width     = (is_int($width) && $width>0 && $width<=400)?$width:150;          // a good formula for image size

		$this->securimage->perturbation    = .75;                               // 1.0 = high distortion, higher numbers = more distortion
		//$this->securimage->image_bg_color  = new Securimage_Color("#0099CC");   // image background color
		//$this->securimage->text_color      = new Securimage_Color("#EAEAEA");   // captcha text color
		//$this->securimage->text_color      = new Securimage_Color( rand(0, 64),
		//                                            rand(64, 128),
		//											rand(128, 255));   // captcha text color
		$this->securimage->num_lines       = 0;                                 // how many lines to draw over the image
		$this->securimage->noise_level       = 0;                                 // Noise in image
		$this->securimage->use_wordlist      = true;                                 // 
		$this->securimage->wordlist_file     = $this->securimage->securimage_path.'/words/6letras.txt';
		//$this->securimage->line_color      = new Securimage_Color("#0000CC");   // color of lines over the image
		//$this->securimage->image_type      = SI_IMAGE_JPEG;                     // render as a jpeg image
		//$this->securimage->image_signature = 'yourdomain.com';
		//$this->securimage->signature_color = new Securimage_Color(rand(0, 64),
		//                                            rand(64, 128),
		//											rand(128, 255));  // random signature color

		// see securimage.php for more options that can be set



		//$this->securimage->show();  // outputs the image and content headers to the browser
		// alternate use: 
		$this->securimage->show('include/img/bg3.jpg');
	}
}