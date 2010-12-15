<?php
	
	class DeviceBlackBerry extends MobileDevice {
		static protected $instance;
		
		public function initialize() {
			$this->about()->name = 'BlackBerry';
			$this->about()->handle = 'blackberry';
			$this->about()->user_agent = 'Mozilla/5.0 (BlackBerry; U; BlackBerry 9800; en-GB) AppleWebKit/534.1+ (KHTML, like Gecko) Version/6.0.0.337 Mobile Safari/534.1+';
			$this->about()->user_agent = 'BlackBerry9500/5.0.0.484 Profile/MIDP-2.1 Configuration/CLDC-1.1 VendorID/-1';
			$this->about()->user_agent = 'BlackBerry9000/4.6.0.307 Profile/MIDP-2.0 Configuration/CLDC-1.1 VendorID/-1';
			
			// Version matching:
			$this->version()->expression = '%(BlackBerry[0-9]{4}|\bVersion)/([0-9]\.[0-9])%';
			$this->version()->capture = '\2';
			
			// Positive matching:
			$this->matches()->positive = array(
				'%blackberry%i'
			);
		}
	}
	
	DeviceBlackBerry::instance();
	
?>