<?php
	
	require_once EXTENSIONS . '/mobiledevicedetection/libs/class.mobiledevicedetection.php';
	
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
					'callback'	=> 'redirect'
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
		const CONF_URL = 'redirect-url';
		const CONF_DEVICES = 'redirect-devices';
		
	/*-------------------------------------------------------------------------
		Utilities:
	-------------------------------------------------------------------------*/
		
		public function redirect($context) {
			$conf = Symphony::Configuration();
			$device = MobileDeviceDetection::detect(MobileDeviceDetection::DEVICE_ANDROID);
			$url = $conf->get(self::CONF_URL, self::CONF);
			
			/**
			* Allows other extensions to override when and where a mobile device is redirected.
			* 
			* @delegate MobileRedirection
			* @param string $context /frontend/
			* @param string $url
			* @param MobileDeviceDetection $device
			*/
			Frontend::instance()->ExtensionManager->notifyMembers(
				'MobileRedirection',
				'/frontend/',
				array(
					'url'		=> &$url,
					'device'	=> $device
				)
			);
			
			if (!$url || !$device->passed()) return;
			
			redirect($url);
		}
		
		public function appendPreferences($context) {
			$conf = Symphony::Configuration();
			
			$group = new XMLElement('fieldset');
			$group->setAttribute('class', 'settings');
			$group->appendChild(new XMLElement('legend', __('Mobile Device Detection')));
			
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
			
			foreach (array_keys(MobileDeviceDetection::$positives) as $type) {
				$item = new XMLElement('li', $type);
				$list->appendChild($item);
			}
			
			$group->appendChild($list);
			
			$context['wrapper']->appendChild($group);
		}
	}
	
?>