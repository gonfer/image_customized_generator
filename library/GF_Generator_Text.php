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
			// Break it up into pieces 125 characters long
		$lines = explode('|', wordwrap($this->getText(), 115, '|'));

		$y = $this->getYOrdinate();
		// Loop through the lines and place them on the image
		foreach ($lines as $line)
		{
			imagettftext($im, $this->font_size, $this->getAngle(), $this->getXOrdinate(), $y, $this->font_color, $this->font, $line);

			// Increment Y so the next line is below the previous line
			$y += 23;
		}
	}
}