<?php
/**
 * Author: Ing. Gonzalo Federico Fernández
 * User: gonza
 * Date: 6/12/13
 * Time: 2:52 PM
 * File: index.php
 */

require_once('./library/GF_Generator_Image.php');
require_once('./library/GF_Generator_Text.php');

$img_background = "./images/chewbaca.jpg";

$objImageGenerator = new GF_Generator_Image();
$objImageGenerator->createBackgroundFromImage($img_background);

$objText = new GF_Generator_Text();
$objText->setText($_GET['text']);
$objText->setAngle($_GET['angle']);
$objText->setXOrdinate($_GET['x']);
$objText->setYOrdinate($_GET['y']);
$objText->addTextToGivenImage($objImageGenerator->getImg());

$objImageGenerator->renderImage();