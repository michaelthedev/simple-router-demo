<?php
/**
 * This file contains all the routes for the project
 */

use Pecee\SimpleRouter\SimpleRouter;

SimpleRouter::csrfVerifier(new \Demo\Middlewares\CsrfVerifier());

\Pecee\SimpleRouter\SimpleRouter::setDefaultNamespace('Demo\\Controllers');

SimpleRouter::group(['exceptionHandler' => \Demo\Handlers\CustomExceptionHandler::class], function () {

    SimpleRouter::get('/', 'DefaultController@home')->name('home');
    SimpleRouter::get('/contact', 'DefaultController@contact')->name('contact');
    SimpleRouter::basic('/companies/{id?}', 'DefaultController@companies')->name('companies');

    // API

    SimpleRouter::group(['prefix' => '/api', 'middleware' => \Demo\Middlewares\ApiVerification::class], function () {
        SimpleRouter::resource('/demo', 'ApiController');

		// Check the x-rate-limit-limit headers to see the parameters
		SimpleRouter::get('/throttle', 'ApiController@throttle')
			->addMiddleware(\Demo\Middlewares\ThrottleMiddleware::class.',4,80');
	});

    // CALLBACK EXAMPLES

    SimpleRouter::get('/foo', function() {
        return 'foo';
    });

    SimpleRouter::get('/foo-bar', function() {
        return 'foo-bar';
    });

});