<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$autoload['packages'] = array();
$autoload['libraries'] = array('session', 'form_validation', 'upload');
$autoload['drivers'] = array();
$autoload['helper'] = array('url','form','html', 'text','security');
$autoload['config'] = array();
$autoload['language'] = array();
$autoload['model'] = array('Alumni_model','User_model','Page_model','News_model','Alumni_foto_model');
