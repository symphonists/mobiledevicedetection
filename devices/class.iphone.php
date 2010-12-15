<?php
	
	class DeviceIPhone extends MobileDevice {
		static protected $instance;
		
		public function initialize() {
			$this->about()->name = 'iPhone';
			$this->about()->handle = 'iphone';
			$this->about()->user_agent = 'Mozilla/5.0 (iPhone Simulator; U; CPU iPhone OS 4_0 like Mac OS X; en-us) AppleWebKit/532.9 (KHTML, like Gecko) Version/4.0.5 Mobile/8A293 Safari/6531.22.7';
			
			// Version matching:
			$this->version()->expression = '%(CPU OS|CPU iPhone OS) ([0-9])_([0-9])%';
			$this->version()->capture = '\2.\3';
			
			// Positive matching:
			$this->matches()->positive = array(
				'%iphone%i'
			);
		}
	}
	
	DeviceIPhone::instance();
	
?>