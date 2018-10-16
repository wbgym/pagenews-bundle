# WBGym Custom News Bundle

Extension for the [codefog/contao-news_categories](https://github.com/codefog/contao-news_categories) bundle.

With this extension, you can show the latest news from a specific topic on a page that shows information on that topic.  
Additionally, there are some more useful news features. The extension uses the category system of the `codefog\contao-news_categories` bundle to categorize the news.

## Features

- Set a maximum age for news in a newslist. Elements that are older than the maximum age are not shown.
- Automatically generate a teaser if no teaser is set.
- Mark "current" category in categories menu.

## Usage (example)

- Create a newslist module and set maximum age (if needed).
- Insert a content element "news-module-filter" (from the codefog bundle) and choose the newly created newslist module
- Set the "standard filter", consisting of one category, and activate it.
- *Important:* Set the Category target page in the content element, even if it is already set in the module. The setting is not inherited for some reason.

## New Template vars

- newslist template:
    - `tagTitle` - the title of the current "standard-filter" category
    - `tagAlias` - the alias of the current "standard-filter" category
- news template:
    - `cutTeaser` - a cut-of one-line teaser with max. 200 chars
    - the standard `teaser` contains a generated "beautiful" teaser if no custom teaser is set in the news record
- category navigation template (level 1):
    - `activeItem` contains the object of the currently active filter category, if set in the URL


## Note

The project is still WIP.