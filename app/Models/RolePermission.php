<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model
{
    protected $table = 'role_permissions';
    protected $primaryKey = 'PermissionID';

    public function role()
    {
        return $this->belongsTo(UserRole::class, 'RoleID', 'RoleID');
    }
}