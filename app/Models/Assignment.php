<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Assignment extends Model implements Auditable
{

    use \OwenIt\Auditing\Auditable;

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function asset()
    {
        return $this->belongsTo('App\Models\Asset');
    }
}
