<?php

declare(strict_types=1);

namespace Framework;

class App
{
  private Router $router;
  private Container $container;
  public function __construct(string $containerDefination = null)
  {
    $this->container = new Container();
    $this->router = new Router();

    if ($containerDefination) {
      $containerDefination = include $containerDefination;
      $this->container->addDefinations($containerDefination);
    }
  }
  public function run()
  {
    $path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
    $method = $_SERVER['REQUEST_METHOD'];
    $this->router->dispatch($path, $method, $this->container);
  }
  public function get(string $path, array $controller)
  {
    $this->router->add('GET', $path, $controller);
    return $this;
  }
  public function post(string $path, array $controller)
  {
    $this->router->add('POST', $path, $controller);
    return $this;
  }
  public function delete(string $path, array $controller)
  {
    $this->router->add('DELETE', $path, $controller);
    return $this;
  }
  public function addMiddleware(string $middleware)
  {
    $this->router->addMiddleWare($middleware);
  }
  public function add(string $middleware)
  {
    $this->router->addRouteMiddleWare($middleware);
  }
  public function setErrorhandler(array $controller)
  {
    $this->router->setErrorhandler($controller);
  }
}
