<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Serviciu extends Model
{
    use HasFactory;

    protected $table = 'servicii';
    protected $guarded = [];

    public function path()
    {
        return "/servicii/{$this->id}";
    }
}
