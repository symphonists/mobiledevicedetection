<?php
	
	class MobileDevice {
		static protected $instance;
		
		static public function instance() {
			if (!isset(static::$instance)) {
				static::$instance = new static();
				static::$instance->initialize();
				
				MobileDetector::registerDevice(static::$instance);
			}
			
			return static::$instance;
		}
		
		protected $about;
		protected $matches;
		protected $version;
		
		public function __construct() {
			$this->about = (object)array();
			$this->version = (object)array(
				'capture'		=> null,
				'expression'	=> null
			);
			$this->matches = (object)array(
				'negative'	=> array(),
				'positive'	=> array()
			);
		}
		
		public function about() {
			return $this->about;
		}
		
		public function matches() {
			return $this->matches;
		}
		
		public function version() {
			return $this->version;
		}
		
		public function simulate($data) {
			if ($this->about()->user_agent) {
				$data['HTTP_USER_AGENT'] = $this->about()->user_agent;
			}
			
			return $data;
		}
	}
	
?>