<?php
/**
 * @package canvasio3d
 * @version 2.5.1
 */
/*
Plugin Name: Canvasio3D Light
Plugin URI: https://www.canvasio3d.com/canvasio3d/
Description: Free 3D-Model Viewer - Read more in the <a href="https://www.canvasio3d.com/pub/doc/canvasio3d/">documentation</a>
Author: Thomas Scholl
Version: 2.5.1
Author URI: http://www.virtuellwerk.de/
*/
if(!defined('ABSPATH')){exit;}
//
$GLOBALS["caArID"]=0;
$GLOBALS["caArVersion"]='2.5.1';
$GLOBALS["caHank"]='1';
//
function canvasio3d_upload_mimes($existing_mimes=array()){
	$existing_mimes['img']='image/img';
	$existing_mimes['gltf']='mesh/plain';
	$existing_mimes['glb']='mesh/plain';
	$existing_mimes['mtl']='text/plain';
	$existing_mimes['obj']='mesh/plain';
	$existing_mimes['stl']='mesh/plain';
	$existing_mimes['fbx']='mesh/plain';
	//
	return $existing_mimes;
}
add_filter('upload_mimes', 'canvasio3d_upload_mimes');
//
function fP_MimeTypes($post_mime_types) {
	$post_mime_types['mesh/plain'] = array('3D-Models', 'Manage 3D-Model', _n_noop('3D-Model <span class="count">(%s)</span>', '3D-Models <span class="count">(%s)</span>'));
	return $post_mime_types;
}
add_filter('post_mime_types', 'fP_MimeTypes');
//
include('inc/caFunctions.php');
?>
