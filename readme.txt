=== Protovis Loader ===
Contributors: seancarmody
Tags: protovis, datavisualization, charts, graphics
Requires at least: 2.8.0
Tested up to: 3.0.1
Stable tag: 0.2.1

Creates a shortcode to faciliate the use of Protovis data visualization scripts in blog posts.

== Description ==

Protovis Loader is a plugin which faciliates the use of [Protovis](http://vis.stanford.edu/protovis/) scripts. Protovis is a javascript data visualisation library being developed at Stanford, which allows the creation of interactive charts on web pages.

Incorporating Javascript code into WordPress posts can be tricky as it (deliberately) sanitises text typed into posts, which interferes with Javascript. When I first began experimenting with Javascript, this cause me some difficulties, as described in this post. In the end, I decided to roll up my sleeves and write a plugin to make the whole process a lot easier. Protovis Loader was the result.

Protovis Loader makes the whole process a lot easier in two ways:

1. It ships with a copy of the Protovis javascript library and once the plugin is activated, links to the library will automatically be included in page headers.
1. It creates a shortcode called [pvis] which makes it very easy to include Protovis scripts in blog posts and pages.

You can see it in action on [the Stubborn Mule](http://www.stubbornmule.net/resources/protovis-loader/).

== Installation ==

1. Upload 'pv-loader' to the '/wp-content/plugins/' directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Use the [pvis] shortcode to add protovis code to your post (see [Screenshots](http://wordpress.org/extend/plugins/protovis-loader/screenshots/) for an example)

== Frequently Asked Questions ==

= What is the syntax of the pvis shortcode? =

Here is an example:

	[pvis src="/scripts/chart.js" img="/images/fail.png"]A caption[/pvis]


Attributes:

* src: specifies the location of the protovis script
* img: specifes the URL of an image to display instead if scripts are blocked
* alt: speficies image alternative text

Text between the tags will be set as a caption

= Can I specifiy  any CSS? =

Not yet.

= Which Protovis library does the plugin use? =

Currently version Protovis 3.2 ships with the plugin.

= Can I use a different version of Protovis? =

Not yet.

== Screenshots ==

1. Using the shortcode in [a blog post](http://www.stubbornmule.net/2010/09/protovis-for-chrome-and-safari/)
1. The end result.

== Changelog ==
= 0.3.0 =
* Tweaked CSS for caption to improve vertical alignment
* Added optional height/width dimension parameters for chart canvas
* Added optional "inline" chart type (no caption no borders)

= 0.2.1 =
* Fixed error: missing > in css div element

= 0.2.0 =
* Added CSS (fixed style at this point)
* Added BlackBerry to the list of non-SVG browsers

= 0.1.1 =
A variety of very minor tweaks, mainly adhereing to WP coding standards.

= 0.1 =
* The first release of the plugin.

== Upgrade Notice ==
= 0.3.0 =
* Enhancements: improved CSS and new inline option.

= 0.2.1 =
* Bug fix: update required for charts to display in some browsers.

== To-Do List ==

This list is not really prioritised yet.

1. Improve user-agent (browser) detection
1. Create an options page
1. Allow custom CSS files
1. Allow for alterntive specification of the protovis js library
1. Replace tags in the imported script to allow shortcode parameters to be used in the script

I'm sure there'll be a lot more!

