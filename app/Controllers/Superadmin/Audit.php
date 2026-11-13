<?php

namespace App\Controllers\Superadmin;

use App\Controllers\BaseController;
use App\Models\AuditLogModel;

class Audit extends BaseController
{
    public function index()
    {
        $model = new AuditLogModel();
        $data = $model->orderBy('id', 'DESC')->findAll(200);

        return view('superadmin/audit/index', [
            'title' => 'Audit Log',
            'data'  => $data,
        ]);
    }
}
