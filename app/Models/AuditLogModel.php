<?php

namespace App\Models;

use CodeIgniter\Model;

class AuditLogModel extends Model
{
    protected $table         = 'audit_log';
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'id_user',
        'username',
        'role',
        'action',
        'entity',
        'entity_id',
        'description',
        'ip_address',
        'created_at',
    ];
    protected $useTimestamps = false;

    public static function catat(string $action, ?string $entity = null, $entityId = null, ?string $description = null): void
    {
        $session = session();
        $ip = service('request')->getIPAddress();
        $model = new self();
        $model->insert([
            'id_user'     => $session->get('id_user'),
            'username'    => $session->get('username'),
            'role'        => $session->get('role_id'),
            'action'      => $action,
            'entity'      => $entity,
            'entity_id'   => $entityId,
            'description' => $description,
            'ip_address'  => $ip,
            'created_at'  => date('Y-m-d H:i:s'),
        ]);
    }
}
