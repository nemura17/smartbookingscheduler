<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceProvider extends Model
{
    protected $table = 'users';

    public function workingHours()
    {
        return $this->hasMany(WorkingHours::class, 'service_provider_id');
    }
}
