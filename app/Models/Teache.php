<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teache extends Model
{
    use HasFactory;
    protected $primaryKey = ['course_code','employee_num_id'];
    protected $guarded = [];
}
