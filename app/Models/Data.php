<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Data extends Model
{
    use HasFactory;
    protected $hidden = ['user_id'];

    public function Category()
    {
      return $this->belongsTo(Category::class);
    }
    public function Currency()
    {
      return $this->belongsTo(Currency::class);
    }
}
