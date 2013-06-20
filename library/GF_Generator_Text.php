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

    public function setFontColor($im, $color)
    {
        if($color == 'white')
        {
            $this->font_color = imagecolorallocate($im, 255, 255, 255);
        }

        if($color == 'black')
        {
            $this->font_color = imagecolorallocate($im, 0, 0, 0);
        }
    }

    public function getFontColor()
    {
        return $this->font_color;
    }

	public function addTextToGivenImage($im, $color)
	{
        $this->setFontColor($im, $color);
		//$this->font_color = imagecolorallocate($im, 0, 0, 0);
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
		imagettftext($im, $this->font_size, $this->getAngle(), $this->getXOrdinate(), $this->getYOrdinate(), $this->getFontColor(), $this->font, $this->getText());
	}

	protected function createBoundingBox()
	{
		$this->setBBox(imagettfbbox($this->font_size, $this->getAngle(), $this->font, $this->getText()));
	}

	public function addDebugText($im, $text)
	{
		if($this->debug)
		{
			imagettftext($im, 9, 0, 2, 23, imagecolorallocate($im, 0, 0, 0), $this->font, $text);
		}
	}

	public function setCoordinatesForCenteredText($img)
	{
		$this->createBoundingBox();

		$bbox = $this->getBBox();

        $the_box = $this->calculateTextBox();

        $half_image_x = imagesx($img) / 2;
		$half_image_y = imagesy($img) / 2;

        $half_text_y = $the_box["middle_height"];
        $half_text_x = $the_box["middle_width"];

        $x = abs($half_image_x) - $half_text_x;
        $y = abs($half_image_y) + $half_text_y;

		$this->setXOrdinate($x);
		$this->setYOrdinate($y);


		$textdebug = "Tamaño Imagen x: ".imagesx($img)."\nTamaño Imagen y: ".imagesy($img)."\nMitad Img x: ".$half_image_x."\nMitad Img y: ".$half_image_y."\nMitad txt x: ".$half_text_x."\nMitad txt y: ".$half_text_y."\nX txt en img: ".$x_text_in_image."\nY txt en img: ".$y_text_in_image."\nCoordenadas Texto: ".print_r($bbox,true)."\n the box: ".print_r($the_box,true);

		$this->addDebugText($img, $textdebug);
	}


    function calculateTextBox()
    {
        /************
        simple function that calculates the *exact* bounding box (single pixel precision).
        The function returns an associative array with these keys:
        left, top:  coordinates you will pass to imagettftext
        width, height: dimension of the image you have to create
         *************/
        $rect = $this->getBBox();
        $minX = min(array($rect[0],$rect[2],$rect[4],$rect[6]));
        $maxX = max(array($rect[0],$rect[2],$rect[4],$rect[6]));
        $minY = min(array($rect[1],$rect[3],$rect[5],$rect[7]));
        $maxY = max(array($rect[1],$rect[3],$rect[5],$rect[7]));

        return array(
            "left"   => abs($minX) - 1,
            "top"    => abs($minY) - 1,
            "width"  => $maxX - $minX,
            "height" => $maxY - $minY,
            "middle_width_bbox" => ($maxX - $minX)/2,
            "middle_height_bbox" => ($maxY - $minY)/2,
            "middle_width" => abs($minX) + ($maxX - $minX)/2,
            "middle_height" => abs($minY) - ($maxY - $minY)/2
        );
    }
}
