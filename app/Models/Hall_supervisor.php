<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hall_supervisor extends Model
{
    use HasFactory;
    protected $primaryKey = ['hall_num_id','counter_id'];
    protected $guarded = [];
}
