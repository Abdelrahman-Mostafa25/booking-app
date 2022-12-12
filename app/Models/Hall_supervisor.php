<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hall_supervisor extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = ['hall_num_id','counter_id'];
    protected $guarded = ['counter_id'];
    public $incrementing = false;
}
