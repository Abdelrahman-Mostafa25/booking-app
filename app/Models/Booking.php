<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    protected $primaryKey = ['employee_num_id','hall_num_id'];
    protected $guarded = [];
}
