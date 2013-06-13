<?php
/**
 * Author: Ing. Gonzalo Federico Fernández
 * User: gonza
 * Date: 6/12/13
 * Time: 12:05 PM
 * File: GF_Generator_Text.php
 */

class GF_Generator_Text
{
	// Replace path by your own font path

	public $font = './fonts/mplus-1c-medium.ttf';
	public $font_size = 20;
	public $font_color =  null;
	protected $textangle = 0;
	protected $x_ordinate = 0;
	protected $y_ordinate = 0;
	protected $text = "";
	protected $bbox = null;
	public $debug = false;

	public function setBBox($bbox)
	{
		$this->bbox = $bbox;
	}

	public function getBBox()
	{
		return $this->bbox;
	}

	public function setText($text)
	{
		$this->text = $text;
	}

	public function getText()
	{
		return $this->text;
	}

	public function setXOrdinate($x_ordinate)
	{
		$this->x_ordinate = $x_ordinate;
	}

	public function getXOrdinate()
	{
		return $this->x_ordinate;
	}

	public function setYOrdinate($y_ordinate)
	{
		$this->y_ordinate = $y_ordinate;
	}

	public function getYOrdinate()
	{
		return $this->y_ordinate;
	}

	public function setAngle($textangle)
	{
		$this->textangle = $textangle;
	}

	public function getAngle()
	{
		return $this->textangle;
	}

	public function addTextToGivenImage($im)
	{
		$this->font_color = imagecolorallocate($im, 0, 0, 0);
		/*
			// Break it up into pieces 125 characters long
		$lines = explode('|', wordwrap($this->getText(), 15, '|'));

		$y = $this->getYOrdinate();
		// Loop through the lines and place them on the image
		foreach ($lines as $line)
		{
			imagettftext($im, $this->font_size, $this->getAngle(), $this->getXOrdinate(), $y, $this->font_color, $this->font, $line);

			// Increment Y so the next line is below the previous line
			$y += 23;
		}
*/
		imagettftext($im, $this->font_size, $this->getAngle(), $this->getXOrdinate(), $this->getYOrdinate(), $this->font_color, $this->font, $this->getText());
	}

	protected function createBoundingBox()
	{
		// First we create our bounding box for the first text
		$this->setBBox(imagettfbbox($this->font_size, $this->getAngle(), $this->font, $this->getText()));
	}

	public function addDebugText($im, $text)
	{
		if($this->debug)
		{
			imagettftext($im, 9, 0, 2, 23, $this->font_color, $this->font, $text);
		}

	}

	public function setCoordinatesForCenteredText($img)
	{
		$this->createBoundingBox();

		$bbox = $this->getBBox();

		$half_image_x = imagesx($img) / 2;
		$half_image_y = imagesy($img) / 2;

		$half_text_x = abs($bbox[2] / 2);
		$half_text_y = abs($bbox[5] / 2);


		$x_text_in_image = abs($half_image_x) - $half_text_x;
		$y_text_in_image = abs($half_image_y) - $half_text_y;
//
		$x = $x_text_in_image;
		$y = $y_text_in_image;

		$this->setXOrdinate($x);
		$this->setYOrdinate($y);


		$textdebug = "Tamaño Imagen x: ".imagesx($img)."\nTamaño Imagen y: ".imagesy($img)."\nMitad Img x: ".$half_image_x."\nMitad Img y: ".$half_image_y."\nMitad txt x: ".$half_text_x."\nMitad txt y: ".$half_text_y."\nX txt en img: ".$x_text_in_image."\nY txt en img: ".$y_text_in_image."\nCoordenadas Texto: ".print_r($bbox,true);

		$this->addDebugText($img, $textdebug);
	}

}
