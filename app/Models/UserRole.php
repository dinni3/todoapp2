<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    public function user()
{
    return $this->belongsTo(User::class, 'UserID', 'id');
}

public function permissions()
{
    return $this->hasMany(RolePermission::class, 'RoleID', 'RoleID');
}

   //public function user()

}
