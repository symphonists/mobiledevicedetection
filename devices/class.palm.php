<?php

	class DevicePalm extends MobileDevice {
		static protected $instance;

		public function initialize() {
			$this->{'name'} = 'Palm';

			// Positive matching:
			$this->allow(
				'%palmsource%i',
				'%palmos%i'
			);

			$this->setIfNot(
				'hardware-type',
				'%.%',
				'mobile'
			);
		}
	}

	MobileDevice::instance('DevicePalm');