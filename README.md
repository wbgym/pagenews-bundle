# WBGym Custom News Bundle

Extension for the [codefog/contao-news_categories](https://github.com/codefog/contao-news_categories) bundle.

With this extension, you can show the latest news from a specific topic on a page that shows information on that topic.  
Additionally, there are some more useful news features. The extension uses the category system of the `codefog\contao-news_categories` bundle to categorize the news.

## Features:

- Set a maximum age for news in a newslist. Elements that are older than the maximum age are not shown.
- Automatically generate a teaser if no teaser is set.
- Mark "current" category in categories menu.

## Usage:

- Create a newslist module and set maximum age.
- Insert a content element "news-module-filter" (from the codefog bundle) and choose the newslist module
- Set a "standard filter", consisting of one tag.
- Adjust the templates:
   - new fields in newslist template:
      - `tagTitle` - the title of the current "standard-filter" category
      - `tagAlias` - the alias of the current "standard-filter" category
   - new fields in the news template:
      - `wbTeaser` - a cut-of one-line teaser with max. 200 chars


## Note

The project is still in active development.