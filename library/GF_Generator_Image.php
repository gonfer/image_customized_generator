<?php
/**
 * Author: Ing. Gonzalo Federico Fernández
 * User: gonza
 * Date: 6/12/13
 * Time: 2:52 PM
 * File: GF_Generator_Image.php
 */

class GF_Generator_Image
{
	public $imagewidth = 400;
	public $imageheight = 150;
	protected $img;

	public function __construct()
	{

	}

	public function createBackgroundFromImage($path)
	{
		$file_name = basename($path);

		// Create the image
		switch (strtolower(pathinfo($file_name, PATHINFO_EXTENSION))) {
			case "jpg" :
				$im = imagecreatefromjpeg($path);
				break;
			case "gif" :
				$im = imagecreatefromgif($path);
				break;
			case "png" :
				$im = imagecreatefrompng($path);
				break;

			default :
				trigger_error("Error Bad Extention");
				exit();
				break;
		}

		$this->img = $im;
	}

	public function createBackgroundFromUrlImage($url)
	{
		$size = getimagesize($url);

		switch($size["mime"]){
			case "image/jpeg":
				$im = imagecreatefromjpeg($url);
				break;
			case "image/gif":
				$im = imagecreatefromgif($url);
				break;
			case "image/png":
				$im = imagecreatefrompng($url);
				break;
			default:
				$im=false;
				break;
		}

		$this->img = $im;

		if ($this->img === false) {
			trigger_error('Unable to open image');
			exit();
		}
	}

	// Create the image
	public function createBackgroundImage($filled = true)
	{
		$im = imagecreatetruecolor($this->imagewidth, $this->imageheight);

		// Create some colors
		$white = imagecolorallocate($im, 255, 255, 255);
		$grey = imagecolorallocate($im, 128, 128, 128);
		$black = imagecolorallocate($im, 0, 0, 0);

		if($filled){
			$this->createRectangleForText($white);
		}

		$this->img = $im;
	}

	//todo: send other colors
	protected function createRectangleForText($color)
	{
		imagefilledrectangle($this->img, 0, 0, $this->imagewidth, $this->imageheight, $color);
		$this->img = $im;
	}

	public function getImg()
	{
		return $this->img;
	}

	public function renderImage()
	{
		// Set the content-type
		header('Content-Type: image/png');

		// Using imagepng() results in clearer text compared with imagejpeg()
		imagepng($this->img);
		imagedestroy($this->img);
	}

	public function renderCachedImage()
	{
		session_start();

		$offset = 60 * 60 * 24 * 14; //14 Days

		if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE'])) {
			// send the last mod time of the file back
			header("Last-Modified: " . gmdate("D, d M Y H:i:s", time() - $offset) . " GMT",true, 304);
			exit;
		}else{

			$ExpStr = "Expires: " . gmdate("D, d M Y H:i:s", time() + $offset) . " GMT";
			header($ExpStr); //Set a far future expire date. This keeps the image locally cached by the user for less hits to the server.
			header('Cache-Control:	max-age=120');
			header("Last-Modified: " . gmdate("D, d M Y H:i:s", time() - $offset) . " GMT");

			header('Content-Type: image/png');

			// Using imagepng() results in clearer text compared with imagejpeg()
			imagepng($this->img);
			imagedestroy($this->img);
		}

	}
}
?>
