<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tarifario extends Model
{
   protected $fillable = ['supplier_id','file_name','file'];
}
