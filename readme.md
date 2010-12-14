# Mobile Device Detection

Detects mobile clients, what device they are using and redirect mobile clients.

__Version:__ 1.1  
__Date:__ 14 December 2010  
__Requirements:__ Symphony 2.1 and later  
__Author:__ Rowan Lewis <me@rowanlewis.com>, originally Max Wheeler  
__GitHub Repository:__ <http://github.com/rowan-lewis/mobiledevicedetection>  


## Installation

1. Upload the 'mobiledevicedetection' folder in this to your Symphony 'extensions' folder.
 
2. Enable it by selecting the "Mobile Device Detection" and choosing 'Enable' from the with-selected menu, then click Apply.

3. There should now be a "Mobile Device Detection" datasource available.


## Usage

This extension provides a "Mobile Device Detection" datasource for detecting mobile devices based on user-agent string. Its output takes the following form:

	<device is-mobile="no" is-andoid="no" iphone="no" ... />

If a mobile device is detected the mobile attribute will be set to "yes" along with any attributes designating the device type:

	<device is-mobile="yes" is-android="no" iphone="yes" ... />

Additionally, you can set a URL to redirect mobile devices to, and which devices you would like to redirect from the System > Preferences page.


## Delegates

This extension exposes the `MobileRedirection` delegate, which allows other extensions to override when and where a mobile device is redirected.

	(
		'MobileRedirection',
		'/frontend/',
		array(
			'url'		=> &$url,
			'device'	=> $device
		)
	)


## Changelog

*Version 1.1, 14 December 2010*

 - Re-wrote Max Wheelers original extension.
 - Added support for more devices, iPad and Android.
 - Added mobile device redirection support.


*Version 1.0, 5 February 2010*

 - Initial release