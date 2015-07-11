<?
/*
* function that generate the action buttons edit, delete
* This is just showing the idea you can use it in different view or whatever fits your needs
*/
function get_buttons_user($id){
	$html= '<div data-id="'.$id.'" class="btn-group opciones">';
	$html .='	<a class="btn btn-default btn-xs edit_user" href="'.site_url('user/edit_form/'.$id).'" data-toggle="tooltip" title="Ver"><i class="fa fa-eye"></i></a>';
	$html .='	<a class="btn btn-default btn-xs eliminar_dt" href="'.site_url('user/delete/'.$id).'" data-toggle="tooltip" title="Eliminar"><i class="fa fa-trash"></i></a>';
	$html .='</div>';
	return $html;
}

function get_buttons_recipe($id){
	$html= '<div data-id="'.$id.'" class="btn-group opciones">';
	$html .='<a class="btn btn-default btn-xs edit_recipe" href="'.site_url('recipe/edit_form/'.$id).'" data-toggle="tooltip" title="Ver"><i class="fa fa-eye"></i></a>';
	$html .='<a class="btn btn-default btn-xs eliminar_dt" href="'.site_url('recipe/delete/'.$id).'" data-toggle="tooltip" title="Eliminar"><i class="fa fa-trash"></i></a>';
	$html .='</div>';
	return $html;
}

function get_buttons_picture($id){
	$html= '<div data-id="'.$id.'" class="btn-group opciones1">';
	$html .='<a class="btn btn-default btn-xs approve_picture" href="'.site_url('picture/approve/'.$id).'" data-toggle="tooltip" title="Aprobar"><i class="fa fa-check"></i></a>';
	$html .='<a class="btn btn-default btn-xs decline_picture" href="'.site_url('picture/decline/'.$id).'" data-toggle="tooltip" title="Rechazar"><i class="fa fa-times"></i></a>';
	$html .='</div> <div data-id="'.$id.'" class="btn-group opciones2">';
	$html .='<a class="btn btn-default btn-xs edit_picture" href="'.site_url('picture/edit_form/'.$id).'" data-toggle="tooltip" title="Ver"><i class="fa fa-eye"></i></a>';
	$html .='<a class="btn btn-default btn-xs eliminar_dt" href="'.site_url('picture/delete/'.$id).'" data-toggle="tooltip" title="Eliminar"><i class="fa fa-trash"></i></a>';
	$html .='</div>';
	return $html;
}

function get_buttons_category($id){
	$html= '<div data-id="'.$id.'" class="btn-group opciones">';
	$html .='<a class="btn btn-default btn-xs edit_category" href="'.site_url('category/edit_form/'.$id).'" data-toggle="tooltip" title="Ver"><i class="fa fa-eye"></i></a>';
	$html .='<a class="btn btn-default btn-xs eliminar_dt" href="'.site_url('category/delete/'.$id).'" data-toggle="tooltip" title="Eliminar"><i class="fa fa-trash"></i></a>';
	$html .='</div>';
	return $html;
}

function get_buttons_banner($id){
	$html= '<div data-id="'.$id.'" class="btn-group opciones">';
	$html .='<a class="btn btn-default btn-xs edit_banner" href="'.site_url('banner/edit_form/'.$id).'" data-toggle="tooltip" title="Ver"><i class="fa fa-eye"></i></a>';
	$html .='<a class="btn btn-default btn-xs eliminar_dt" href="'.site_url('banner/delete/'.$id).'" data-toggle="tooltip" title="Eliminar"><i class="fa fa-trash"></i></a>';
	$html .='</div>';
	return $html;
}

function get_buttons_video($id){
	$html= '<div data-id="'.$id.'" class="btn-group opciones">';
	$html .='<a class="btn btn-default btn-xs edit_video" href="'.site_url('video/edit_form/'.$id).'" data-toggle="tooltip" title="Ver"><i class="fa fa-eye"></i></a>';
	$html .='<a class="btn btn-default btn-xs eliminar_dt" href="'.site_url('video/delete/'.$id).'" data-toggle="tooltip" title="Eliminar"><i class="fa fa-trash"></i></a>';
	$html .='</div>';
	return $html;
}

