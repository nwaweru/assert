<?php
namespace App\Models;

use Zizaco\Entrust\EntrustPermission;
use OwenIt\Auditing\Contracts\Auditable;

class Permission extends EntrustPermission implements Auditable
{

    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'uuid', 'name', 'display_name', 'description',
    ];

    public function roles()
    {
        return $this->belongsToMany('App\Models\Role', 'permission_role');
    }
}
