<?php

namespace phpTest\src\Controllers;

use phpTest\src\App\Attributes\Route;
use phpTest\src\App\Classes\BaseController;
use Symfony\Component\HttpFoundation\Request;

class Single extends BaseController
{
    #[Route('/{id}', ['GET', 'POST'])]
    public function single(Request $request, string $id): void
    {
        if ($request->getMethod() === Request::METHOD_POST) {
            var_dump($request->request->all());
        } else {
            $data = $this->DB->query('select * from issue where id = ?', $id);
            $data && $this->view('single', ['item' => $data[0]]);
        }
    }
}