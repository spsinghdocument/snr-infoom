<?php
class ImageHelper extends AppHelper{
	var $helpers = array('Html');

	public function resize($path, $width, $height, $attributes = array()){
		$cacheDir = 'image_cache/';
		$continue = 'true';

		//Check for image_cache Dir, if not present create it
		$cacheDirPath = '../webroot/img/'.$cacheDir;
		if(!is_dir($cacheDirPath)){
			mkdir($cacheDirPath);
			chmod($cacheDirPath, 0777);
		}

		//check for original file present or not
		$originalFilePath = '../webroot/img/'.$path;
		if(!file_exists($originalFilePath)){
			echo 'File Not Found on Specified Path =>'.$path;
			$continue = 'false';
		}

		if($continue == 'true'){
			$newFileName = $width.'x'.$height.'_'.basename($path);

			//Check Whether this new image is present in cache Dir or not
			$cachedImagePath = $cacheDirPath.'/'.$newFileName;

			if(!file_exists($cachedImagePath)){//save image with new dimension start
				$imageData = getimagesize($originalFilePath);
				$imgType = $imageData['mime'];
				
				if($imgType == 'image/jpeg' || $imgType == 'image/pjpeg'){
					$image_source = imagecreatefromjpeg($originalFilePath);
					$img_type = 'jpg';
				}

				if($imgType == 'image/gif'){
					$image_source = imagecreatefromjpeg($originalFilePath);
					$img_type = 'gif';
				}

				if($imgType == 'image/bmp' || $imgType == 'image/x-windows-bmp'){
					$image_source = imagecreatefromwbmp($originalFilePath);
					$img_type = 'bmp';
				}

				if($imgType == 'image/x-png' || $imgType == 'image/png'){
					$image_source = imagecreatefrompng($originalFilePath);
					$img_type = 'png';
				}
				
				if($img_type != 'png'){
					$remote_file = $cachedImagePath;

					imagejpeg($image_source,$remote_file,100);
					chmod($remote_file,0644);

					// get width and height of original image
					list($image_width, $image_height) = getimagesize($remote_file);

					$new_image = imagecreatetruecolor($width , $height);
					$image_source = imagecreatefromjpeg($remote_file);

					imagecopyresampled($new_image, $image_source, 0, 0, 0, 0, $width, $height, $image_width, $image_height);
					imagejpeg($new_image,$remote_file,100);
				}else{
					$remote_file = $cachedImagePath;

					$imgInfo = getimagesize($originalFilePath);
					switch ($imgInfo[2]){
						case 1: $image_source = imagecreatefromgif($originalFilePath); break;
						case 3: $image_source = imagecreatefrompng($originalFilePath); break;
					}

					$new_image = imagecreatetruecolor($width, $height);
					/* Check if this image is PNG or GIF, then set if Transparent*/  
					if(($imgInfo[2] == 1) OR ($imgInfo[2]==3)){
						imagealphablending($new_image, false);
						imagesavealpha($new_image,true);
						$transparent = imagecolorallocatealpha($new_image, 255, 255, 255, 127);
						imagefilledrectangle($new_image, 0, 0, $width, $height, $transparent);
					}
					imagecopyresampled($new_image, $image_source, 0, 0, 0, 0, $width, $height, $imgInfo[0], $imgInfo[1]);

					//Generate the file, and rename it to $newfilename
					switch($imgInfo[2]){
						case 1: imagegif($new_image, $remote_file); break;
						case 3: imagepng($new_image, $remote_file); break;
					}
				}
				imagedestroy($new_image);
				imagedestroy($image_source);
			} //save image with new dimension end

			//return the image
			$link = $this->Html->image($cacheDir.$newFileName, $attributes);
			return $link;
		}
	}
}
?>