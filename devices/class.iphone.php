<?php

	class DeviceIPhone extends MobileDevice {
		static protected $instance;

		public function initialize() {
			$this->{'name'} = 'iPhone';
			$this->{'user-agent'} = 'Mozilla/5.0 (iPhone Simulator; U; CPU iPhone OS 4_0 like Mac OS X; en-us) AppleWebKit/532.9 (KHTML, like Gecko) Version/4.0.5 Mobile/8A293 Safari/6531.22.7';
			$this->{'user-agent'} = 'Mozilla/5.0 (iPhone; U; CPU iPhone OS 4_0 like Mac OS X; en-us) AppleWebKit/532.9 (KHTML, like Gecko) Version/4.0.5 Mobile/8A293 Safari/6531.22.7';

			// Confirm device identity:
			$this->allow(
				'%iphone%i'
			);

			// Find software version:
			$this->capture(
				'software-version',
				'%(CPU OS|CPU iPhone OS) ([0-9])_([0-9])%',
				'\2.\3'
			);
		}
	}

	MobileDevice::instance('DeviceIPhone');

?>