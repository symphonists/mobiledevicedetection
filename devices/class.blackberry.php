<?php

	class DeviceBlackBerry extends MobileDevice {
		// BlackBerry Tablet / Model PlayBook / OS v2.0
		const BlackBerryPlayBook = 'Mozilla/5.0 (PlayBook; U; RIM Tablet OS 2.0.0; en-US) AppleWebKit/535.1+ (KHTML, like Gecko) Version/7.2.0.0 Safari/535.1+';

		// BlackBerry Phone / Model 9900 / OS v7.1
		const BlackBerry9900 = 'Mozilla/5.0 (BlackBerry; U; BlackBerry 9900; en) AppleWebKit/534.11+ (KHTML, like Gecko) Version/7.1.0.346 Mobile Safari/534.11+';

		// BlackBerry Phone / Model 9800 / OS v6.0
		const BlackBerry9800 = 'Mozilla/5.0 (BlackBerry; U; BlackBerry 9800; en) AppleWebKit/534.1+ (KHTML, Like Gecko) Version/6.0.0.141 Mobile Safari/534.1+';

		// BlackBerry Phone / Model 9700 / OS v5.0
		const BlackBerry9700 = 'BlackBerry9700/5.0.0.593 Profile/MIDP-2.1 Configuration/CLDC-1.1 VendorID/1';

		// BlackBerry Phone / Model 9000 / OS v4.6
		const BlackBerry9000 = 'BlackBerry9000/4.6.0.303 Profile/MIDP-2.0 Configuration/CLDC-1.1 VendorID/1';

		static protected $instance;

		public function initialize() {
			$this->{'name'} = 'BlackBerry';
			$this->{'user-agent'} = self::BlackBerry9000;

			// Positive matching:
			$this->allow(
				'%blackberry%i',
				'%playbook%i'
			);

			// Hardware:
			$this->setIfNot(
				'device-type',
				'%PlayBook%',
				'mobile'
			);
			$this->setIf(
				'device-type',
				'%PlayBook%',
				'tablet'
			);
			$this->setIf(
				'device-model',
				'%PlayBook%',
				'\0'
			);

			// Operating system:
			$this->setIf(
				'system-version',
				'%(BlackBerry[ ]?[0-9]{4}|\bVersion)/([0-9]+(\.[0-9]+)+)%',
				'\2'
			);
			$this->setIf(
				'system-version',
				'%RIM Tablet OS ([0-9]+(\.[0-9]+)+)%',
				'\1'
			);
		}
	}

	MobileDevice::instance('DeviceBlackBerry');