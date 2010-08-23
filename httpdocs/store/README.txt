
  Welcome to Zazzle Store Builder 1.0.2 from Zazzle.com
=-=-=-=-=-=-=-=-=-=-==-=-=-=-=-=-=-=-=-=-=-=-=-=-==-=-=-=

What's New in 1.0.2? 
====================

Marketplace Feeds
-----------------
Welcome to Zazzle Store Builder version 1.0.2.  This release contains support for
Zazzle Marketplace feeds.  For Store Builder users, this means you are no longer
limited to featuring products from a specific gallery.  You can now display products
from almost any Zazzle gallery, selected by keyword search rather than gallery name. 

	To configure your Store Builder 1.0.2 Store to use Marketplace Feeds:
	---------------------------------------------------------------------
	1. Follow the instructions for standard configuration, but leave the 
	$contributorHandle variable blank in the file configuration.php. 

	2. Enter search keywords in the $keywords variable in the configuration.php file.

	Existing Stores
	---------------
	If you already have a Store Builder store and have modified your existing zstore.php file,
	here's what you need to do to enable Marketplace Feeds:

	Edit zstore.php and change one line, originally line 124, to read:

	$dataURLBase = $contributorHandle!="" ? 'http://feed.zazzle.com/'.$contributorHandle.'/feed' : 'http://feed.zazzle.com/feed';

	It is highly recommended, however, to update your zstore.php file with the latest version to get all the
	latest bug fixes and features!

Keyword Enhancement
-------------------
 - Keywords can now contain spaces without breaking the feed.
 - Keywords are also now retained when paginating or sorting.
 - Adding a keyword in configuration.php sets the default search.
 - Adding an additional keyword using the 'keywords' URL parameter now ADDS to the default as opposed to overwriting it.
   Example: 
		Set $keywords in configuration.php to "dog stamps". This creates a feed of mostly dog postage.
		Now add a keyword in the URL using the 'keywords' parameter, like this: http://yoursitedomain/?keywords=rottweiler
		The feed will now pull all products matching "dog" and "stamps" and "rottweiler".
		This feature allows you to build a usable site search.

Google Analytics Enhancement
----------------------------
 - Google Analytics now works across domains. Setup your Google Analytics account within the Store Builder and within Zazzle.com, and your data will be tracked between the two domains.

General information
===================
Zazzle Store Builder is the Zazzle publishing tool that lets you pull Zazzle content onto your website.
Display your Zazzle gallery on your commercial site, mix products from your Zazzle gallery 
with your other products, or collect Zazzle Associate fees when customers buy Zazzle products
from other galleries on your site.  

Zazzle Zazzle Store Builder setup is simple: just select one of the examples provided, edit the configuration
file to use your Contributor ID and Associate ID, and move the files to your server or ISP.  You can
also create a sophisticated custom web site with your Zazzle products or integrate your products
into your existing site.

Installation information is in the PDF Zazzle Store Builder Guide, included in this distribution.

Inventory
=========
* c folder (empty)
* css folder (contains zstore.css, the Cascading Style Sheet for your Zazzle Store Builder)
* include folder (contains the main Zazzle Store Builder files, including configuration.php, which you must edit)
* images_only_sample (example Zazzle Store Builder that displays only product images, no text)
* top_5_sample (example Zazzle Store Builder that displays only your 5 most popular products)
* two_grids_sample (example Zazzle Store Builder combining images_only_sample and top_5_sample)
* full_grids_sample (example Zazzle Store Builder displays all products in your gallery with all information, in one grid)
* README.txt (this file) 
* ZazzleStoreBuilder.pdf (documentation, including installation, configuration, deployment, and tutorial)

This package is released under the following license:
=====================================================
Copyright (c) 2008, Zazzle.com
 
All rights reserved.
 
 Redistribution and use in source and binary forms, with or without modification, are permitted provided that the following conditions are met:
     * Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.
     * Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer 
     in the documentation and/or other materials provided with the distribution.
     * Neither the name of Zazzle.com nor the names of its contributors may be used to endorse or promote products
     derived from this software without specific prior written permission.
     
THIS SOFTWARE IS PROVIDED BY Zazzle.com  "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL Zazzle.com BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE 
OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
