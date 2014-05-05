<?php

	class DeviceAndroid extends MobileDevice {
		// Android Phone / Samsung Galaxy Nexus / OS v4.0 / Chrome v18
		const PHONE_OSv4_CHROMEv18 = 'Mozilla/5.0 (Linux; Android 4.0.4; Galaxy Nexus Build/IMM76B) AppleWebKit/535.19 (KHTML, like Gecko) Chrome/18.0.1025.133 Mobile Safari/535.19';

		// Android Phone / HTC Sensation / OS v4.0 / Android Browser
		const PHONE_OSv4_NATIVE = 'Mozilla/5.0 (Linux; U; Android 4.0.3; de-ch; HTC Sensation Build/IML74K) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30';

		// Android Phone / HTC Desire Z / OS v2.2 / Android Browser
		const PHONE_OSv2_NATIVE = 'Mozilla/5.0 (Linux; U; Android 2.2.1; en-gb; HTC_DesireZ_A7272 Build/FRG83D) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1';

		static protected $instance;

		public function initialize() {
			$this->{'name'} = 'Android';
			$this->{'user-agent'} = self::PHONE_OSv2_NATIVE;

			// Positive matching:
			$this->allow(
				'%android%i'
			);

			// Chrome:
			$this->setIf(
				'browser-name',
				'%Chrome/([0-9]+(\.[0-9]+)+)%',
				'chrome'
			);
			$this->setIf(
				'browser-version',
				'%Chrome/([0-9]+(\.[0-9]+)+)%',
				'\1'
			);

			// Device:
			$this->setIf(
				'hardware-type',
				'%Mobile%',
				'mobile'
			);
			$this->setIfNot(
				'hardware-type',
				'%Mobile%',
				'tablet'
			);

			// Operating system:
			$this->setIf(
				'system-version',
				'%Android ([0-9]+(\.[0-9]+)+);%',
				'\1'
			);
		}
	}

	MobileDevice::instance('DeviceAndroid');