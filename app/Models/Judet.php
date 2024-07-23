<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Judet extends Model
{
    use HasFactory;

    protected $table = 'judete';
    protected $guarded = [];

    public function path()
    {
        return "/judete/{$this->id}";
    }
}
