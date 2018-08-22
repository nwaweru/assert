<?php
namespace App\Models;

use Zizaco\Entrust\EntrustRole;
use OwenIt\Auditing\Contracts\Auditable;

class Role extends EntrustRole implements Auditable
{

    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'uuid', 'name', 'display_name', 'description',
    ];

    public function permissions()
    {
        return $this->belongsToMany('App\Models\Permission', 'permission_role');
    }
}
