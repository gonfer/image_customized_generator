<?php
/**
 * Author: Ing. Gonzalo Federico Fernández
 * User: gonza
 * Date: 6/12/13
 * Time: 2:52 PM
 * File: exampleimageurl.php
 */

require_once('./library/GF_Generator_Image.php');
require_once('./library/GF_Generator_Text.php');

$img_background = "./images/chewbaca.jpg";

if($_GET['url']){
	$url = $_GET['url'];
}else{
	$url = "http://www.fondos10.net/wp-content/uploads/2009/10/halloween-pumpkin-wallpaper-1024x7581.jpg";
}

$objImageGenerator = new GF_Generator_Image();
$objImageGenerator->createBackgroundFromUrlImage($url);

$objText = new GF_Generator_Text();
$objText->setText($_GET['text']);
$objText->setAngle($_GET['angle']);
$objText->setXOrdinate($_GET['x']);
$objText->setYOrdinate($_GET['y']);
$objText->addTextToGivenImage($objImageGenerator->getImg());

$objImageGenerator->renderCachedImage();
