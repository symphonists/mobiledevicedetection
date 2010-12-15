<?php
	
	class DeviceAndroid extends MobileDevice {
		static protected $instance;
		
		public function initialize() {
			$this->about()->name = 'Android';
			$this->about()->handle = 'android';
			$this->about()->user_agent = 'Mozilla/5.0 (Linux; U; Android 2.2; en-us; sdk Build/FRF91) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1';
			
			// Version matching:
			$this->version()->expression = '%Android ([0-9]\.[0-9]);%';
			$this->version()->capture = '\1';
			
			// Positive matching:
			$this->matches()->positive = array(
				'%android%i'
			);
		}
	}
	
	DeviceAndroid::instance();
	
?>