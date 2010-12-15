<?php
	
	class DevicePalm extends MobileDevice {
		static protected $instance;
		
		public function initialize() {
			$this->about()->name = 'Palm';
			$this->about()->handle = 'palm';
			$this->about()->user_agent = '';
			
			// Positive matching:
			$this->matches()->positive = array(
				'%palmsource%i',	'%palmos%i',		'%webos%i'
			);
		}
	}
	
	DevicePalm::instance();
	
?>