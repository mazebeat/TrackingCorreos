<?php namespace App\Util;

	//<div class="menu">
	//    <ul>
	//        {{ \HTML::menu_active('/','Home') }}
	//        {{ \HTML::menu_active('page/about','About') }}
	//        {{ \HTML::menu_active('page/contacts','Contacts') }}
	//        {{ \HTML::menu_active('page/service','Service') }}
	//    </ul>
//</div>
\HTML::macro('menu_active', function ($route, $name) {
	if (\Request::is($route . '/*') OR \Request::is($route)) {
		$active = '<li class="active"><a href="' . \URL::to($route) . '">' . $name . '</a></li>';
	} else {
		$active = '<li><a href="' . \URL::to($route) . '">' . $name . '</a></li>';
	}

	return $active;
});

\HTML::macro('create_nav', function () {
});

\HTML::macro('load_documents', function ($dir) {
	$output = '';
	//	var_dump('a_'.substr($dir, 0, 4).'**m_'.substr($dir, 4, 2).'**c_'.substr($dir, 6, strlen($dir)));
	$ws = new \WebServiceController('/GestionDocIntelidata/RetornaListaAlfrescoPort?WSDL', '192.168.1.86', '8080', 'opRequestList', false);
	$ws->setRutaCarpeta(base64_decode($dir));
	$result = $ws->get('showFolder');
	//	dd($result);

	$element = '<div class="col-xs-6 col-sm-4 col-md-3 %s">
				    <div class="thmb">
				        <div class="ckbox ckbox-default">
				            <input type="checkbox" id="check%d" value="1"/>
				            <label for="check%d"></label>
				        </div>
				        <div class="btn-group fm-group">
				            <button type="button" class="btn btn-default dropdown-toggle fm-toggle" data-toggle="dropdown">
				                <span class="caret"></span>
				            </button>
				            <ul class="dropdown-menu fm-menu" role="menu">
				                <li><a href="' . \URL::to('#') . '"><i class="fa fa-envelope-o fa-fw"></i>Email</a></li>
				                <li><a href="' . \URL::to('#') . '"><i class="fa fa-print fa-fw"></i>Imprimir</a></li>
				                <li><a href="' . \URL::to('#') . '"><i class="fa fa-download fa-fw"></i>Descargar</a></li>
				                <li><a href="' . \URL::to('#') . '"><i class="fa fa-trash-o fa-fw"></i>Eliminar</a></li>
				            </ul>
				        </div>
				        <div class="thmb-prev text-center">
				            <span>%s</span>
				        </div>
				        <h5 class="fm-title"><a href="' . \URL::to('#') . '">%s</a></h5>
				        <small class="text-muted">Agregado: %s</small>
				    </div>
				</div>';

	foreach ($result->lista as $key => $value) {
		if (is_object($value)) {
			$año = explode('a_', $value->strcarpetaaño)[1];
			$mes = explode('m_', $value->strcarpetames)[1];

			$id        = $key;
			$doc_name  = $value->strnombredocumento;// 'document.xls';
			$extension = explode('.', $doc_name)[1];// 'xls';
			$type      = 'document';
			$image_url = 'images/files/media-%s.png';
			$image     = \HTML::image(sprintf($image_url, $extension), null, array('class' => ''));
			$created   = new \Carbon($value->strfechacreaciondocumento);
		} else {
			$año = explode('a_', $result->lista->strcarpetaaño)[1];
			$mes = explode('m_', $result->lista->strcarpetames)[1];

			$id        = $key;
			$doc_name  = $result->lista->strnombredocumento;// 'document.xls';
			$extension = explode('.', $doc_name)[1];// 'xls';
			$type      = 'document';
			$image_url = 'images/files/media-%s.png';
			$image     = \HTML::image(sprintf($image_url, $extension), null, array('class' => ''));
			$created   = new \Carbon($result->lista->strfechacreaciondocumento);

			break;
		}
		//
		//public 'strcarpetaaño' => string 'a_2014' (length=6)
		//public 'strcarpetacliente' => string 'c_111111111' (length=11)
		//public 'strcarpetames' => string 'm_04' (length=4)
		//public 'strdescripciondocumento' => string 'prueba.txt' (length=10)
		//public 'strfechacreaciondocumento' => string '2014-11-17' (length=10)
		//public 'strfechamodificaciondocumento' => string '2014-11-17' (length=10)
		//public 'stridcliente' => string '6b40a727-2a22-4dab-b2c1-5c5600cedde2' (length=36)
		//public 'striddocumento' => string '3e3e4376-e7b5-48ed-8fcc-83c94f6fbc7a' (length=36)
		//public 'strnombrecliente' => string 'c_111111111' (length=11)
		//public 'strnombredocumento' => string 'prueba.txt' (length=10)
		//public 'strnrodocumento' => string '1' (length=1)
		//public 'strpathruta' => string '/{http://www.alfresco.org/model/application/1.0}company_home/{http://www.alfresco.org/model/content/1.0}e_MOVISTAR/{http://www.alfresco.org/model/content/1.0}a_2014/{http://www.alfresco.org/model/content/1.0}m_04/{http://www.alfresco.org/model/content/1.0}c_111111111/{http://www.alfresco.org/model/content/1.0}prueba.txt' (length=321)
		//public 'strtipodocumento' => string 'contentUrl=store://2014/11/17/15/49/0e224750-1fa7-4014-9ab6-f09ce97bf175.bin|mimetype=application/vnd.ms-excel|size=625|encoding=UTF-8|locale=es_CL_' (length=148)
		//public 'strtitulodocumento' => string 'prueba.txt' (length=10)
		//public 'strusuariocreadordocumento' => string 'admin' (length=5)
		//public 'strusuariomodificaciondocumento' => string 'admin' (length=5)
		//public 'strversiondocumento' => string '1.1' (length=3)

		$output .= sprintf($element, $type, $id, $id, $image, $doc_name, $created);
	}

	return $output;
});

