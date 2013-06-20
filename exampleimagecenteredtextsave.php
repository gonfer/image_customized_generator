<?php
/**
 * Author: Ing. Gonzalo Federico Fernández
 * User: gonza
 * Date: 6/12/13
 * Time: 5:40 PM
 * File: exampleimagecenteredtextsve.php
 */

require_once('./library/GF_Generator_Image.php');
require_once('./library/GF_Generator_Text.php');

$img_background = "./images/chewbaca.jpg";

$objImageGenerator = new GF_Generator_Image();
$objImageGenerator->createBackgroundFromImage($img_background);

$objText = new GF_Generator_Text();
$objText->debug = true;

$texto_inside_image = "hola\nmundo que tal\n como les va";
$objText->setText($texto_inside_image);
$objText->setAngle($_GET['angle']);

$objText->setCoordinatesForCenteredText($objImageGenerator->getImg());

$objText->addTextToGivenImage($objImageGenerator->getImg());

$image_path_full = "images/generated/full/full.png";

$objImageGenerator->generateImageFile($image_path_full);

$image_path_thumb = "images/generated/thumb/thumb.png";

$objImageGenerator->generateThumbImageFile($image_path_thumb);

$objImageGenerator->renderCachedImage();

