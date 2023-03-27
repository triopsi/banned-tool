<?php

namespace BannedTool\Middleware;

use BannedTool\Banned\Banned;
use Cake\Core\InstanceConfigTrait;
use Cake\Http\ServerRequestFactory;
use Cake\Utility\Inflector;
use Cake\View\View;
use Cake\View\ViewBuilder;
use Laminas\Diactoros\CallbackStream;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Banned Middleware.
 */
class BannedMiddleware implements MiddlewareInterface
{

    use InstanceConfigTrait;

    /**
     * @var array
     */
    protected $_defaultConfig = [
        'className' => View::class,
        'templatePath' => 'Error', // src/Templates/Error
        'statusCode' => 403,
        'templateLayout' => false,
        'templateFileName' => 'banned',
        'templateExtension' => '.php',
        'contentType' => 'text/html',
    ];

    /**
     * Contructor.
     *
     * @param array<string, mixed> $config
     */
    public function __construct(array $config = []) {
        $this->setConfig($config);
    }

    /**
     * Process Method for Middleware. Handle an incoming request.
     *
     * @param \Cake\Http\ServerRequest $request Request Object.
     * @param \Psr\Http\Server\RequestHandlerInterface $handler Handle Object.
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface {
        // Get CLient IP Address from request.
        $ip = $request->clientIp();

        // Start maintenance object.
        $bannedObj = new Banned();

        // Calling $handler->handle() delegates control to the *next* middleware
        // In your application's queue.
        $response = $handler->handle($request);

        // Check Maintenance Mode with whitelist ip.
        if (!$bannedObj->isBanned($ip)) {
            return $response;
        }

        // Build maintenance mode view.
        $response = $this->build($response);

        // Response with view.
        return $response;
    }

    /**
     * Create View and Content and send to the client.
     *
     * @param \Psr\Http\Message\ResponseInterface $response Response Object.
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function build(ResponseInterface $response) {
        $cakeRequest = ServerRequestFactory::fromGlobals();
        $builder = new ViewBuilder();

        $templateName = $this->getConfig('templateFileName');
        $templatePath = $this->getConfig('templatePath');

        $builder->setClassName($this->getConfig('className'))->setTemplatePath(Inflector::camelize($templatePath));
        if (!$this->getConfig('templateLayout')) {
            $builder->disableAutoLayout();
        } else {
            $builder->setLayout($this->getConfig('templateLayout'));
        }

        $view = $builder
            ->build([], $cakeRequest)
            ->setConfig('_ext', $this->getConfig('templateExtension'));

        $bodyString = $view->render($templateName);

        $response = $response->withHeader('Retry-After', (string)HOUR)
            ->withHeader('Content-Type', $this->getConfig('contentType'))
            ->withStatus($this->getConfig('statusCode'));

        $body = new CallbackStream(function () use ($bodyString) {
            return $bodyString;
        });

        /** @var \Psr\Http\Message\ResponseInterface $maintenanceResponse */
        $maintenanceResponse = $response->withBody($body);

        return $maintenanceResponse;
    }
}