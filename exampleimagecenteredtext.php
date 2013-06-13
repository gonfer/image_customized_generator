<?php
/**
 * Author: Ing. Gonzalo Federico Fernández
 * User: gonza
 * Date: 6/12/13
 * Time: 5:40 PM
 * File: exampleimagecenteredtext.php
 */

require_once('./library/GF_Generator_Image.php');
require_once('./library/GF_Generator_Text.php');

$img_background = "./images/chewbaca.jpg";

$objImageGenerator = new GF_Generator_Image();
$objImageGenerator->createBackgroundFromImage($img_background);

$objText = new GF_Generator_Text();
$objText->debug = true;

$texto_inside_image = "hola\nmundo";
$objText->setText($texto_inside_image);
$objText->setAngle($_GET['angle']);

$objText->setCoordinatesForCenteredText($objImageGenerator->getImg());

$objText->addTextToGivenImage($objImageGenerator->getImg());

$objImageGenerator->renderCachedImage();