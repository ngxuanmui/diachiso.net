<?php

//require thumb lib
require_once JPATH_ROOT . DS . 'jelibs/phpthumb/ThumbLib.inc.php';

class JEUtil 
{
	function getRandomString($length = 7) 
	{
	    $validCharacters = "abcdefghijkmnpqrstuxyvwzABCDEFGHIJKLMNPQRSTUXYVWZ23456789";
	    $validCharNumber = strlen($validCharacters);
	 
	    $result = "";
	 
	    for ($i = 0; $i < $length; $i++) 
	    {
	        $index = mt_rand(0, $validCharNumber - 1);
	        $result .= $validCharacters[$index];
	    }
	 
	    return $result;
	}
	
	public static function convertAlias( $str )
	{
		$str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $str);
		$str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
		$str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
		$str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
		$str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
		$str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
		$str = preg_replace("/(đ)/", 'd', $str);
	
		$str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $str);
		$str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);
		$str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);
		$str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $str);
		$str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $str);
		$str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $str);
		$str = preg_replace("/(Đ)/", 'D', $str);
	
		$str = str_replace(
				array('"', "'", '#', '!', '@', '$', '%', '^', '&', '*'),
				'',
				$str
		);
	
		return $str;
	}
	
	public function resizeImage($file, $thumbFile, $thumbW = null, $thumbH = null, $crop = true)
	{ 
		if(!$thumbW) $thumbW = 220;
		if(!$thumbH) $thumbH = 60;
		
		if(!file_exists( $thumbFile ) && is_file($file))
		{
			//make thumb
			$thumb =  PhpThumbFactory::create($file);
			$thumb -> resize($thumbW);
			
			if($crop)
				$thumb->crop(0, 0, $thumbW, $thumbH);
				
			$thumb -> save($thumbFile);
		}
	}
	
	static public function is_serialized($data)
	{ 
	    if (trim($data) == "") 
	        return false;
	    
	    if (preg_match("/^(i|s|a|o|d)(.*);/si",$data))
	        return true;
	    
	    return false; 
	}
	
	static public function thumb($images, $pathUpload, $pathThumb, $thumbW, $thumbH = null, $crop = true)
	{
		//get array of image
		$images = unserialize($images);
		$thumbFile = array();
		
		$path = '';
		
		foreach ($images as $img)
		{
			$newPathThumb = null;
			//explode image by path seperate
			$tmp = explode('/', $img);
			
			//remove last element in array
			$imgFile = array_pop($tmp);

			//re-build path
			$path = implode('/', $tmp);
			
			$newPathThumb = $pathThumb . $path;
			
			$thumbFile[] = $path . '/thumbnail-' . $imgFile;
			
			//make dir if not exist
			if(!is_dir($newPathThumb))
				mkdir($newPathThumb, 0777, true);
			
			$createThumbFile = $newPathThumb . '/thumbnail-' . $imgFile;
			
			//make thumb
			$file = $pathUpload . $img;
						
			if(!file_exists( $createThumbFile ) && is_file($file))
			{
				$thumb =  PhpThumbFactory::create($file);
				$thumb -> resize($thumbW);
				
				if($crop)
				{
					$thumb->crop(0, 0, $thumbW, $thumbH);
				}
					
				$thumb -> save($createThumbFile);
			}
			
			
		}
		
		return $thumbFile;
	}
	
	public static function loadModule($pos, $class = '')
	{
		$modules = JModuleHelper::getModules($pos);
	
		foreach($modules as $module)
		{
			if ($module->showtitle)
			{
				echo '<div class="module-title '.$class.'">' . $module->title . '</div>';
			}
				
			echo JModuleHelper::renderModule($module);
		}
	}
	
	public static function renderModulesOnPosition($position, $tmpParams = array()) {
	
		jimport('joomla.application.module.helper');
		$modules = JModuleHelper::getModules($position);
	
		return self::renderModules($modules, $tmpParams);
	}
	
	public static function renderModules($modules, $tmpParams = array()) {
		jimport('joomla.application.module.helper');
		$html = '';
		if ($modules && count($modules)) {
			foreach ($modules as $mod) {
				$html .= self::renderModule($mod, $tmpParams);
			}
		}
		return $html;
	}
	
	public static function renderModule($module, $tmpParams = array())
	{
		jimport('joomla.application.module.helper');
	
		if (is_object($module) && $module->id) {
				
			$tempP = json_decode($module->params, true);
				
			if (is_array($tempP))
				$tempR = array_merge($tempP, $tmpParams);
			else
				$tempR = $tmpParams;
				
			$module->params = json_encode($tempR);
				
			$html[] = '<div class="widget-blocks widget-block">';
			$html[] = '	<div class="content">';
				
			if ($module->title && $module->showtitle == 1) {
				$html[] = '<h3>'.$module->title.'</h3>';
			}
			$html[] = JModuleHelper::renderModule($module);
			$html[] = '	</div>';
			$html[] = '</div>';
				
			return implode($html);
		}
	
		return '';
	}
}