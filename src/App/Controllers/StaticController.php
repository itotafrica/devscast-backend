<?php
/**
 * This file is part of DevsCast.
 * (c) Bernard Ng <ngandubernard@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

namespace App\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\StatusCode;
use App\Validators\ContactValidator;
use Awurth\SlimValidation\Validator;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class StaticController
 * Static pages provider this is only for the WebApp
 * @package App\Controllers
 * @author bernard-ng, https://bernard-ng.github.io
 */
class StaticController extends Controller
{
    /**
     * Render about page
     * @param ServerRequestInterface|Request $request
     * @param ResponseInterface|Response $response
     * @return ResponseInterface|string
     */
    public function about(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        return $this->renderer->render($response, 'about.html.twig');
    }


    /**
     * Render contact page
     * @param RequestInterface|Request $request
     * @param ResponseInterface|Response $response
     * @return ResponseInterface|string
     */
    public function contact(RequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        if ($request->isPost()) {
            $validator = $this->container->get(Validator::class);
            $validator->validate($request, ContactValidator::getValidationRules());
            $errors = $validator->getErrors();
            [$subject, $message, $email, $name] = $request->getParams();

            if ($validator->isValid()) {
                mail("devscast@devs-cast.com", $subject, $message);
                $this->flash->success("contact");
                return $this->redirect("home");
            } else {
                $this->flash->error("contact");
                $this->status = StatusCode::HTTP_UNPROCESSABLE_ENTITY;
            }
        }
        return $this->renderer->render($response, 'contact.html.twig');
    }
}
