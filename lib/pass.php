<?php
#error_reporting(E_ALL);
	class pass {

		public function __construct($file) {
			if(file_exists($file)) {
				$this->file = @file_get_contents($file);
				$data = $this->passAttr();
				$this->name = str_replace('txt','css',$file);
				$this->passExport($data);
			}
			else { return 'You shall not pass! File does not exist.'; }
		}

		public function passAttr() {
			$prop = null; $prop_2 = null; $properties = null;

			preg_match_all("/[$].*= .*;/", $this->file, $match); $vars = count($match[0]);
			for ($i=0; $i < $vars; $i++) { $prop .= str_replace(' ',null,$match[0][$i]); $this->file = str_replace($match[0][$i],null,$this->file); }
			$prop_2 = explode(';', $prop); $prop = null;
			for ($i=0; $i < count($prop_2); $i++) {
			    $prop = explode('=', $prop_2[$i]);
			    if($prop[0] > null) { $properties[$prop[0]] = $prop[1]; }
			                           			}
			$this->properties = $properties;

			preg_match_all("/[$].*[;]/", $this->file, $value); $vals = count($value[0]);
			for ($i=0; $i < $vals; $i++) {
				$val = $value[0][$i]; $val_2 = str_replace(';',null,$val);
				$x = explode(':', $this->properties[$val_2]);
				
				# this lets us use google fonts with + in the name
				$x[0] = str_replace('+',' ', $x[0]);
				
				$this->file = str_replace($val, $x[0] . ";", $this->file);
				$this->file = str_replace('/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/',null, $this->file);
			}

			return $this->file;
		}

		public function passExport($data) {
			$export = fopen($this->name, "w");
			fwrite($export, $data);
			fclose($export);

		}
	}

?>