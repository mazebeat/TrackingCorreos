<?php namespace App\Util;

\HTML::macro('button', function ($type = 'button', $name, $options = array()) {
	if (!isset($options['type'])) {
		$options['type'] = $type;
	}

	if (array_key_exists('id', $options)) {
		return $options['id'];
	}

	return '<button ' . \HTML::attributes($options) . '>' . $name . '</button>';
});

\HTML::macro('activeLink', function ($url) {
	return \Request::is($url) ? 'active current' : '';
});

\HTML::macro('activeState', function ($urls = array()) {
	if (count($urls) > 0) {
		for ($i = 0; $i < count($urls); $i++) {
			if (\Request::path() == $urls[$i]) {
				echo "active current";
			}
		}
	}
});

\Form::macro('selectYear2', function ($name, $startYear = null, $endYear = null, $options = array()) {
	if ($endYear == null) {
		$endYear = \Carbon\Carbon::now()->year;
	}
	if ($endYear == null) {
		$endYear = 1980;
	}

	$years = range($endYear, $startYear);
	$list  = array_combine($years, $years); // [2013 => 2013]

	if (!isset($options['name'])) {
		$options['name'] = $name;
	}

	$html   = array();
	$html[] = '<option value=""></option>';

	foreach ($list as $value => $display) {
		$html[] = sprintf('<option value="%d">%d</option>', $value, $display);
	}

	$options = attributes($options);
	$list    = implode('', $html);

	return "<select{$options}>{$list}</select>";
});

\Form::macro('checkbox2', function ($name, $title, $value, $class = 'default', $check = false, $options = array()) {
	$output = '<div class="ckbox ckbox-%s">%s%s</div>';
	if (!isset($options['name'])) {
		$options['name'] = $name;
	}

	if (!isset($options['id'])) {
		$options['id'] = $name;
	}

	return sprintf($output, $class, \Form::checkbox($name, $value, $check, $options), \Form::label($name, $title, $options));
});

\HTML::macro('tableize', function ($structure, $data, $headers = true) {

	$html = '';

	if ($headers) {
		$html .= '<table id="detailTable">';
		$html .= '<thead>';
		$html .= '<tr>';
		foreach ($structure as $title) {
			$html .= '<th>' . utf8_decode($title) . '</th>';
		}
		$html .= '<th>' . utf8_decode('Leído') . '</th>';
		$html .= '<th>' . utf8_decode('Retenido') . '</th>';
		$html .= '<th>' . utf8_decode('Fallido') . '</th>';

		$html .= '</tr>';
		$html .= '</thead>';
		$html .= '<tbody>';
	}

	foreach ($data as $item) {
		$html .= '<tr>';
		foreach ($structure as $key => $value) {
			$html .= '<td>' . utf8_decode($item->$key) . '</td>';
		}

		$html .= '<td>NO</td>';
		$html .= '<td>NO</td>';
		$html .= '<td>NO</td>';

		$html .= '</tr>';
	}

	if ($headers) {
		$html .= '</tbody>';
		$html .= '</table>';
	}

	return $html;
});

function attributes($attributes)
{
	$html = array();

	foreach ((array)$attributes as $key => $value) {
		$element = attributeElement($key, $value);

		if (!is_null($element)) {
			$html[] = $element;
		}
	}

	return count($html) > 0 ? ' ' . implode(' ', $html) : '';
}

function attributeElement($key, $value)
{
	if (is_numeric($key)) {
		$key = $value;
	}

	if (!is_null($value)) {
		return $key . '="' . e($value) . '"';
	}
}
