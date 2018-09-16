<?php
/**
 * WBGym
 * 
 * Copyright (C) 2018 Webteam Weinberg-Gymnasium Kleinmachnow
 * 
 * @package   	WGBym
 * @author     	Johannes Cram <johannes@jonesmedia.de>
 * @license     http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */

namespace Wbgym\PageNewsBundle;

class Teaser
{
    /**
     * Generate one-line Teaser from News markup
     * without any HTML markup (line breaks, etc.)
     * 
     * @param string    $strNews
     * @param int       $length     maximum length of chars (hard break)
     * 
     * @return string
     */
    public static function generateCutTeaser($strNews, $length = 200)
    {
        $startPos = strpos($strNews, '<p>');
        $strNews = substr($strNews, $startPos);
        $strStripped = strip_tags($strNews);
        
        return substr($strStripped, 0, $length);
    }

    /**
     * Generate teaser from full news markup.
     * 
     * @param string    $sText
     * @param int       $minLength
     * 
     * @return string
	 */
    public static function generateTeaser($sText,$minLength = 200) 
    {		
		// if text is in minLength range, return complete text
        if(strlen($sText) <= $minLength) 
        {
			return $sText;
		}
		
		// set limit to end of first paragraph
		$pos1 = strpos($sText,'<p>');
		$pos2 = strpos($sText,'</p>')+4;
		
        if($pos1 !== false && $pos2 !== false)
        {
			// include more paragraphs if first paragraph is shorter than minLength
            while($pos2-$pos1 < $minLength) 
            {
				$pos2New = strpos($sText,'</p>',$pos2);
				// set new limit if new paragraph is found
                if($pos2New !== false && $pos2New > $pos2) 
                {
					$pos2 = $pos2New;
				}
				// finish loop if no more paragraphs are found
                else 
                {
					break;
				}
			}
			// build teaser string
			$sTeaser = '';
            for ($i = $pos1; $i < $pos2; $i++) 
            {
				$sTeaser .= $sText[$i];
			}
			return $sTeaser;
        }
		// if no paragraph is found, return complete text
		return $sText;
	}
}