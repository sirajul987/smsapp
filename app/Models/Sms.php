<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sms extends Model
{
    use HasFactory;

    protected $fillable = ['message', 'target_phone_no', 'sms_sending_time'];

    protected $table = 'sms';
}
