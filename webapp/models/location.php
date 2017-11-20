<?php
	class Location {
		
		//attributes
		private $latitude;
		private $longitude;
		
		//getters and setters
		public function getLatitude() { return $this->latitude; }
		public function setLatitude($value) { $this->latitude = $value; }
		public function getLongitude() { return $this->longitude; }
		public function setLongitude($value) { $this->longitude = $value; }
		
		//constructor
		public function __construct() {
			//empty object
			if (func_num_args() == 0) {
				$this->latitude = 0;
				$this->longitude = 0;
			}
			//object with data from arguments
			if (func_num_args() == 2) {
				//get arguments
				$arguments = func_get_args();
				//pass arguments to attributes
				$this->latitude = $arguments[0];
				$this->longitude = $arguments[1];
			}
		}
	
		//instance methods
		
		//represents the object in JSON format
		public function toJson() {
			return json_encode(array(
					'latitude' => $this->latitude,
					'longitude' => $this->longitude
				));
		}
	}
?>