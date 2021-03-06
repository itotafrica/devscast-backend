<?php

/**
 * This file is part of DevsCast.
 * (c) Bernard Ng <ngandubernard@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

namespace App\Middlewares;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\StatusCode;

/**
 * Class EnableAPIMiddleware
 * @package API\Middlewares
 * @author bernard-ng <ngandubernard@gmail.com>
 */
class EnableAPIMiddleware
{

    /**
     * @var bool
     */
    private $enabled;

    /**
     * EnableAPIMiddleware constructor.
     * @param bool $enabled
     */
    public function __construct(bool $enabled = true)
    {
        $this->enabled = $enabled;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param $next
     * @return ResponseInterface
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, $next): ResponseInterface
    {
        if ($this->enabled) {
            return $next($request, $response);
        }

        return $response->withJson([
            "message" => sprintf("%s API is unavailable for the moment", APP_NAME),
            "status" => StatusCode::HTTP_SERVICE_UNAVAILABLE
        ], StatusCode::HTTP_SERVICE_UNAVAILABLE);
    }
}
