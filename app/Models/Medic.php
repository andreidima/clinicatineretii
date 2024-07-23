<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Medic extends Model
{
    use HasFactory;

    protected $table = 'medici';
    protected $guarded = [];

    public function path()
    {
        return "/medici/{$this->id}";
    }

    /**
     * Get the specializare that owns the Medic
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function specializare(): BelongsTo
    {
        return $this->belongsTo(Specializare::class, 'specializare_id');
    }
}
