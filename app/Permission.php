<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    public function roles() {

        return $this->belongsToMany(Role::class, 'permission_role');

    }

    public function users() {

        return $this->belongsToMany(User::class, 'users_roles');

    }
}
