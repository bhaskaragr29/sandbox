<?php
/**
 * @author    "Bhaskar Agarwal <bhaskar.agarwal@paddypower.com>"
 * @created   Feb 12, 2014 - 1:33:18 PM
 * @encoding  UTF-8
 */
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
require_once __DIR__ . '/bootstrap.php';

$app = new Silex\Application ();
$app ['debug'] = $config ['debug'];
$version = $config ['version'];
define ( 'VERSION', $version );

$app ['version'] = $version;

$app->register ( new Silex\Provider\ServiceControllerServiceProvider () );

$app->register ( new Silex\Provider\DoctrineServiceProvider (), array (
		'db.options' => $db ['database'] 
) );

$app ['base.controller'] = $app->share ( function () use($app) {
	return new \BIR\Component\LiveCalendar\Controller\Base ( $app );
} );

$app ['live.controller'] = $app->share ( function () use($app) {
	return new \BIR\Component\LiveCalendar\Controller\LiveController ( $app );
} );
/**
 * If it is a json request we can decode it here and substitute a usable object back into the request object.
 * Using the before() method we can ensure this is done for all requests.
 */
$app->before ( function (Request $request) {
	if (0 === strpos ( $request->headers->get ( 'Content-Type' ), 'application/json' )) {
		$data = json_decode ( $request->getContent (), true );
		$request->request->replace ( is_array ( $data ) ? $data : array () );
	}
	
	// var_dump($request->query->get('type'));
} );



$app->get ( '/bir/' . VERSION . '/livecalendar/{ids}', function ($ids) use($app) {
	// Request $request
	return $app ['live.controller']->getLivecalendarByIds ( $ids );
} )->value ( 'ids', 0 )->assert ( 'ids', '[0-9,]*' )->convert ( 'ids', function ($ids) {
	return explode ( ',', $ids );
} )->before ( function (Request $request) {
	$type = $request->query->get ( 'type' );
	// need more validation here
	if (! empty ( $type )) {
		if (! is_array ( $type ) && is_string ( $type )) {
			$type = array (
					$type 
			);
		}
		$request->query->set ( 'type', filter_var_array ( $type, FILTER_SANITIZE_STRING ) );
	}
} );

$app->put ( '/bir/' . VERSION . '/livecalendar/{id}', function ($id) use($app) {
	// set a security firewall here!!
	return $app ['live.controller']->createUpdateLiveCalendar ( $id );
} )->assert ( 'id', '\d+' );

// Register the error handler.
$app->error ( function (\Exception $e, $code) use($app) {
	if ($app ['debug']) {
		return;
	}
	switch ($code) {
		case 404 :
			$message = 'The requested page could not be found.';
			break;
		default :
			$message = 'We are sorry, but something went terribly wrong.';
	}
	
	return new Response ( $message, $code );
} );

return $app;