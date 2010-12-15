<?php
	
	class MobileDetectorResults {
		public $detected;
		public $devices;
		
		public function __construct() {
			$this->devices = (object)array();
			
			foreach (MobileDetector::devices() as $type => $device) {
				$this->devices->{$type} = (object)array(
					'detected'	=> false,
					'version'	=> null
				);
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