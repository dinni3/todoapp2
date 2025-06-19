<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    protected $table = 'user_roles';
    protected $primaryKey = 'RoleID';

    public function users()
    {
        return $this->hasMany(User::class, 'RoleID', 'RoleID');
    }

    public function permissions()
    {
        return $this->hasMany(RolePermission::class, 'RoleID', 'RoleID');
    }
}