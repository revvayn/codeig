<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Home extends BaseController
{
    public function index(): string
    {
        $data=[
            'title' => 'Dashboard Admin',
        ];
        return view('admin/home',$data);
    }
}
