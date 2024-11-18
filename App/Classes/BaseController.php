<?php

namespace phpTest\App\Classes;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\FilesystemLoader;

class BaseController
{
    protected DB $DB;
    private Environment $twig;

    public function __construct()
    {
        $loader = new FilesystemLoader(__DIR__ . '/../Views');
        $this->twig = new Environment($loader);
        $this->DB = DB::getInstance();
    }

    public function view(string $view, array $data): Response
    {
        $template = '';
        try {
            $template = $this->twig->render($view . '.twig', $data);
        } catch (LoaderError|RuntimeError|SyntaxError $e) {
            $this->json(['msg' => 'View Error', 'err' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return (new Response($template))->send();
    }

    public function json(array $data, int $status = 200): JsonResponse
    {
        return (new JsonResponse($data, $status))->send();
    }
}