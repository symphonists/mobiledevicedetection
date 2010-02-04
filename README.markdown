# Mobile Device Detection #

Version: 1.0
Author: [Max Wheeler](http://makenosound.com)  
Build Date: 05 February 2010  
Requirements: Tested on Symphony 2.0.6, should be compatible with all 2.x versions


## Installation ##

1. Upload the 'mobiledevicedetection' folder in this to your Symphony 'extensions' folder.
 
2. Enable it by selecting the "Mobile Device Detection" and choosing 'Enable' from the with-selected menu, then click Apply.

3. There should now be a "Mobile Device Detection" datasource available.

## Usage ##

This extension provides a "Mobile Device Detection" datasource for detecting mobile devices based on user-agent string. Its output takes the following form:

    <device mobile="" iphone="" />

If a mobile device is detected the mobile attribute will return "true":

    <device mobile="true" iphone="" />
    
There's also a special case for iPhone/iPod Touch (MobileSafari) devices so you can differentiate those users if you wish:

    <device mobile="true" iphone="true" />

## Change log ##

* **1.0**: Initial release