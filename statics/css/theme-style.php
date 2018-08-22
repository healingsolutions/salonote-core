<?php
header('Content-Type: text/css; charset=utf-8'); 
require( dirname( __FILE__ ) . '/../../../../../wp-blog-header.php');
echo '@charset "UTF-8";';

global $color_customize_array;
global $color_set;


get_template_part('lib/module/print_color_style');
echo $color_set;