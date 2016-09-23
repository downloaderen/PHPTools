<?php

abstract class File
{
	protected $filename;
	public $image;
	public $imageFolder;
	public $mime = [
		'image/png',
		'image/jpeg',
		'image/jpg',
		'image/gif'
	];
}

class FileHandler extends File
{
	protected $options;
	protected $allFiles;

	public function __construct($options)
	{
		$this->options = $options;
		$this->imageFolder = $this->checkKey('folder') != false ? $this->checkKey('folder') : $this->mime;
		$this->filename = $this->checkKey('imageName') != false ? $this->checkKey('imageName') : $this->mime;
		$this->mime = $this->checkKey('mimeType') != false ? $this->checkKey('mimeType') : $this->mime;
	}

	public function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' kB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }

        return $bytes;
	}

	public function getFiles()
	{
		$this->allFiles = [];
		$finfo = finfo_open(FILEINFO_MIME_TYPE);
		if(substr($this->imageFolder, -1) != '/'){
			$this->imageFolder = $this->imageFolder . '/';
		}
		if (file_exists($this->imageFolder)) {
			foreach(scandir($this->imageFolder) as $file){
				$path = $this->imageFolder . $file;
				$mime = finfo_file($finfo, $path);
				if(in_array($mime, $this->mime)){
					$tempArr['src'] = $path;
					if(file_exists($this->imageFolder . 'thumb/' . $file))
					{
						$tempArr['thumb'] = $this->imageFolder . 'thumb/' . $file;
						$tempArr['thumbSize'] = $this->formatSizeUnits(filesize($this->imageFolder . 'thumb/' . $file));
					}
					$tempArr['srcSize'] = $this->formatSizeUnits(filesize($path));
					$tempArr['fileTime'] = fileatime($path);
				    array_push($this->allFiles, $tempArr);
				}
			}
		}
		finfo_close($finfo);
		return $this->allFiles;
	}

	private function checkKey($key)
	{
		if(array_key_exists($key, $this->options))
		{
			return $this->options[$key];
		}
		return false;
	}
}

class FileUploader extends File
{
	public $height;
	public $width;
	public $mode = 'outside';

	protected $errors = [];
	protected $success = [];
	protected $currentImage;
	protected $thumb = 'thumb';

	public function __construct($fileUploadInputName, $imageFolder, $height, $width, $mode = null, $mime = null)
	{
		$this->image = $fileUploadInputName;
		$this->imageFolder = $imageFolder;
		$this->height = $height;
		$this->width = $width;
		if($mode != null){
			$this->mode = $mode;
		}
		if($mime != null){
			$this->mime = $mime;
		}
	}

	private function setCurrentImage($i = -1)
	{
		if($i != -1){
			$this->currentImage = array(
				'name' => $this->image['name'][$i],
				'type' => $this->image['type'][$i],
				'tmp_name' => $this->image['tmp_name'][$i],
				'error' => $this->image['error'][$i],
				'size' => $this->image['size'][$i]
			);
		} else {
			$this->currentImage = $this->image;
		}
	}

	private function getThumb(){
		return $this->imageFolder . '/' . $this->thumb . '/';
	}

	private function setFilename($i = -1)
	{
		$this->filename = uniqid() . '_' .$this->currentImage['name'];
	}

	private function checkFileExists($i = -1)
	{
		if($this->currentImage['error'] == 4){
			array_push($this->errors, [3 => 1]);
			return false;
		}
		return true;
	}

	private function checkMimeType($i = -1)
	{
		if(!in_array($this->currentImage['type'], $this->mime)){
			if(!array_key_exists($this->currentImage['name'], $this->errors)){
				$this->errors[$this->currentImage['name']] = [1];
				return false;
			}
			return false;
		}
		return true;
	}

	private function createFolder($folder)
	{
		$folder = $folder . '/';
		if (!file_exists($folder)) {
		    mkdir($folder, 0777, true);
		    return true;
		}
		if(file_exists($folder)) {
			return true;
		}
		return false;
	}

	private function moveUploadedFile($i = -1)
	{
		if (move_uploaded_file($this->currentImage['tmp_name'], $this->imageFolder . '/' . $this->filename)) {
			WideImage::load($this->imageFolder . '/' . $this->filename)->resize($this->width, $this->height, $this->mode)->crop('center', 'center', $this->width, $this->height)->saveToFile($this->getThumb() . $this->filename);
        	array_push($this->success, [1 => $this->filename]);
	    } else {
	    	array_push($this->errors, [2 => $this->currentImage['name']]);
	    }
	}

	private function single()
	{
		if($this->checkFileExists()){
			$this->setCurrentImage();
			if($this->checkMimeType() && $this->createFolder($this->imageFolder) && $this->createFolder($this->getThumb())){
				$this->setFilename();
				if($this->moveUploadedFile()){
					return [$this->success, $this->errors];
				}
			}
		}
		return ['success' => $this->success, 'errors' => $this->errors];
	}

	private function multi()
	{
		if($this->checkFileExists()){
			for ($i = 0; $i < sizeof($this->image['name']); $i++) {
				$this->setCurrentImage($i);
				if($this->checkMimeType($i) && $this->createFolder($this->imageFolder) && $this->createFolder($this->getThumb())){
					$this->setFilename($i);
					if($this->moveUploadedFile($i)){
						return [$this->success, $this->errors];
					}
				}
			}
		}
		return ['success' => $this->success, 'errors' => $this->errors];
	}

	public function init()
	{
		$this->image = $_FILES[$this->image];
		if(is_array($this->image['name'])){
			return $this->multi();
		}
		return $this->single();
	}
}