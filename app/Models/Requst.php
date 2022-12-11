<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requst extends Model
{
    use HasFactory; 
    public $timestamps = false;
    protected $primaryKey = 'request_num_id';
    protected $guarded = ['request_num_id'];
    
}
