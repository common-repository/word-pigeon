=== Word Pigeon ===
Contributors: maxymus
Tags: wordpress, google docs, export
Requires at least: 5.2
Tested up to: 5.4.2
Stable tag: trunk
Requires PHP: 7.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

== Description ==

Love Google Docs But Hate The Time It Takes To Add Your Posts to WordPress?
Word Pigeon is Your One Click Solution

Instead of copying and pasting from Google Docs to WordPress and losing your images and formatting in the process, 
Word Pigeon makes it easy to compose your posts in Google Docs and publish to WordPress with your images, links and 
formatting intact. In a single click.

No coding. No changes to your WordPress theme. No crazy code to break your site. Just massively increased 
productivity and HOURS saved.


== Installation ==

This plugin is supplementary to our application at https://web.wordpigeon.com 

There is a video explaining how to set it up here https://www.youtube.com/watch?v=Y-OwqBFltak&list=PLNiK1Hr0YrdTc3hFkOXeiMBFnhQh7jPMx&index=4&t=0s

1. Login to https://web.wordpigeon.com  with your google account and add connect your WordPress site (instructions available on site)
1. Paste the public key provided by https://web.wordpigeon.com  into the wordPigeon options in WordPress
1. Click the finish button back in the application at (https://web.wordpigeon.com)

Now your WordPress site is connected to our application and you will be able to export your google documents to it

== How to Export ==

1. Add your WordPress site in the web application at https://web.wordpigeon.com, a google drive folder will be created in your google drive.
1. Add some documents in this google folder, or link another google folder to the site - any documents you put in these folders will be visible from our web applicatio
1. Export the google documents from the web application.

You have the following options when exporting: -
* either a post or a page
* either as a draft or published (if choosing a draft will not be visible to the web, it will only be visible to you if you're logged into WordPress)

== Support ==

If you need support you can email max@wordpigeon.com

== Frequently Asked Questions ==

= It says I have entered the wrong public key from the web application =

Since there is a public key for each WordPress site you enter, you have to make sure you get the correct key for the correct site. Goto 
https://web.wordpigeon.com, where you will be able to get the correct public key and try pasting it in again.

== Screenshots ==

1. A list of your google documents ready to be exported!
2. A document about to be exported, some options have been selected!
3. A document about to be exported, a list of the options available!

== Changelog ==

= 2.22.1 =

Enhancements:

* Ensured that WordPigeon works with the latest version of WordPress v5.4.2 (released on June 10th, 2020)

Bugfixes:

* Fixed issue where featured image was not being set properly

= 2.22.0 =

Enhancements:

* Supports published date
* Improved error messages if image insertions fail
* Supports autocompletion for Tags from back in Word Pigeon

= 2.18.0 =

Enhancements:

* New method of exporting to the WordPress plugin 
* Support for uploading a featured image image from Word Pigeon
* Default to setting the first image as a featured image if none are selected
* Ability to set the slug from Word Pigeon
* Ability to set an excerpt from Word Pigeon

Bugfixes:

* New method of exporting fixes failed exports when the size of the document exceeded 10Mb (very large posts)

= 2.16.0 =

Enhancements:

* Plugin now supports updating an existing post if 'update' was selected from the Word Pigeon app.

Bugfixes:

* Links are now sanitized so they are longer prefixed with https://www.google.com/url? and suffixed with something like &amp;sa=D&amp;ust=1583948342023000.

= 2.13.5 =

Enhancements:

* Fixed empty paragraphs not getting stripped if they were originally bold

= 2.13.4 =

Enhancements:

* Improved stripping so that empty paragraphs coming across from Google Docs get erased e.g. <p><span>&nbsp;</span<p>
* Improved logging 

= 2.13.3 =

Enhancements

* Improved stripping option to strip more formatting to allow the article to further depend on its own WordPress theme if desired
* Improved stripping to strip out comments (formerly comments from Google Docs where being copied across also)

= 2.13.1 =

Enhancements:

* Added ability to select whether some of the styles added by google are stripped out or not in the web application
* Better support for right to left (rtl) writing systems - prevented the alignments from being inverted when using rtl mode in Google Docs
* Increased the size of the public key text box. On some devices the public key was undesirably wrapping lines

= 2.2 =

Bugfixes:

* Fixed problem where categories were not being sent to Word Pigeon unless they belonged to a post

= 2.1 =

Enhancements:

* Added support for attaching author to the export
* Added support for attaching categories to the export
* Added support for attaching tags to the export
* Added secure endpoint for returning categories and authors to the Word Pigeon web app

