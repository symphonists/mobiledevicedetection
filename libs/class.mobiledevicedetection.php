<?php
	
	class MobileDeviceDetection {
		/**
		* Understood device types.
		*/
		const DEVICE_ANDROID = 'Android';
		const DEVICE_BLACKBERRY = 'BlackBerry';
		const DEVICE_GENERIC = 'Generic';
		const DEVICE_IPAD = 'iPad';
		const DEVICE_IPHONE = 'iPhone';
		const DEVICE_PALM = 'Palm';
		
		/**
		* Matches for non-mobile devices.
		*/
		static public $negatives = array(
			'OfficeLiveConnector',				'MSIE 8\.0',
			'OptimizedIE8',						'MSN Optimized',
			'Creative AutoUpdate',				'Swapper'
		);
		
		/**
		* Matches for mobile devices.
		*/
		static public $positives = array(
			self::DEVICE_ANDROID	=> array(
				'android'
			),
			self::DEVICE_BLACKBERRY	=> array(
				'blackberry'
			),
			self::DEVICE_IPAD		=> array(
				'iPad'
			),
			self::DEVICE_IPHONE		=> array(
				'iPhone'
			),
			self::DEVICE_PALM		=> array(
				'palmsource',	'palmos',		'webos'
			),
			self::DEVICE_GENERIC	=> array(
				'midp',			'j2me',			'avantg',
				'docomo',		'novarra',		'240x320',
				'opwv',			'chtml',		'pda',
				'windows ce',	'mmp/',			'mib/',
				'symbian',		'wireless',		'nokia',
				'hand',			'mobi',			'phone',
				'cdm',			'up\.b',		'audio',
				'SIE\-',		'SEC\-',		'samsung',
				'HTC',			'mot\-',		'mitsu',
				'sagem',		'sony',			'alcatel',
				'lg',			'erics',		'vx',
				'NEC',			'philips',		'mmm',
				'xx',			'panasonic',	'sharp',
				'wap',			'sch',			'rover',
				'pocket',		'benq',			'java',
				'pt',			'pg',			'vox',
				'amoi',			'bird',			'compal',
				'kg',			'voda',			'sany',
				'kdd',			'dbt',			'sendo',
				'sgh',			'gradi',		'jb',
				'\d\d\di',		'moto'
			)
		);
		
		/**
		* Values for simulating mobile devices.
		*/
		static public $simulate = array(
			self::DEVICE_ANDROID	=> array(
				'HTTP_USER_AGENT'		=> 'Mozilla/5.0 (Linux; U; Android 2.2; en-us; sdk Build/FRF91) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1',
				'HTTP_ACCEPT'			=> 'application/xml,application/xhtml+xml,text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5',
			),
			self::DEVICE_BLACKBERRY	=> array(
				'HTTP_USER_AGENT'		=> 'Mozilla/5.0 (BlackBerry; U; BlackBerry 9800; en-GB) AppleWebKit/534.1+ (KHTML, like Gecko) Version/6.0.0.337 Mobile Safari/534.1+',
				'HTTP_ACCEPT'			=> 'text/html,application/xhtml+xml,application/xml,*/*;q=0.5',
			),
			self::DEVICE_IPAD		=> array(
				'HTTP_USER_AGENT'		=> 'Mozilla/5.0 (iPad; U; CPU OS 3_2 like Mac OS X; en-us) AppleWebKit/531.21.10 (KHTML, like Gecko) Version/4.0.4 Mobile/7W367a Safari/531.21.10',
				'HTTP_ACCEPT'			=> 'application/xml,application/xhtml+xml,text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5',
			),
			self::DEVICE_IPHONE		=> array(
				'HTTP_USER_AGENT'		=> 'Mozilla/5.0 (iPhone Simulator; U; CPU iPhone OS 4_0 like Mac OS X; en-us) AppleWebKit/532.9 (KHTML, like Gecko) Version/4.0.5 Mobile/8A293 Safari/6531.22.7',
				'HTTP_ACCEPT'			=> 'application/xml,application/xhtml+xml,text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5'
			)
		);
		
		/**
		* Detect what device the current session was requested from.
		* 
		* @param	$simulate		Name of device to simulate (self::DEVICE_*)
		* @return	MobileDeviceDetection
		*/
		static public function detect($simulate = false) {
			$data = new MobileDeviceDetection();
			$source = $_SERVER;
			
			// Simulate a particular device?
			if ($simulate) switch ($simulate) {
				case self::DEVICE_ANDROID:
				case self::DEVICE_BLACKBERRY:
				case self::DEVICE_IPAD:
				case self::DEVICE_IPHONE:
					$source = array_merge($source, self::$simulate[$simulate]);
					break;
				default:
					throw new Exception('No simulation data found for this device.');
			}
			
			// Something to do with detecting WAP support:
			if (isset($source['HTTP_X_WAP_PROFILE']) || preg_match('%wap\.|\.wap%i', $source['HTTP_ACCEPT'])) {
				$data->pass();
			}
			
			// Check for false positives, not a mobile:
			foreach (self::$negatives as $match) {
				if (!preg_match('%' . $match . '%i', $source['HTTP_USER_AGENT'])) continue;
				
				$data->fail();
				
				return $data;
			}
			
			// Check for positives, is a mobile:
			foreach (self::$positives as $type => $positives) {
				foreach ($positives as $match) {
					if (!preg_match('%' . $match . '%i', $source['HTTP_USER_AGENT'])) continue;
					
					$data->pass();
					$data->devices()->{$type} = true;
					break;
				}
			}
			
			// No decision yet, not a mobile:
			if (!$data->done()) $data->fail();
			
			return $data;
		}
		
		public $detected;
		public $devices;
		
		public function __construct() {
			$this->devices = (object)array();
			
			foreach (array_keys(self::$positives) as $type) {
				$this->devices->{$type} = false;
			}
		}
		
		/**
		* Is the detection 'done'.
		* 
		* @return	boolean
		*/
		public function done() {
			return !is_null($this->detected);
		}
		
		/**
		* Return map of device types.
		* 
		* @return	object
		*/
		public function devices() {
			return $this->devices;
		}
		
		/**
		* Mark detection as having failed and being 'done'.
		*/
		public function fail() {
			$this->detected = false;
		}
		
		/**
		* Mark detection as having passed and being 'done'.
		*/
		public function pass() {
			$this->detected = true;
		}
		
		/**
		* Mark detection as having passed and being 'done'.
		*/
		public function passed() {
			return $this->detected === true;
		}
	}
	
?>