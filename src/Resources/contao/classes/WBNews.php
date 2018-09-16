<?php
/**
 * WBGym
 * 
 * Copyright (C) 2016 Webteam Weinberg-Gymnasium Kleinmachnow
 * 
 * @package   	WGBym
 * @author     	Johannes Cram <craj.me@gmail.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */
namespace WBGym;

class WBNews extends \System {
	
	protected static $arrTaggedNews = array();
	protected static $arrTaggedNewsLoaded = array();
	
	protected static $arrActiveTag = array();
	protected static $intCounter = 1;
		
	/* 
	* Set and return selected Tag for Tag-Nav
	*/
	public static function setActiveElem($arr){
		static::$arrActiveTag = $arr;
		return true;
	}
	
	public static function activeElem(){
		if(isset(static::$arrActiveTag)) return static::$arrActiveTag;
		return false;
	}

}
 
?>