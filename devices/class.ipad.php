<?php

	class DeviceIPad extends MobileDevice {
		static protected $instance;

		public function initialize() {
			$this->{'name'} = 'iPad';
			$this->{'user-agent'} = 'Mozilla/5.0 (iPad; U; CPU OS 3_2 like Mac OS X; en-us) AppleWebKit/531.21.10 (KHTML, like Gecko) Version/4.0.4 Mobile/7W367a Safari/531.21.10';

			// Positive matching:
			$this->allow(
				'%ipad%i'
			);

			// Version matching:
			$this->capture(
				'software-version',
				'%(CPU OS|CPU iPhone OS) ([0-9])_([0-9])%',
				'\2.\3'
			);
		}
	}

	MobileDevice::instance('DeviceIPad');

?>