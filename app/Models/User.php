<?php
namespace App\Models;

use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Notifications\Notifiable;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements Auditable
{

    use \OwenIt\Auditing\Auditable;

    use Notifiable,
        EntrustUserTrait;

    protected $fillable = [
        'uuid', 'username', 'first_name', 'last_name', 'email', 'password', 'api_token', 'verified', 'active',
    ];
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function verifyUser()
    {
        return $this->hasOne('App\Models\VerifyUser');
    }

    public function getGravatarAttribute()
    {
        $hash = md5(strtolower(trim($this->attributes['email'])));

        return 'http://www.gravatar.com/avatar/' . $hash;
    }
}
