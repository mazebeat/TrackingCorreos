<?php namespace App\Util;

/**
 * Class Functions
 *
 * @package App\Util
 */
Class Functions
{
	public static function printr($data)
	{
		return "<pre>" . htmlspecialchars(print_r($data, true)) . "</pre>";
	}

	public static function getMethods($class)
	{
		$class   = new ReflectionClass($class);
		$methods = $class->getMethods();

		return $methods;
	}

	public static function array_orderby()
	{
		$args = func_get_args();
		$data = array_shift($args);
		foreach ($args as $n => $field) {
			if (is_string($field)) {
				$tmp = array();
				foreach ($data as $key => $row) {
					$tmp[$key] = $row[$field];
				}
				$args[$n] = $tmp;
			}
		}
		$args[] = &$data;
		call_user_func_array('array_multisort', $args);

		return array_pop($args);
	}

	public static function arrayToXML($array_in)
	{
		$return     = "";
		$attributes = array();
		foreach ($array_in as $k => $v) {
			if ($k[0] == "@") {
				$attributes[str_replace("@", "", $k)] = $v;
			}
			else {
				if (is_array($v)) {
					$return .= \App\Util\Functions::generateXML($k, \arrayToXML($v), $attributes);
					$attributes = array();
				}
				else if (is_bool($v)) {
					$return .= \App\Util\Functions::generateXML($k, (($v == true) ? "true" : "false"), $attributes);
					$attributes = array();
				}
				else {
					$return .= \App\Util\Functions::generateXML($k, $v, $attributes);
					$attributes = array();
				}
			}
		}

		return $return;
	}

	public static function generateXML($tag_in, $value_in = "", $attribute_in = "")
	{
		$return         = "";
		$attributes_out = "";
		if (is_array($attribute_in)) {
			if (count($attribute_in) != 0) {
				foreach ($attribute_in as $k => $v):
					$attributes_out .= " " . $k . "=\"" . $v . "\"";
				endforeach;
			}
		}

		return "<" . $tag_in . "" . $attributes_out . ((trim($value_in) == "") ? "/>" : ">" . $value_in . "</" . $tag_in . ">");
	}

	public static function base64urlEncode($data)
	{
		return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
	}

	public static function base64urlDecode($data)
	{
		return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
	}

	public static function objectToArray($object)
	{
		return json_decode(json_encode($object), true);
	}

	public static function toObject($array)
	{
		$obj = new \stdClass();
		foreach ($array as $key => $val) {
			$key       = strtolower(trim($key));
			$obj->$key = is_array($val) ? \App\Util\Functions::toObject($val) : $val;
			//			$obj->$key = $val;
		}

		return $obj;
	}

	public static function count_recursive($array, $limit)
	{
		$count = 0;
		foreach ($array as $id => $_array) {
			if (is_array($_array) && $limit > 0) {
				$count += count_recursive($_array, $limit - 1);
			}
			else {
				$count += 1;
			}
		}

		return $count;
	}

	public static function getRealIP()
	{
		if ($_SERVER['HTTP_X_FORWARDED_FOR'] != '') {
			$client_ip = (!empty($_SERVER['REMOTE_ADDR'])) ? $_SERVER['REMOTE_ADDR'] : ((!empty($_ENV['REMOTE_ADDR'])) ? $_ENV['REMOTE_ADDR'] : "unknown");

			$entries = split('[, ]', $_SERVER['HTTP_X_FORWARDED_FOR']);

			reset($entries);
			while (list(, $entry) = each($entries)) {
				$entry = trim($entry);
				if (preg_match("/^([0-9]+\.[0-9]+\.[0-9]+\.[0-9]+)/", $entry, $ip_list)) {
					// http://www.faqs.org/rfcs/rfc1918.html
					$private_ip = array('/^0\./', '/^127\.0\.0\.1/', '/^192\.168\..*/', '/^172\.((1[6-9])|(2[0-9])|(3[0-1]))\..*/', '/^10\..*/');

					$found_ip = preg_replace($private_ip, $client_ip, $ip_list[1]);

					if ($client_ip != $found_ip) {
						$client_ip = $found_ip;
						break;
					}
				}
			}
		}
		else {
			$client_ip = (!empty($_SERVER['REMOTE_ADDR'])) ? $_SERVER['REMOTE_ADDR'] : ((!empty($_ENV['REMOTE_ADDR'])) ? $_ENV['REMOTE_ADDR'] : "unknown");
		}

		return $client_ip;

	}

	public static function serverData()
	{
		$data['IP'] = $_SERVER['REMOTE_ADDR'];
		if (preg_match('/' . "Netscape" . '/', $_SERVER["HTTP_USER_AGENT"])) {
			$data['BROWSER'] = "Netscape";
		}
		elseif (preg_match('/' . "Firefox" . '/', $_SERVER["HTTP_USER_AGENT"])) {
			$data['BROWSER'] = "FireFox";
		}
		elseif (preg_match('/' . "MSIE" . '/', $_SERVER["HTTP_USER_AGENT"])) {
			$data['BROWSER'] = "MSIE";
		}
		elseif (preg_match('/' . "Opera" . '/', $_SERVER["HTTP_USER_AGENT"])) {
			$data['BROWSER'] = "Opera";
		}
		elseif (preg_match('/' . "Konqueror" . '/', $_SERVER["HTTP_USER_AGENT"])) {
			$data['BROWSER'] = "Konqueror";
		}
		elseif (preg_match('/' . "Chrome" . '/', $_SERVER["HTTP_USER_AGENT"])) {
			$data['BROWSER'] = "Chrome";
		}
		elseif (preg_match('/' . "Safari" . '/', $_SERVER["HTTP_USER_AGENT"])) {
			$data['BROWSER'] = "Safari";
		}
		else {
			$data['BROWSER'] = "UNKNOWN";
		}

		return $data;
	}

	public static function convNumberToMonth($number)
	{
		$month = array(1 => 'enero', 2 => 'febrero', 3 => 'marzo', 4 => 'abril', 5 => 'mayo', 6 => 'junio', 7 => 'julio', 8 => 'agosto', 9 => 'septiembre', 10 => 'octubre', 11 => 'noviembre', 12 => 'diciembre');
		$month = array_get($month, $number);
		$month = studly_case($month);

		return $month;
	}

	public static function curlRequest($url = null, $postFields = null, $requestType = 'GET', $isFormData = false)
	{
		if (!isset($url)) {
			return json_encode(array('error' => 'URL param is required'));
		}
		$client = curl_init();
		curl_setopt($client, CURLOPT_URL, $url);
		if ($requestType == 'POST') {
			curl_setopt($client, CURLOPT_POST, true);
			curl_setopt($client, CURLOPT_CUSTOMREQUEST, 'POST');
			if (count($postFields)) {
				if (isset($postFields) && is_array($postFields)) {
					if ($isFormData) {
						$postFields = json_encode($postFields);
						curl_setopt($client, CURLOPT_POSTFIELDS, $postFields); // multipart/form-data
						$header = array('Content-Type: application/json', 'Content-Length: ' . strlen($postFields));
					}
					else {
						curl_setopt($client, CURLOPT_POSTFIELDS, http_build_query($postFields)); // application/x-www-form-urlencoded
						$postFields = json_encode($postFields);
						$header     = array('Content-Type: application/json', 'Content-Length: ' . strlen($postFields));
					}
				}
			}
			else {
				$header = array('Content-Type: application/json');
			}
		}
		else {
			curl_setopt($client, CURLOPT_POST, false);
			$header = array('Content-Type: application/json');
		}
		curl_setopt($client, CURLOPT_HTTPHEADER, $header);
		curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($client, CURLOPT_SSL_VERIFYPEER, false);
		//		curl_setopt($client, CURLOPT_FOLLOWLOCATION, true);
		$response = curl_exec($client);
		$result   = json_decode($response);
		curl_close($client);

		return $result;
	}
}
