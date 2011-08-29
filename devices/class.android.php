<?php

	class DeviceAndroid extends MobileDevice {
		static protected $instance;

		public function initialize() {
			$this->{'name'} = 'Android';
			$this->{'user-agent'} = 'Mozilla/5.0 (Linux; U; Android 2.2; en-us; sdk Build/FRF91) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1';

			// Positive matching:
			$this->allow(
				'%android%i'
			);

			// Version matching:
			$this->capture(
				'software-version',
				'%Android ([0-9]\.[0-9]);%',
				'\1'
			);
		}
	}

	MobileDevice::instance('DeviceAndroid');

?>