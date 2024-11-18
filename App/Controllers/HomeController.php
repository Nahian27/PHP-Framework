<?php

namespace phpTest\App\Controllers;

use phpTest\App\Classes\BaseController;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends BaseController
{

    public function index(Request $request): void
    {
        $data = $this->DB->query('select * from issue');
        $this->view('home', ['data' => $data, 'name' => $request->get('_name')]);
    }

    public function single(Request $request,string $id): void
    {
        var_dump($request);
        $data = $this->DB->query('select * from issue where id = ?', $id);
        $this->json($data);
    }
}