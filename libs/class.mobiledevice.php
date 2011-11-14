<?php

	class MobileDevice {
		static public function instance($class) {
			if (!isset($class->$instance)) {
				$instance = new $class();
				$instance->initialize();
				MobileDetector::registerDevice($instance);
			}
			return $instance;
		}

		protected $about;
		protected $allows;
		protected $captures;
		protected $denies;

		public function __construct() {
			$this->about = array();
			$this->allows = array();
			$this->captures = array();
			$this->denies = array();

			$this->matches = (object)array(
				'negative'	=> array(),
				'positive'	=> array()
			);
		}

		public function __isset($name) {
			return isset($this->about[$name]);
		}

		public function __unset($name) {
			unset($this->about[$name]);
		}

		public function __get($name) {
			if ($name == 'handle') {
				return Lang::createHandle($this->name);
			}

			else if (!isset($this->{$name})) {
				return null;
			}

			return $this->about[$name];
		}

		public function __set($name, $value) {
			$this->about[$name] = $value;
		}

		public function allow() {
			$func_args = func_get_args();
			$this->allows = array_merge($this->allows, $func_args);
		}

		public function deny() {
			$func_args = func_get_args();
			$this->denies = array_merge($this->denies, $func_args);
		}

		public function capture($name, $expression, $replacement) {
			$this->captures[] = (object)array(
				'name'			=> $name,
				'expression'	=> $expression,
				'replacement'	=> $replacement
			);
		}

		public function detect($data, $result) {
			foreach ($this->denies as $match) {
				if (!preg_match($match, $data['HTTP_USER_AGENT'])) continue;

				$result->fail();

				return false;
			}

			foreach ($this->allows as $match) {
				if (!preg_match($match, $data['HTTP_USER_AGENT'])) continue;

				// Device matched:
				$type = $this->{'handle'};
				$result->pass();
				$result->devices()->{$type}->detected = true;

				foreach ($this->captures as $capture) {
					if (!preg_match($capture->expression, $data['HTTP_USER_AGENT'], $matches)) continue;

					if ($capture->replacement instanceof Closure) {
						$value = preg_replace_callback(
							$capture->expression, $capture->replacement, $matches[0]
						);
					}

					else {
						$value = preg_replace(
							$capture->expression, $capture->replacement, $matches[0]
						);
					}

					$result->devices()->{$type}->captures->{$capture->name} = $value;
				}

				return true;
			}

			return false;
		}

		public function simulate($data) {
			if (isset($this->{'user-agent'})) {
				$data['HTTP_USER_AGENT'] = $this->{'user-agent'};
			}

			return $data;
		}
	}

?>