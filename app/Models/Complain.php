<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complain extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'compalin_num_id';
    protected $guarded = ['compalin_num_id'];
}
