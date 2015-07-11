<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('redimensionar'))
{
	function redimensionar($imagen,$width,$height,$crop=true,$destino="", $watermark=""){
		$ci = get_instance();
		$ci->load->library('image_lib');
		$config['source_image'] = $imagen;
		if($crop){
			$info = @getimagesize($imagen);
			if($info){
				$orig_w = $info[0];
				$orig_h = $info[1];
			}else
				return false;
			
			$x_axis = 0;
			$y_axis = 0;
			
			$p_img = $orig_h * 100 / $orig_w;
			if($p_img <= (($height*100)/$width)){ //escala relacion 580x325
				$config['master_dim'] = 'height';
				$config['height'] = $height;
				$new_width = $orig_w * ($height / $orig_h);
				$config['width'] = $new_width;
				
				$x_axis = ($new_width - $width) / 2;
			}else{
				$config['master_dim'] = 'width';
				$config['width'] = $width;
				$new_height = $orig_h * ($width / $orig_w);
				$config['height'] = $new_height;
				
				$y_axis = ($new_height - $height) / 2 ;
			}
		}else{
			$config['master_dim'] = 'auto';
			$config['width'] = $width;
			$config['height'] = $height;
		}
		if(!empty($destino)){ $config['new_image'] = $destino; }
		$ci->image_lib->initialize($config);  
		$ci->image_lib->resize();
		$ci->image_lib->clear();

		if($crop){
			if(!empty($destino)){ $config['source_image'] = $destino."/".$ci->image_lib->dest_image; }else{  $config['source_image'] = $imagen; }
			$config['width'] = $width;
			$config['height'] = $height;
			$config['x_axis'] = $x_axis;
			$config['y_axis'] = $y_axis;
			$config['maintain_ratio'] = FALSE;
			
			$ci->image_lib->initialize($config);  
			$ci->image_lib->crop();
			$ci->image_lib->clear();
		}
		
		if(!empty($watermark)){
			$config['wm_overlay_path'] = $watermark; //'./images/watermark.png'
			$config['wm_type'] = 'overlay';
			$config['wm_vrt_alignment'] = 'bottom';
			$config['wm_hor_alignment'] = 'right';
			$ci->image_lib->initialize($config);
			$ci->image_lib->watermark();
			$ci->image_lib->clear();
		}
	}
}