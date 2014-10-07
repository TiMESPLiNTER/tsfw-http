<?php

namespace timesplinter\tsfw\http;

/**
 * @author Pascal Muenst <dev@timesplinter.ch>
 * @copyright Copyright (c) 2014, TiMESPLiNTER Webdevelopment
 */
class File
{
	/** There is no error, the file uploaded with success.  */
	const ERROR_NONE = UPLOAD_ERR_OK;
	/** The uploaded file exceeds the upload_max_filesize directive in php.ini.  */
	const ERROR_INI_SIZE = UPLOAD_ERR_INI_SIZE;
	/** The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.  */
	const ERROR_FORM_SIZE = UPLOAD_ERR_FORM_SIZE;
	/** The uploaded file was only partially uploaded. */
	const ERROR_PARTIAL = UPLOAD_ERR_PARTIAL;
	/** No file was uploaded.  */
	const ERROR_NO_FILE = UPLOAD_ERR_NO_FILE;
	/** Missing a temporary folder. Introduced in PHP 5.0.3. */
	const ERROR_NO_TMP_DIR = UPLOAD_ERR_NO_TMP_DIR;
	/** Failed to write file to disk. Introduced in PHP 5.1.0. */
	const ERROR_CANT_WRITE = UPLOAD_ERR_CANT_WRITE;
	/** 
	 * A PHP extension stopped the file upload. PHP does not provide a way to ascertain which extension caused 
	 * the file upload to stop; examining the list of loaded extensions with phpinfo() may help. 
	 * Introduced in PHP 5.2.0. 
	 */
	const ERROR_EXTENSION = UPLOAD_ERR_EXTENSION;
	
	protected $name;
	protected $type;
	protected $size;
	protected $tmpName;
	protected $error;

	/**
	 * Create a file instance from a file info array ($_FILES)
	 * 
	 * @param array $fileInfo
	 *
	 * @return File The created file
	 */
	public static function createFromArray(array $fileInfo)
	{
		$file = new File();
		
		$file->setName(isset($fileInfo['name'])?$fileInfo['name']:null);
		$file->setSize(isset($fileInfo['size'])?$fileInfo['size']:0);
		$file->setType(isset($fileInfo['type'])?$fileInfo['type']:null);
		$file->setTmpName(isset($fileInfo['tmp_name'])?$fileInfo['tmp_name']:null);
		$file->setError(isset($fileInfo['error'])?$fileInfo['error']:0);
		
		return $file;
	}
	
	/**
	 * @return int
	 */
	public function getError()
	{
		return $this->error;
	}

	/**
	 * Get upload status code
	 * @param int $error
	 */
	public function setError($error)
	{
		$this->error = $error;
	}

	/**
	 * Get original file name
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * Set original file name
	 * @param string $name
	 */
	public function setName($name)
	{
		$this->name = $name;
	}

	/**
	 * Get file size
	 * @return int
	 */
	public function getSize() {
		return $this->size;
	}

	/**
	 * Set file size
	 * @param int $size
	 */
	public function setSize($size)
	{
		$this->size = $size;
	}

	/**
	 * Get PHPs temp name
	 * @return string
	 */
	public function getTmpName()
	{
		return $this->tmpName;
	}

	/**
	 * Set PHPs temp name
	 * @param string $tmpName
	 */
	public function setTmpName($tmpName)
	{
		$this->tmpName = $tmpName;
	}

	/**
	 * Get the mime type of the file
	 * @return string The mime type
	 */
	public function getType()
	{
		return $this->type;
	}

	/**
	 * Set the mime type of the file
	 * @param string $type The mime type
	 */
	public function setType($type)
	{
		$this->type = $type;
	}
	
	
}

/* EOF */ 