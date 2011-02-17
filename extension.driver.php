<?php
	
	require_once EXTENSIONS . '/mobiledevicedetection/libs/class.mobiledetector.php';
	require_once EXTENSIONS . '/mobiledevicedetection/libs/class.mobiledetectorresults.php';
	require_once EXTENSIONS . '/mobiledevicedetection/libs/class.mobiledevice.php';
	require_once EXTENSIONS . '/mobiledevicedetection/devices/class.android.php';
	require_once EXTENSIONS . '/mobiledevicedetection/devices/class.blackberry.php';
	require_once EXTENSIONS . '/mobiledevicedetection/devices/class.ipad.php';
	require_once EXTENSIONS . '/mobiledevicedetection/devices/class.iphone.php';
	require_once EXTENSIONS . '/mobiledevicedetection/devices/class.palm.php';
	
	class Extension_MobileDeviceDetection extends Extension {
	/*-------------------------------------------------------------------------
		Definition:
	-------------------------------------------------------------------------*/
		
		public function about() {
			return array(
				'name'			=> 'Mobile Device Detection',
				'version'		=> '1.1',
				'release-date'	=> '2010-12-14',
				'author'		=> array(
					'name'			=> 'Rowan Lewis',
					'website'		=> 'http://rowanlewis.com',
					'email'			=> 'me@rowanlewis.com'
				)
			);
		}
		
		public function getSubscribedDelegates() {
			return array(
				array(
					'page'		=> '/frontend/',
					'delegate'	=> 'FrontendInitialised',
					'callback'	=> 'initialize'
				),
				array(
					'page'		=> '/system/preferences/',
					'delegate'	=> 'AddCustomPreferenceFieldsets',
					'callback'	=> 'appendPreferences'
				)
			);
		}
		
	/*-------------------------------------------------------------------------
		Configuration:
	-------------------------------------------------------------------------*/
		
		const CONF = 'mobile-device-detection';
		const CONF_COOKIE = 'not-mobile-cookie';
		const CONF_URL = 'redirect-url';
		const CONF_DEVICES = 'redirect-devices';
		
	/*-------------------------------------------------------------------------
		Install:
	-------------------------------------------------------------------------*/
		
		public function install() {
			$conf = Symphony::Configuration();
			$conf->set(self::CONF_COOKIE, 'no-mobile-redirect', self::CONF);
			Administration::instance()->saveConfig();
			
			return true;
		}
		
	/*-------------------------------------------------------------------------
		Utilities:
	-------------------------------------------------------------------------*/
		
		public function initialize($context) {
			$conf = Symphony::Configuration();
			$result = MobileDetector::detect();
			$cookie = $conf->get(self::CONF_COOKIE, self::CONF);
			$url = $conf->get(self::CONF_URL, self::CONF);
			$devices = $conf->get(self::CONF_DEVICES, self::CONF);
			
			if ($devices) {
				$devices = explode(', ', $devices);
			}
			
			else {
				$devices = array();
			}
			
			/**
			* Allows other extensions to override when and where a mobile device is redirected.
			* 
			* @delegate MobileRedirection
			* @param string $context /frontend/
			* @param string $url
			* @param array $devices
			* @param MobileDetectorResults $result
			*/
			Frontend::instance()->ExtensionManager->notifyMembers(
				'MobileRedirection',
				'/frontend/',
				array(
					'url'		=> &$url,
					'devices'	=> &$devices,
					'result'	=> $result
				)
			);
			
			// Uncomment to reset disabled state:
			//unset($_SESSION[$cookie]);
			
			// User is requesting mobile redirection be disabled:
			if (isset($_GET['not-mobile']) || isset($_SESSION[$cookie])) {
				// Not a mobile, this request only:
				if ($_GET['not-mobile'] == 'once') return;
				
				// Not a mobile permenantly:
				$_SESSION[$cookie] = 'yes'; return;
			}
			
			$can_redirect = $url && $result->passed();
			
			// Device was not detected, stop.
			if ($devices) {
				$can_redirect = false;
				
				foreach ($devices as $name) {
					if (!isset($result->devices()->{$name})) continue;
					if (!$result->devices()->{$name}->detected) continue;
					
					$can_redirect = true; break;
				}
			}
			
			if ($can_redirect) redirect($url);
		}
		
		public function appendPreferences($context) {
			$conf = Symphony::Configuration();
			
			$group = new XMLElement('fieldset');
			$group->setAttribute('class', 'settings');
			$group->appendChild(new XMLElement('legend', __('Mobile Device Detection')));
			
			// No Redirect Cookie:
			$label = Widget::Label(__('No Redirect Cookie'));
			$label->appendChild(Widget::Input(
				'settings[' . self::CONF . '][' . self::CONF_COOKIE . ']',
				General::Sanitize(
					$conf->get(self::CONF_COOKIE, self::CONF)
				)
			));
			$group->appendChild($label);
			
			// Redirect URL:
			$label = Widget::Label(__('Redirect URL'));
			$label->appendChild(Widget::Input(
				'settings[' . self::CONF . '][' . self::CONF_URL . ']',
				General::Sanitize(
					$conf->get(self::CONF_URL, self::CONF)
				)
			));
			$group->appendChild($label);
			
			// Redirect Devices:
			$label = Widget::Label(__('Redirect Devices'));
			$label->appendChild(Widget::Input(
				'settings[' . self::CONF . '][' . self::CONF_DEVICES . ']',
				General::Sanitize(
					$conf->get(self::CONF_DEVICES, self::CONF)
				)
			));
			$group->appendChild($label);
			
			$list = new XMLElement('ul');
			$list->setAttribute('class', 'tags');
			
			foreach (MobileDetector::devices() as $type => $device) {
				$item = new XMLElement('li', $type);
				$list->appendChild($item);
			}
			
			$group->appendChild($list);
			
			$context['wrapper']->appendChild($group);
		}
	}
	
?>