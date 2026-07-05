<?php
// includes/functions.php
function slugify($text){
$text = preg_replace('~[^\pL\d]+~u', '-', $text);
$text = iconv('utf-8','us-ascii//TRANSLIT', $text);
$text = preg_replace('~[^-\w]+~', '', $text);
$text = trim($text, '-');
$text = preg_replace('~-+~', '-', $text);
return strtolower($text);
}


function env_url(){
return rtrim((isset($_SERVER['HTTPS'])? 'https':'http') . '://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']), '/');
}