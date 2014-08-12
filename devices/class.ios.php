<?php

	class DeviceIOS extends MobileDevice {
		// iOS / Apple iPad / OS v6.0 / Safari
		const TABLET_OSv6_SAFARI = 'Mozilla/5.0 (iPad; CPU OS 6_0 like Mac OS X) AppleWebKit/536.26 (KHTML, like Gecko) Version/6.0 Mobile/10A5376e Safari/8536.25';

		// iOS / Apple iPad / OS v5.1 / Chrome v19
		const TABLET_OSv5_CHROMEv19 = 'Mozilla/5.0 (iPad; U; CPU OS 5_1_1 like Mac OS X; en) AppleWebKit/534.46.0 (KHTML, like Gecko) CriOS/19.0.1084.60 Mobile/9B206 Safari/7534.48.3';

		// iOS / Applie iPad / OS v3.2 / Safari
		const TABLET_OSv3_SAFARI = 'Mozilla/5.0 (iPad; U; CPU OS 3_2 like Mac OS X; en-us) AppleWebKit/531.21.10 (KHTML, like Gecko) Version/4.0.4 Mobile/7W367a Safari/531.21.10';

		// iOS / Apple iPhone / OS v6.0 / Safari
		const PHONE_OSv6_SAFARI = 'Mozilla/5.0 (iPhone; CPU iPhone OS 6_0 like Mac OS X) AppleWebKit/536.26 (KHTML, like Gecko) Version/6.0 Mobile/10A5376e Safari/8536.25';

		// iOS / Apple iPhone / OS v5.1 / Chrome v19
		const PHONE_OSv5_CHROMEv19 = 'Mozilla/5.0 (iPhone; U; CPU iPhone OS 5_1_1 like Mac OS X; en) AppleWebKit/534.46.0 (KHTML, like Gecko) CriOS/19.0.1084.60 Mobile/9B206 Safari/7534.48.3';

		// iOS / Applie iPhone / OS v3.2 / Safari
		const PHONE_OSv3_SAFARI = 'Mozilla/5.0 (iPhone; U; CPU iPhone OS 3_2 like Mac OS X; en-us) AppleWebKit/531.21.10 (KHTML, like Gecko) Version/4.0.4 Mobile/7W367a Safari/531.21.10';

		static protected $instance;

		public function initialize() {
			$this->{'name'} = 'iOS';
			$this->{'user-agent'} = self::PHONE_OSv3_SAFARI;

			// Positive matching:
			$this->allow(
				'%ipad|iphone%i'
			);

			// Chrome:
			$this->setIf(
				'browser-name',
				'%CriOS/([0-9]+(\.[0-9]+)+)%',
				'chrome'
			);
			$this->setIf(
				'browser-version',
				'%CriOS/([0-9]+(\.[0-9]+)+)%',
				'\1'
			);

			// Device:
			$this->setIf(
				'hardware-type',
				'%.%',
				'mobile'
			);
			$this->setIf(
				'hardware-type',
				'%iPad%',
				'tablet'
			);

			// Operating system:
			$this->setIf(
				'system-version',
				'%(CPU OS|CPU iPhone OS) ([0-9])_([0-9])%',
				'\2.\3'
			);
		}
	}

	MobileDevice::instance('DeviceIOS');