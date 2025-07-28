<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkingHours extends Model
{
    protected $table = 'working_hours';

    protected $fillable = [ 'service_provider_id', 'weekday', 'start_time', 'end_time' ];

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'service_provider_id', 'service_provider_id');
    }
}
