<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hall extends Model
{
    // protected $table = 'my_table_name';


    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'hall_id';
    protected $guarded = ['hall_id'];
}
