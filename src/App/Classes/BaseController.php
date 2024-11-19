<?php

namespace phpTest\src\App\Classes;

use Smarty\Exception;
use Smarty\Smarty;
use Symfony\Component\HttpFoundation\JsonResponse;

class BaseController
{
    protected DB $DB;
    private Smarty $smarty;

    public function __construct()
    {
        $this->DB = DB::getInstance();
        $this->smarty = new Smarty();
        $this->smarty
            ->setTemplateDir(__DIR__ . '/../../Views')
            ->setCompileDir(__DIR__ . '/../../../public/temp')
            ->setEscapeHtml(true);
    }

    public function view(string $view, array $data): void
    {
        foreach ($data as $k => $v) {
            $this->smarty->assign($k, $v);
        }

        try {
            $this->smarty->display($view . '.tpl');
        } catch (Exception|\Exception $e) {
            echo 'View Error: ' . $e->getMessage();
        }
        exit();
    }

    public function json(array $data, int $status = 200): JsonResponse
    {
        return (new JsonResponse($data, $status))->send();
    }
}