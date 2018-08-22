<?php
namespace App\Traits;

use Ramsey\Uuid\Uuid;

trait MyUuid
{

    /**
     * Generate and return uuid v5
     * 
     * @return uuid
     */
    public function generateUuid()
    {
        return Uuid::uuid5(Uuid::NAMESPACE_DNS, md5(uniqid(date('d-m-Y H:i:s'), true)))->toString();
    }
}
