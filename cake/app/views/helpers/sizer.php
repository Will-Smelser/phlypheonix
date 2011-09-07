<?php
class SizerHelper extends AppHelper {
	/**
	 * Force an image to meet minimum sizes
	 * 
	 * @param string $absImg
	 * @param int $destX
	 * @param int $destY
	 * @param int $srcX
	 * @param int $srcY
	 * 
	 * @requires Image must exist and be readable
	 */
	public function resizeCrop($absImg, $destX, $destY, $srcX=0, $srcY=0) {
		//get initial sizes
		if ($srcX == 0 || $srcY == 0) {
			list($srcX, $srcY) = getimagesize($absImg);
		}
		
		//determine which was is more proportionaly significant
		$factor = max(($destX/$srcX),($destY/$srcY));
		
		return array(floor($factor*$srcX),floor($factor*$srcY));
	}
	/**
	 * Constrain an image to a given size
	 * 
	 * @param string $absImg
	 * @param int $destX
	 * @param int $destY
	 * @param int $srcX
	 * @param int $srcY
	 * 
	 * @requires Image must exist and be readable
	 */
	public function resizeConstrain($absImg, $destX, $destY, $srcX=0, $srcY=0) {
		//get initial sizes
		if ($srcX == 0 || $srcY == 0) {
			list($srcX, $srcY) = getimagesize($absImg);
		}
		
		//determine which was is more proportionaly significant
		$factor = min(($destX/$srcX),($destY/$srcY));
		
		return array(floor($factor*$srcX),floor($factor*$srcY));
	}
	
	/**
	 * Resize image to match destination X
	 * 
	 * @param integer $absImg
	 * @param integer $destX
	 * @param integer $destY (optional) Ignored but
	 * @param integer $srcX (optional) source image X in pixels
	 * @param integer $srcY (optional) source image Y in pixels
	 */
	public function resizeConstrainX($absImg, $destX, $destY, $srcX=0, $srcY=0) {
		if ($srcX == 0 || $srcY == 0) {
			list($srcX, $srcY) = getimagesize($absImg);
		}
		$destY = floor(($destX / $srcX) * $srcY);
		
		return array($destX, $destY);
	}
	
	public function resizeConstrainY($absImg, $destX, $destY, $srcX=0, $srcY=0){
		if ($srcX == 0 || $srcY == 0) {
			list($srcX, $srcY) = getimagesize($absImg);
		}
		$destX = floor(($destY / $srcY) * $srcX);
		
		return array($destX, $destY);
	}

}