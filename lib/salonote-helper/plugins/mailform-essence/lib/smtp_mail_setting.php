<?php

/*  Copyright 2016 Healing Solutions (email : info@healing-solutions.jp)
 
    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
     published by the Free Software Foundation.
 
    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
 
    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$mail_form_essence_opt = get_option('mail_form_essence_options');
  
$mail_form_essence_opt['host']        = isset($mail_form_essence_opt['host'])        ? $mail_form_essence_opt['host']:        '';
$mail_form_essence_opt['SMTPAuth']    = isset($mail_form_essence_opt['SMTPAuth'])    ? $mail_form_essence_opt['SMTPAuth']:    '';
$mail_form_essence_opt['Port']        = isset($mail_form_essence_opt['Port'])        ? $mail_form_essence_opt['Port']:        '';
$mail_form_essence_opt['Username']    = isset($mail_form_essence_opt['Username'])    ? $mail_form_essence_opt['Username']:    '';
$mail_form_essence_opt['Password']    = isset($mail_form_essence_opt['Password'])    ? $mail_form_essence_opt['Password']:    '';
$mail_form_essence_opt['SMTPSecure']  = isset($mail_form_essence_opt['SMTPSecure'])  ? $mail_form_essence_opt['SMTPSecure']:  '';


add_action( 'phpmailer_init', 'configure_smtp' );
function configure_smtp( PHPMailer $phpmailer ){
    $phpmailer->isSMTP(); //switch to smtp
    $phpmailer->Host       = $mail_form_essence_opt['host'];
    $phpmailer->SMTPAuth   = $mail_form_essence_opt['SMTPAuth'];
    $phpmailer->Port       = $mail_form_essence_opt['Port'];
    $phpmailer->Username   = $mail_form_essence_opt['Username'];
    $phpmailer->Password   = $mail_form_essence_opt['Password'];
    $phpmailer->SMTPSecure = $mail_form_essence_opt['SMTPSecure'];
    $phpmailer->From       = 'From Email Here';
    $phpmailer->FromName   = 'Sender Name';
}

if(!$phpmailer ->Send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $phpmailer->ErrorInfo;
    exit;
}

?>