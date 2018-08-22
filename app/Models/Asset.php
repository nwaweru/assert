<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Asset extends Model implements Auditable
{

    use \OwenIt\Auditing\Auditable;

    public function assetCategory()
    {
        return $this->belongsTo('App\Models\AssetCategory');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
