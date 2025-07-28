<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [ 'service_id', 'service_provider_id', 'client_email', 'appointment_date', 'appointment_time' ];
}
