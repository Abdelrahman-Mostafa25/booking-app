<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supervisor_info extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = ['counter_id','phone_num'];
    public $incrementing = false;
    protected $guarded = [];
    
}
