<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

function form_ckeditor($data)
{
    return '<script type="text/javascript" src="'.base_url().'application/plugins/ckeditor/ckeditor.js"></script>' .
     '<script type="text/javascript">CKEDITOR.replace("'.$data['id'].'");</script>';
} 
