=== ThreeSixtyVoice ===
Contributors: steveydoteu
Donate link: http://www.stevey.eu/threesixtyvoice
Tags: 360voice, 360, xbox, blog, api, voice
Requires at least: 2.x.x
Tested up to: 2.6.2
Stable tag: 2.0

ThreeSixtyVoice is a Wordpress plugin developed from the initial ideas behind the 360Voice plugin by David Larrabee of Squidpunch.com.

== Description ==

**What is ThreeSixtyVoice?**

ThreeSixtyVoice is a Wordpress plugin developed from the initial ideas behind the [360Voice](http://www.360voice.com/ "360voice.com") plugin by David Larrabee of [Squidpunch.com](http://www.squidpunch.com "squidpunch.com"). I have rewritten large segments of the code with validation and also load times in mind. Essentially it uses the APIs from 360Voice.com to display an assortment of data in a widget, or even in your template.

There is nothing wrong with David’s plugin, it functions as required, even if it is rather messy and does not validate correctly. I am by no means trying to belittle his work, but offer an alternative.

**Features**

    * Display your badges
    * Display your blog entries
    * Display your favorites (most played)
    * Display your position in various 360V leaderboards
    * Display your 100% complete games
    * Widget enabled

All items are able to be toggled on and off, with the number of blog entries and also favorites that is displayed configurable.

== Installation ==

1. Upload `wp-threesixtyvoice.php` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Place one of the assorted php functions in your templates or use the provided widget

== Frequently Asked Questions ==

= How do I alter what the sidebar widget displays? =

Head to Settings>ThreeSixtyVoice

= What are these PHP functions you mention? =

Anywhere you are able to use PHP functions you have the ability to display parts of, or indeed the entire group of data:

*ShowVoiceData();*

For the various blocks, so you can mix them up, or place them in different areas use the following functions:
Badges:

*GetBadges();*

Blog:

*GetMostRecentBlogEntries();*

Favorites (Most played):

*GetFavoriteGames();*

Leaderboards:

*GetLeaderBoards();*

100% complete:

*GetCompletes();*

== Screenshots ==

1. Options panel

