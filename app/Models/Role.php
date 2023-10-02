<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $table ='roles';
    protected $fillable = [
        'name',
        'display_name',
        'group',
        'guard_name'
    ];

    public function permissions()
    {
        return $this->belongsToMany(Permisson::class, 'role_has_permissions', 'role_id', 'permission_id');
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function hasPermission($permission)
    {
        return $this->permissions->contains('name', $permission->name);
    }

    public function givePermissionTo($permission)
    {
        return $this->permissions()->save($permission);
    }

}