\HTML::macro('load_tags', function ($metas = array()) {
	if (count($metas) > 0) {
		$tags = '<ul class="tag-list">';
		foreach ($metas as $value) {
			$tags .= sprintf('<li><a href = "' . \URL::to('#') . '">%s</a></li>', $value);
		}
		$tags .= '</ul >';
	} else {
		$tags = '<div class="alert alert-danger">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-times"></i></button>
        No se encontraron etiquetas<strong>!</strong>.
    </div>';
	}

	return $tags;
});

\HTML::macro('fast_search', function ($keyword = null) {
	if (isset($keyword)) {
		return;
	}

	return $keyword;
});

\HTML::macro('search_result', function ($keyword = '') {
	if (trim($keyword) === '') {
		return;
	}

	$output = '';

	for ($i = 1; $i <= 3; $i++) {

		$output .= '<tr>
            <td>
                <div class="rdio rdio-primary">' . \Form::radio('user', $i, false, array('id' => $i)) . '<label for="' . $i . '"></label>
                </div>
            </td>
            <td>' . $i . '</td>
            <td>2004/01/23</td>
            <td>16.517.430-6</td>
            <td>888888888888888</td>
            <td>Alexis San Martin</td>
            <td><span class="label label-success">Activo</span></td>
            <td>10</td>
        </tr>';
	}

	return $output;
});

\Form::macro('chosenPerfiles', function ($name = 'perfiles', $options = array()) {
	$perfiles = array();
	$ws       = new \WebServiceController();
	$ws->setRutaCarpeta('');
	$result = $ws->get('showFolder');

	foreach ($result->lista as $key => $value) {
		$perfiles[] = $value;
	}

	return \Form::chosen($name, $perfiles, $options);
});

\Form::macro('chosen', function ($name, $list = array(), $options = array()) {
	$options['class'] .= ' chosen-select';
	if (!isset($options['name']))
		$options['name'] = $name;
	if (!isset($options['id']))
		$options['id'] = $name;

	$html   = array();
	$html[] = '<option value=""></option>';

	foreach ($list as $value => $display) {
		$html[] = sprintf('<option value="%d">%d</option>', $value, $display);
	}

	$options = attributes($options);
	$list    = implode('', $html);

	return "<select{$options}>{$list}</select>";
});

\Form::macro('selectYear2', function ($name, $startYear = null, $endYear = null, $options = array()) {
	if ($endYear == null)
		$endYear = \Carbon\Carbon::now()->year;
	if ($endYear == null)
		$endYear = 1980;

	$years = range($endYear, $startYear);
	$list  = array_combine($years, $years); // [2013 => 2013]

	if (!isset($options['name']))
		$options['name'] = $name;

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
	if (!isset($options['name']))
		$options['name'] = $name;
	if (!isset($options['id']))
		$options['id'] = $name;

	return sprintf($output, $class, \Form::checkbox($name, $value, $check, $options), \Form::label($name, $title, $options));
});

function attributes($attributes)
{
	$html = array();

	foreach ((array)$attributes as $key => $value) {
		$element = attributeElement($key, $value);

		if (!is_null($element))
			$html[] = $element;
	}

	return count($html) > 0 ? ' ' . implode(' ', $html) : '';
}

function attributeElement($key, $value)
{
	if (is_numeric($key))
		$key = $value;

	if (!is_null($value))
		return $key . '="' . e($value) . '"';
}
