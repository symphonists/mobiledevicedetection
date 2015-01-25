<?php
	
	require_once TOOLKIT . '/class.datasource.php';
	
	class DataSourceMobileDeviceDetection extends Datasource {
		public function __construct($parent, $env = null, $process_params = true) {
			parent::__construct($parent, $env, $process_params);
			
			$this->_dependencies = array();
		}
		
		public function about() {
			return array(
				'name'			=> 'Mobile Device Detection',
				'author'		=> array(
					'name'			=> 'Rowan Lewis',
					'website'		=> 'http://rowanlewis.com',
					'email'			=> 'me@rowanlewis.com'
				),
				'version'		=> '1.0',
				'release-date'	=> '2010-01-28'
			);
		}
		
		public function allowEditorToParse() {
			return false;
		}
		
		public function execute($param_pool) {
			$data = MobileDetector::detect();
			$result = new XMLElement('device');
			$result->setAttribute('is-mobile', 'no');
			
			if ($data->passed()) $result->setAttribute('is-mobile', 'yes');
			
			foreach ($data->devices() as $type => $values) {
				if (!$values->detected) continue;
				
				$item = new XMLElement($type);
				
				foreach ($values->captures as $name => $value) {
					$item->setAttribute($name, $value);
				}
				
				$result->appendChild($item);
			}
			
			return $result;
		}
	}
	
?>