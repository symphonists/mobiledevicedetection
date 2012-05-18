# Mobile Device Detection

Detects mobile clients, what device they are using and redirect mobile clients.

## Installation

1. Upload the 'mobiledevicedetection' folder in this to your Symphony 'extensions' folder.
 
2. Enable it by selecting the "Mobile Device Detection" and choosing 'Enable' from the with-selected menu, then click Apply.

3. There should now be a "Mobile Device Detection" datasource available.


## Usage

This extension provides a "Mobile Device Detection" datasource for detecting mobile devices based on user-agent string. Its output takes the following form:

	<device is-mobile="no" />

If a mobile device is detected the mobile attribute will be set to "yes" and an element will be added the device being used to view the page:

	<device is-mobile="yes">
		<android version="2.3" />
	</device>

It is theoretically possible for more than one device to appear in this list.


## Redirects

You can redirect mobile devices of your choice to a custom mobile site, this can disabled by a visitor by adding `?not-mobile` to the current page URL. This sets a cookie and prevents any further attempts to redirect the client.

All configuration is managed from System > Preferences:

	No Redirect Cookie
	+-----------------------------------+
	| no-mobile-redirect                |
	+-----------------------------------+
	
	Redirect URL
	+-----------------------------------+
	| ...                               |
	+-----------------------------------+
	
	Redirect Devices
	+-----------------------------------+
	| ...                               |
	+-----------------------------------+
	android blackberry ipad iphone palm

If the URL is set, but no devices are selected, then any mobile visitor will be redirected.


## Delegates

This extension exposes the `MobileRedirection` delegate, which allows other extensions to override when and where a mobile device is redirected.

	(
		'MobileRedirection',
		'/frontend/',
		array(
			'url'		=> &$url,
			'devices'	=> &$devices,
			'result'	=> $result
		)
	)