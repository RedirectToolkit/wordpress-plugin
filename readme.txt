=== Redirect Toolkit ===
Contributors: emanueleminotto
Donate link: http://rdir.io/
Tags: url shortener
Requires at least: 3.0.1
Tested up to: 3.4
Stable tag: 0.0.1
License: MIT
License URI: https://github.com/RedirectToolkit/wordpress-plugin/blob/master/LICENSE

The Redirect Toolkit is an ambitious URL shortener that allows you to keep track of visits, easily share your links, monitor campaigns and much more!

== Description ==

This plugin automates the creation of a short link of every page and post, its goal is to provide a full set of options for a complete short links management.

It provides global options and *optionally* specific post or page settings.

== Installation ==

1. Upload the .zip file to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Register to rdir.io and obtain an API key from your profile page (in the top bar of every page, where there's your email address)
4. Copy and paste your API in the 'Redirect Toolkit' section of your WordPress installation

== Frequently asked questions ==

= How does it work? =

When a page is viewed, edited or created, if a short link (by the Redirect Toolkit) wasn't generated and an API key is provided, the plugin will call the rdir.io APIs to generate a new one and store it.

This means that calls are executed only one time for every page/post.

= When are short links generated? =

Short links are created the first time a post is viewed, edited or created, short links are based on page permenent URL, so the path management doesn't affect the related short link of every page/post.

= Where are short links stored? =

The Redirect Toolkit allows the generation of more short links for every page, so to maintain an unique short link without changing it everytime, short links are stored in your WordPress database.

== Changelog ==

= 0.0.1 =

First release