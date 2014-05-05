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
		protected $rules;

		public function __construct() {
			$this->about = array();
			$this->allows = array();
			$this->captures = array();
			$this->denies = array();
			$this->rules = array();

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

		public function setIf($name, $expression, $replacement) {
			$this->captures[] = (object)array(
				'name' =>			$name,
				'type' =>			'if',
				'expression' =>		$expression,
				'replacement' =>	$replacement
			);
		}

		public function setIfNot($name, $expression, $replacement) {
			$this->captures[] = (object)array(
				'name' =>			$name,
				'type' =>			'if-not',
				'expression' =>		$expression,
				'replacement' =>	$replacement
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
					$test = (boolean)preg_match($capture->expression, $data['HTTP_USER_AGENT'], $matches);

					if ($capture->type === 'if') {
						if (!$test) continue;

						$result->devices()->{$type}->captures->{$capture->name} = preg_replace(
							$capture->expression,
							$capture->replacement,
							$matches[0]
						);
					}

					else if ($capture->type === 'if-not') {
						if ($test) continue;

						$result->devices()->{$type}->captures->{$capture->name} = $capture->replacement;
					}
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