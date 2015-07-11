<?php if(!defined('BASEPATH')) exit('Direct Access Not Allowed');

/* This Application Must Be Used With BootStrap 3 *  */
$config['full_tag_open'] = "<ul class='pagination'>";
$config['full_tag_close'] ="</ul>";
$config['num_tag_open'] = '<li>';
$config['num_tag_close'] = '</li>';
$config['cur_tag_open'] = "<li class='active'><a href='#'>";
$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
$config['next_tag_open'] = "<li>";
$config['next_tagl_close'] = "</li>";
$config['prev_tag_open'] = "<li>";
$config['prev_tagl_close'] = "</li>";
$config['prev_tag_close'] = "</li>";
$config['first_tag_open'] = "<li>";
$config['first_tagl_close'] = "</li>";
$config['first_tag_close'] = "</li>";
$config['last_tag_open'] = "<li>";
$config['last_tagl_close'] = "</li>";
$config['prev_link'] = '&lt;';
$config['next_link'] = '&gt;';
$config['first_link'] = '&lt;&lt;'; 
$config['last_link'] = '&gt;&gt;';
$config['per_page'] = '6';
$config['num_links'] = '6';
$config['enable_query_strings'] = TRUE;
$config['use_page_numbers'] = TRUE;
$config['base_url'] = base_url();
$config['total_rows'] = 0;


// end of file Pagination.php 
// Location config/pagination.php 