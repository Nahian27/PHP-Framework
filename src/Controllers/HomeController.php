<?php

namespace phpTest\src\Controllers;

use phpTest\src\App\Attributes\Route;
use phpTest\src\App\Classes\BaseController;
use phpTest\src\Models\Issue;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends BaseController
{
    #[Route('/')]
    final public function list(Request $request): void
    {
        $issue = new Issue();
        $this->view('home', ['data' => $issue->getAll(), 'name' => $request->get('_name')]);
    }

    #[Route('/{id}', ['GET', 'POST'])]
    public function single(Request $request, string $id): void
    {
        $issue = new Issue();
        $data = $issue->get($id);
        if ($request->getMethod() === Request::METHOD_POST) {
            $this->json($data);
        } else {
            $data && $this->view('single', ['item' => $data[0]]);
        }
    }
}