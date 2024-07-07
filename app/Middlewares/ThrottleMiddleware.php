<?php

declare(strict_types=1);

namespace Demo\Middlewares;

use Pecee\Http\Middleware\IMiddleware;
use Pecee\Http\Request;

final class ThrottleMiddleware implements IMiddleware
{

	public function handle(Request $request, int $maxAttempts = 3, int $banDuration = 60): void
	{
		$attempts = 3;
		// implement your limiting here

		// set header
		response()
			->header("X-RateLimit-Limit: $maxAttempts")
			->header("X-RateLimit-Remaining: " . ($maxAttempts - $attempts))
			->header("X-RateLimit-Reset: " . $banDuration);

		if ($attempts >= $maxAttempts) {
			response()
				->httpCode(429)
				->json([
					'error' => true,
					'message' => 'Too many requests'
				]);
		}

	}
}