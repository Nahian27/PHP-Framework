<?php

namespace phpTest\src\Controllers;

use phpTest\src\App\Attributes\Route;
use phpTest\src\App\Classes\BaseController;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends BaseController
{
    #[Route('/')]
    public function list(Request $request): void
    {
        $data = $this->DB->query('select * from issue');
        $this->view('home', ['data' => $data, 'name' => $request->get('_name')]);
    }
}