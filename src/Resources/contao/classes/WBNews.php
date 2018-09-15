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
	
	/*
	* Get "Teaser Text" and "more text" by full text
	*/
	public static function generateTeaser($sText,$minLength = 200) {		
		
		//== if text is in minLength range, return complete text
		if(strlen($sText) <= $minLength) {
			return $sText;
		}
		
		//== set limit to end of first paragraph
		$pos1 = strpos($sText,'<p>');
		$pos2 = strpos($sText,'</p>')+4;
		
		if($pos1 !== false && $pos2 !== false) {
			
			//== include more paragraphs if first paragraph is shorter than minLength
			while($pos2-$pos1 < $minLength) {
				$pos2New = strpos($sText,'</p>',$pos2);
				//set new limit if new paragraph is found
				if($pos2New !== false && $pos2New > $pos2) {
					$pos2 = $pos2New;
				}
				//finish loop if no more paragraphs are found
				else {
					break;
				}
			}
		
			//== build teaser string
			$sTeaser = '';
			for ($i = $pos1; $i < $pos2; $i++) {
				$sTeaser .= $sText[$i];
			}
			return $sTeaser;
		}
		//if no paragraph is found, return complete text
		return $sText;
	}

}
 
?>