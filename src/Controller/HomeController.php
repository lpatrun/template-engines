<?php

namespace ExampleApp\Controller;

use ExampleApp\Library\PHPTemplateRenderer;
use Jenssegers\Blade\Blade;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\FilesystemLoader;

class HomeController extends BaseController
{
    public function index()
    {
        $json = file_get_contents(dirname(__DIR__).'/data.json');

        return $this->render('hello_world.html.twig', json_decode($json, true));
    }

    public function templateEnginesTask() {
        
        $loader = new FilesystemLoader([$GLOBALS['viewDir'], $GLOBALS['layoutDir']]);
        $twig = new Environment($loader);
      
        try {
            $json = file_get_contents(dirname(__DIR__).'/data.json');
            $this->response->getBody()->write(
                $twig->render('home.html.twig',['passed_values' => json_decode($json, true)]));
        } catch (LoaderError $e) {
            $this->response->getBody()->write($e->getMessage());
        } catch (RuntimeError $e) {
            $this->response->getBody()->write($e->getMessage());
        } catch (SyntaxError $e) {
            $this->response->getBody()->write($e->getMessage());
        }

        return $this->response;
    }
}