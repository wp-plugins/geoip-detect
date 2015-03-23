<?php

class GeoIP_HostInfo_Reader implements GeoIp2\ProviderInterface{
	
	const URL = 'http://api.hostip.info/get_json.php?ip=';
	
	public function city($ip) {	
		$data = $this->api_call($ip);
		
		if (!$data)
			return null;
		
		$r = array();
		
		if ($data['country_name'])
			$r['country']['names'] = array('en' => $data['country_name']);
		if ($data['country_code'])
			$r['country']['iso_code'] = strtoupper($data['country_code']);
		
		if ($data['city']) {
			$r['city']['names'] = array('en' => $data['city']);
		}
		
		$record = new \GeoIp2\Model\City($r, array('en'));
		
		return $record;
	}
	
	public function country($ip) {
		return $this->city($ip); // too much info shouldn't hurt ...
	}
	
	public function close() {
			
	}
	
	public function metadata() {
		$data = new stdClass();
		$data->description = 'HostIP.info Web-API';
		
		return $data;
	}
	
	private function api_call($ip) {
		try {
			// Setting timeout limit to speed up sites
			$context = stream_context_create(
					array(
							'http' => array(
									'timeout' => 1,
							),
					)
			);
			// Using @file... to supress errors
			// Example output: {"country_name":"UNITED STATES","country_code":"US","city":"Aurora, TX","ip":"12.215.42.19"}
			$data = json_decode(@file_get_contents(self::URL . $ip, false, $context));
			
			$hasInfo = false;
			if ($data) {
				$data = get_object_vars($data);
				foreach ($data as $key => &$value) {
					if (stripos($value, '(unknown') !== false)
						$value = '';
					if (stripos($value, '(private') !== false)
						$value = '';
					if ($key == 'country_code' && $value == 'XX')
						$value = '';
				}
				$hasInfo = $data['country_name'] || $data['country_code'] || $data['city'];
			}
		
			if ($hasInfo)
				return $data;
			return null;
		} catch (Exception $e) {
			// If the API isn't available, we have to do this
			return null;
		}
	}
}

function geoip_detect2_hostinfo_reader() {
	return new GeoIP_HostInfo_Reader();
}

function geoip_detect2_load_hostinfo() {
	if (get_option('geoip-detect-source') == 'hostinfo')
	add_filter('geoip_detect2_reader', 'geoip_detect2_hostinfo_reader');
}
add_action('plugins_loaded', 'geoip_detect2_load_hostinfo');
