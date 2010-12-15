<?php
	
	class DeviceIPad extends MobileDevice {
		static protected $instance;
		
		public function initialize() {
			$this->about()->name = 'iPad';
			$this->about()->handle = 'ipad';
			$this->about()->user_agent = 'Mozilla/5.0 (iPad; U; CPU OS 3_2 like Mac OS X; en-us) AppleWebKit/531.21.10 (KHTML, like Gecko) Version/4.0.4 Mobile/7W367a Safari/531.21.10';
			
			// Version matching:
			$this->version()->expression = '%(CPU OS|CPU iPhone OS) ([0-9])_([0-9])%';
			$this->version()->capture = '\2.\3';
			
			// Positive matching:
			$this->matches()->positive = array(
				'%ipad%i'
			);
		}
	}
	
	DeviceIPad::instance();
	
?>