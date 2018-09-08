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
	* Return all News tagged with a Tag with the current page as referer page
	*
	* If $isReport is true, it returns all News tagged with report, otherwise it returns just news without the report-tag
	* If no $newsId is given ($newsId = 0), it returns all News for that referer page, otherwise it returns just a tag info about a specific news
	*/
	
	protected static function loadNews($pageId){
		if(!static::$arrTaggedNewsLoaded[$pageId]) {
			$news = \Database::getInstance()
					->prepare("
						SELECT 
							tl_news_category.id AS tag_id, tl_news_category.jumpTo, tl_news_category.title AS tag_title, tl_news_category.alias AS tag_alias, 
							tl_news_categories.news_id,
							tl_news.date, tl_news.categories AS tags
						FROM tl_news_categories
						JOIN tl_news_category ON tl_news_categories.category_id = tl_news_category.id
						JOIN tl_news ON tl_news_categories.news_id = tl_news.id
						WHERE tl_news_category.jumpTo = ?
					")->execute($pageId);
			static::$arrTaggedNewsLoaded[$pageId] = true;
			if($news->numRows != 0) {
				while($elem = $news->fetchAssoc()) {
					$elem['tags'] = unserialize($elem['tags']);
					$arrNews[] = $elem;
				}
				static::$arrTaggedNews[$pageId] = $arrNews;
			}
		}
	}
		
	/* 
	* ReportNews Queries 
	*/
	public static function getPageReportNews($pageId, $newsId = 0) {
		self::loadNews($pageId);
		
		if(static::$arrTaggedNews[$pageId]) {
		
			//Case mod_reportteaser (general query)
			if($newsId == 0) {
				$reportNews = array();
				$blnNewNews = false;
				foreach (static::$arrTaggedNews[$pageId] as $news) {
					if(in_array(static::reportTagId(), $news['tags'])) {
						$reportNews[] = $news;
						if($news['date'] >= time() - (60*60*24*7*6)) $blnNewNews = true;
					}
				}
				if(!empty($reportNews)) {
					$reportNews['new'] = $blnNewNews;
					return $reportNews;
				}
				return false;
			}
			//Case news_report (news specific query)
			if($newsId != 0) {
				foreach (static::$arrTaggedNews[$pageId] as $news) {
					if(in_array(static::reportTagId(), $news['tags']) && $news['news_id'] == $newsId && $news['date'] >= time() - (60*60*24*7*10)) $reportNews = $news;
				}
				return $reportNews;
			}
		}
		return;
	}
		
	/*
	* DefaultNews Queries 
	*/
	public static function getPageDefaultNews($pageId, $newsId = 0) {
		self::loadNews($pageId);
		
		if(static::$arrTaggedNews[$pageId]) {
			//Case mod_newsteaser (general query)
			if($newsId == 0) {
				foreach (static::$arrTaggedNews[$pageId] as $news) {																//10 Wochen Anzeigedauer
					if(!in_array(static::reportTagId(), $news['tags']) && $news['date'] >= time() - (60*60*24*7*10)) $selectedNews[] = $news;
				}
				return $selectedNews;
			}
			//Case news_teaser (news specific query)
			if($newsId != 0) {
				foreach (static::$arrTaggedNews[$pageId] as $news) {
					if($news['news_id'] == $newsId && !in_array(static::reportTagId(), $news['tags']) && $news['date'] >= time() - (60*60*24*7*10) && static::$intCounter <= 2) {
						$selectedNews = $news;
						static::$intCounter++;
					}
				}
				return $selectedNews;
			}
			return static::$arrTaggedNews[$pageId];
		}
		return;
	}

		
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

	/**
	 * CONTAO HOOK
	 * Send the wb_tagNewsPage to the news template
	 * 
	 * @param $objTemplate The frontend template
	 * @param $arrRow The news database row
	 * @param $objModule The news module object
	 * @return void
	 */
	public function parseTaggedArticles($objTemplate, $arrRow, $objModule) {
		$objTemplate->tagNewsPage = $objModule->wb_tagNewsPage;
	}

	/**
	 * Get the "Student report" Tag ID from the database.
	 * 
	 * @return integer 
	 */
	public static function reportTagId() {
		$arrRes = \Database::getInstance()->query("SELECT id FROM tl_news_category WHERE wb_isReportTag = '1' LIMIT 1")->fetchRow();
		return $arrRes[0];
		//return $GLOBALS['TL_CONFIG']['reportNewsTagId'];
	}
}
 
?>