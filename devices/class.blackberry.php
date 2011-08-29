<?php

	class DeviceBlackBerry extends MobileDevice {
		static protected $instance;

		public function initialize() {
			$this->{'name'} = 'BlackBerry';
			$this->{'user-agent'} = 'Mozilla/5.0 (BlackBerry; U; BlackBerry 9800; en-GB) AppleWebKit/534.1+ (KHTML, like Gecko) Version/6.0.0.337 Mobile Safari/534.1+';
			$this->{'user-agent'} = 'BlackBerry9500/5.0.0.484 Profile/MIDP-2.1 Configuration/CLDC-1.1 VendorID/-1';
			$this->{'user-agent'} = 'BlackBerry9000/4.6.0.307 Profile/MIDP-2.0 Configuration/CLDC-1.1 VendorID/-1';

			// Positive matching:
			$this->allow(
				'%blackberry%i'
			);

			// Version matching:
			$this->capture(
				'software-version',
				'%(BlackBerry[0-9]{4}|\bVersion)/([0-9]\.[0-9])%',
				'\2'
			);
		}
	}

	MobileDevice::instance('DeviceBlackBerry');

?>