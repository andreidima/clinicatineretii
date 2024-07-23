<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Orar extends Model
{
    use HasFactory;

    protected $table = 'orare';
    protected $guarded = [];

    public function path()
    {
        return "/orare/{$this->id}";
    }

    /**
     * Get the specializare that owns the Orar
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function specializare(): BelongsTo
    {
        return $this->belongsTo(Specializare::class, 'specializare_id');
    }

    /**
     * Get the medic that owns the Orar
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function medic(): BelongsTo
    {
        return $this->belongsTo(Medic::class, 'medic_id');
    }
}
