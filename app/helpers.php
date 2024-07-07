<?php

use Pecee\Http\Input\InputHandler;
use Pecee\SimpleRouter\SimpleRouter as Router;
use Pecee\Http\Url;
use Pecee\Http\Response;
use Pecee\Http\Request;


/**
 * Get url for a route by using either name/alias, class or method name.
 *
 * The name parameter supports the following values:
 * - Route name
 * - Controller/resource name (with or without method)
 * - Controller class name
 *
 * When searching for controller/resource by name, you can use this syntax "route.name@method".
 * You can also use the same syntax when searching for a specific controller-class "MyController@home".
 * If no arguments is specified, it will return the url for the current loaded route.
 *
 * @param string|null $name
 * @param array|string|null $parameters
 * @param array|null $getParams
 * @return Url
 * @throws InvalidArgumentException
 */
function url(?string $name = null, array|string|null $parameters = null, ?array $getParams = null): Url
{
	return Router::getUrl($name, $parameters, $getParams);
}

function response(?array $json = null, int $code = 200): Response|null
{
	if (!is_null($json)) {
		Router::response()
			->httpCode($code ?? 200)
			->json($json);
	}

	return Router::response();
}

function request(): Request
{
	return Router::request();
}

/**
 * Get input class
 * @param string|null $index Parameter index name
 * @param mixed|null $defaultValue Default return value
 * @param array ...$methods Default methods
 * @return InputHandler|array|string|null
 */
function input(string $index = null, mixed $defaultValue = null, ...$methods): array|string|InputHandler|null
{
	if ($index !== null) {
		return request()->getInputHandler()->value($index, $defaultValue, ...$methods);
	}

	return request()->getInputHandler();
}

function redirect(string $url, ?int $code = null): void
{
	if ($code !== null) {
		response()->httpCode($code);
	}

	response()->redirect($url);
}

/**
 * Get current csrf-token
 * @return string|null
 */
function csrf_token(): ?string
{
	$baseVerifier = Router::router()->getCsrfVerifier();
	return $baseVerifier?->getTokenProvider()->getToken();
}