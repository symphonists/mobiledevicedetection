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
		
		public function grab($param_pool) {
			$data = MobileDeviceDetection::detect();
			$xml = new XMLElement('device');
			$xml->setAttribute('is-mobile', 'no');
			
			if ($data->passed()) $xml->setAttribute('is-mobile', 'yes');
			
			foreach ($data->devices() as $type => $value) {
				$xml->setAttribute('is-' . Lang::createHandle($type), $value ? 'yes' : 'no');
			}
			
			return $xml;
		}
	}
	
?>