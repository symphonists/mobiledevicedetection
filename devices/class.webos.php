<?php

	class DeviceWebOS extends MobileDevice {
		// WebOS Tablet / HP TouchPad / WebOS v3.0
		const webOS3_Tablet = 'Mozilla/5.0 (hp-tablet; Linux; hpwOS/3.0.0; U; de-DE) AppleWebKit/534.6 (KHTML, like Gecko) wOSBrowser/233.70 Safari/534.6 TouchPad/1.0';

		// WebOS Phone / HP Pre 3 / WebOS v2.0
		const webOS2_Phone = 'Mozilla/5.0 (Linux; webOS/2.1.2; U; xx-xx) AppleWebKit/534.6 (KHTML, like Gecko) webOSBrowser/221.11 Safari/534.6 Pre/3.0';

		// WebOS Phone / Palm Pre / WebOS v1.0
		const webOS1_Phone = 'Mozilla/5.0 (webOS/1.0; U; en-US) AppleWebKit/525.27.1 (KHTML, like Gecko) Version/1.0 Safari/525.27.1 Pre/1.0';

		static protected $instance;

		public function initialize() {
			$this->{'name'} = 'WebOS';
			$this->{'user-agent'} = self::webOS1_Phone;

			// Positive matching:
			$this->allow(
				'%webos|hpwOS%i'
			);

			// Device:
			$this->setIf(
				'hardware-type',
				'%.%',
				'mobile'
			);
			$this->setIf(
				'hardware-type',
				'%hp-tablet%',
				'tablet'
			);

			// Operating system:
			$this->setIf(
				'system-version',
				'%(webOS|hpwOS)/([0-9]+(\.[0-9]+)+);%',
				'\2'
			);
		}
	}

	MobileDevice::instance('DeviceWebOS');