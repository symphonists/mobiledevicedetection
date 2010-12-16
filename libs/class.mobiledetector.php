<?php
	
	class MobileDetector {
		/**
		* Matches for non-mobile devices.
		*/
		static public $negatives = array(
			'%OfficeLiveConnector%i',	'%MSIE 8\.0%i',
			'%OptimizedIE8%i',			'%MSN Optimized%i',
			'%Creative AutoUpdate%i',	'%Swapper%i'
		);
		
		/**
		* Matches for mobile devices.
		*/
		static public $positives = array(
			'%midp%i',			'%j2me%i',			'%avantg%i',
			'%docomo%i',		'%novarra%i',		'%240x320%i',
			'%opwv%i',			'%chtml%i',			'%pda%i',
			'%windows ce%i',	'%mmp/%i',			'%mib/%i',
			'%symbian%i',		'%wireless%i',		'%nokia%i',
			'%hand%i',			'%mobi%i',			'%phone%i',
			'%cdm%i',			'%up\.b%i',			'%audio%i',
			'%SIE\-%i',			'%SEC\-%i',			'%samsung%i',
			'%HTC%i',			'%mot\-%i',			'%mitsu%i',
			'%sagem%i',			'%sony%i',			'%alcatel%i',
			'%lg%i',			'%erics%i',			'%vx%i',
			'%NEC%i',			'%philips%i',		'%mmm%i',
			'%xx%i',			'%panasonic%i',		'%sharp%i',
			'%wap%i',			'%sch%i',			'%rover%i',
			'%pocket%i',		'%benq%i',			'%java%i',
			'%pt%i',			'%pg%i',			'%vox%i',
			'%amoi%i',			'%bird%i',			'%compal%i',
			'%kg%i',			'%voda%i',			'%sany%i',
			'%kdd%i',			'%dbt%i',			'%sendo%i',
			'%sgh%i',			'%gradi%i',			'%jb%i',
			'%\d\d\di%i',		'%moto%i'
		);
		
		/**
		* Device types.
		*/
		static private $devices = array();
		
		/**
		* Register a new mobile device type.
		* 
		* @param	$device			MobileDevice
		*/
		static public function registerDevice(MobileDevice $device) {
			self::$devices[$device->{'handle'}] = $device;
		}
		
		/**
		* Fetch a list of registered devices.
		* 
		* @return	array
		*/
		static public function devices() {
			return self::$devices;
		}
		
		/**
		* Detect what device the current session was requested from.
		* 
		* @param	$simulate		Name of device to simulate (self::DEVICE_*)
		* @return	MobileDeviceDetection
		*/
		static public function detect(MobileDevice $device = null) {
			$result = new MobileDetectorResults();
			$data = $_SERVER;
			
			// Simulate a particular device?
			if ($device) $data = $device->simulate($data);
			
			// Something to do with detecting WAP support:
			if (isset($data['HTTP_X_WAP_PROFILE']) || preg_match('%wap\.|\.wap%i', $data['HTTP_ACCEPT'])) {
				$result->pass();
			}
			
			// Make sure no negative matches apply, not a mobile:
			foreach (self::$negatives as $match) {
				if (!preg_match($match, $data['HTTP_USER_AGENT'])) continue;
				
				$result->fail();
				
				return $result;
			}
			
			// Check for generic mobile device, not a mobile:
			foreach (self::$positives as $match) {
				if (!preg_match($match, $data['HTTP_USER_AGENT'])) continue;
				
				$result->pass();
				
				break;
			}
			
			// Check for matches, is a mobile:
			foreach (self::$devices as $device) {
				$device->detect($data, $result);
			}
			
			// No decision yet, not a mobile:
			if (!$result->done()) $result->fail();
			
			return $result;
		}
	}
	
?>