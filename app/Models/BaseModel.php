<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    public function serializeDate(\DateTimeInterface $dateTime)
    {
        return $dateTime->format('Y-m-d H:i:s');
    }
}
