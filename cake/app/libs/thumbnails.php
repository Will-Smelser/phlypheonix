<?php

class thumbnails{
	public $errs = array();
	
	public function getThumbOnTheFly($absPath){
		$fileInfo = pathinfo($absPath);
		switch(strtolower($fileInfo['extension'])) {
			case "gif":
				header('Content-Type: image/gif');
				$output = imagecreatefromgif($editDirectory.$imageName);
				imagegif($output, "", 100);
				break;
			case "png":
				header('Content-Type: image/png');
				$output = imagecreatefrompng($editDirectory.$imageName);
				imagepng($output);
				break;
			case "jpg":
			case "jpeg":
			default:
				header('Content-Type: image/jpeg');
				$output = imagecreatefromjpeg($editDirectory.$imageName);
				imagejpeg($output, "", 100);
				break;
		}	
	}
	/**
	 * Make a thumbnail
	 * @param $absPath String The absolute path and filename of image
	 * @param $relPath string The relative path and filename of the image
	 * @param $absThumbDir string The absolute path to the thumbnail directory
	 * @param $relThumbDir string the relative path to the thumbnail directory
	 * @param $maxThumbDim int The max dimension to set thumbnail to
	 * @param $pfix string The prefix to give thumbnails
	 * @return array An array of information needed to creating thumbnail links
	 */
	public function createThumb($absPath, $relPath, $absThumbDir, $relThumbDir, $maxThumbDim, $noPrevAvailAbsPath, $pfix = 'T_'){
		
		$finfo = pathinfo($absPath);
		
		$error = false;
		
		//get file attributes
		$file = $absPath;
		list($aWidth, $aHeight, $type, $attr) = @getimagesize($file);

		//calculate new sizes
		$maxdim = (max($aWidth,$aHeight) > 0) ? max($aWidth,$aHeight) : 100;
		//echo $maxdim."\n";
		$factor = $maxThumbDim / $maxdim;
		$tWidth = floor($factor * $aWidth);
		$tHeight = floor($factor * $aHeight);

		//create thumb
		$thumb = @imagecreatetruecolor($tWidth, $tHeight);
		$thumbFile = $absThumbDir.'/'.$pfix.$finfo['basename'];
		
		$relfile = $relPath;
		$relthum = $relThumbDir.'/'.$pfix.$finfo['basename'];
		
		//make sure the image will not eat too much memory
		$notTooBig = true;
		$dim = $aWidth * $aHeight;
		if($dim > 1000000 && strtolower($finfo['extension']) == 'png'){
			$notTooBig = false;
			$error = true;
		}
		
		//check that the file age is ok
		$validAge = false;//$this->checkValidAge($absPath);
		
		//becuase there are lots of issues that can arrise here, use try
		try{
			if(!file_exists($thumbFile) && !$validAge && $notTooBig){
				switch(strtolower($finfo['extension'])){
					case 'jpeg':
					case 'jpg':
						$source = @imagecreatefromjpeg($file);
						$copy = @imagecopyresized($thumb, $source, 0, 0, 0, 0, $tWidth, $tHeight, $aWidth, $aHeight);
						$save = @imagejpeg($thumb,$thumbFile);
						break;
					case 'gif':
						$source = @imagecreatefromgif($file);
						$copy = @imagecopyresized($thumb, $source, 0, 0, 0, 0, $tWidth, $tHeight, $aWidth, $aHeight);
						$save = @imagepng($thumb,$thumbFile);
						break;
					case 'png':
						$source = @imagecreatefrompng($file);
						$copy = @imagecopyresized($thumb, $source, 0, 0, 0, 0, $tWidth, $tHeight, $aWidth, $aHeight);
						$save = @imagepng($thumb,$thumbFile);
						break;
				}
				
				if(!$source || !$copy || !$save){
					$this->addError('Failed to create thumbnail: '.$relthum);
					$error = true;
				}
			}
		}
		catch( Exception $e ){
			$this->addError($e);
			$error = true;
		}

		//cleanup for memory
		unset($source,$copy,$save,$thumbFiles);
		
		if($error){
			$relthum = $noPrevAvailAbsPath;
			return array(
				'file'=>$file,
				'fileRel'=>$relfile, 
				'thumb'=>$relthum, 
				'relthumb'=>$relthum, 
				'twidth'=>32,
				'theight'=>32,
				'awidth'=>$aWidth,
				'aheight'=>$aHeight
			);
		}else{
			return array(
				'file'=>$file,
				'fileRel'=>$relfile, 
				'thumb'=>$thumbFile, 
				'relthumb'=>$relthum, 
				'twidth'=>$tWidth,
				'theight'=>$tHeight,
				'awidth'=>$aWidth,
				'aheight'=>$aHeight
			);
		}

	}
	public function addError($err){
		array_push($this->errs,$msg);
	}
}
?>