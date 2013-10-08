<?php
/**
	* Component for Generating Captcha	*
	* PHP versions 5.1.4
	* @filesource
	* @author     Arvind K. 
	* @link       http://www.devarticles.in/
	* @copyright  Copyright © 2008 www.devarticles.in
	* @version 0.0.1 
	*   - Initial release
	*/
class CaptchaComponent extends Component
{

	var $font = 'calibri.ttf';
    
    public function __construct(ComponentCollection $collection, $settings = array()) {
        $this->Controller = $collection->getController();
        $this->font = APP.'Plugin'.DS.'Captcha'.DS.'webroot'.DS.'fonts'.DS.'calibri.ttf';
    }

	function generateCode($characters) {
		/* list all possible characters, similar looking characters and vowels have been removed */
		$possible = '23456789bcdfghjkmnpqrstvwxyz';
		$code = '';
		$i = 0;
		while ($i < $characters) { 
			$code .= substr($possible, mt_rand(0, strlen($possible)-1), 1);
			$i++;
		}
		return $code;
	}

	function create($width='120',$height='40',$characters='6') {
		$code = $this->generateCode($characters);
		/* font size will be 75% of the image height */
		$font_size = $height * 0.70;
		$image = @imagecreate($width, $height) or die('Cannot initialize new GD image stream');
		/* set the colours */
		$background_color = imagecolorallocate($image, 194, 216, 220);
		$text_color = imagecolorallocate($image, 10, 30, 80);
		$noise_color = imagecolorallocate($image, 182, 195, 228);
		/* generate random dots in background */
		for( $i=0; $i<($width*$height)/3; $i++ ) {
			imagefilledellipse($image, mt_rand(0,$width), mt_rand(0,$height), 1, 1, $noise_color);
		}
		/* generate random lines in background */
		for( $i=0; $i<($width*$height)/150; $i++ ) {
			imageline($image, mt_rand(0,$width), mt_rand(0,$height), mt_rand(0,$width), mt_rand(0,$height), $noise_color);
		}
		/* create textbox and add text */
		$textbox = imagettfbbox($font_size, 0, $this->font, $code) or die('Error in imagettfbbox function');
		$x = ($width - $textbox[4])/2;
		$y = ($height - $textbox[5])/2;
		$y -= 3;
		imagettftext($image, $font_size, 0, $x, $y, $text_color, $this->font , $code) or die('Error in imagettftext function');
        
		$this->Controller->Session->write('security_code',$code);
		/* output captcha image to browser */
        $this->Controller->response->type('image/jpeg');
		imagejpeg($image);
		imagedestroy($image);
	}

	function getVerCode()	{
		return $this->Controller->Session->read('security_code');
	}
    
    public function check($value){
        if($value == $this->getVerCode()){
            return true;
        }
        return false;
    } 
}
?>