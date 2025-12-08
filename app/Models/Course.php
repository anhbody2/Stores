<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class Course extends Model
{
    public $timestamps = false;
    protected $table = 'courses';
    public function category()
{
    return $this->belongsTo(Category::class, 'level');
}

}
