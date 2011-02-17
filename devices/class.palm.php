<?php
	
	class DevicePalm extends MobileDevice {
		static protected $instance;
		
		public function initialize() {
			$this->{'name'} = 'Palm';
			
			// Positive matching:
			$this->allow(
				'%palmsource%i',	'%palmos%i',		'%webos%i'
			);
		}
	}
	
	DevicePalm::instance();
	
?>