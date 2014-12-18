<?php namespace App\Util;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

/**
 * Class SiteHelpers
 *
 * @package App\Util
 */
class SiteHelpers
{
	/**
	 * Returns body id made up by URI segments
	 *
	 * @return string
	 */
	public static function bodyId()
	{
		$body_id = preg_replace('/\d-/', '', implode('-', Request::segments()));

		return !empty($body_id) && $body_id != '-' ? $body_id : "homepage";
	}

	/**
	 * Returns body classes made up by URI segments
	 *
	 * @return string
	 */
	public static function bodyClass()
	{
		$body_classes = [];
		$class        = "";

		foreach (Request::segments() as $segment) {
			if (is_numeric($segment) || empty($segment)) {
				continue;
			}

			$class .= !empty($class) ? "-" . $segment : $segment;

			array_push($body_classes, $class);
		}

		return !empty($body_classes) ? implode(' ', $body_classes) : null;
	}

	/**
	 * Returns the last performed database query
	 *
	 * @return string
	 */
	public static function getLastQuery()
	{
		$queries = DB::getQueryLog();

		return last($queries);
	}
}
