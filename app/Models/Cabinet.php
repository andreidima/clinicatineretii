<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cabinet extends Model
{
    use HasFactory;

    protected $table = 'cabinete';
    protected $guarded = [];

    public function path()
    {
        return "/cabinete/{$this->id}";
    }

    /**
     * Get all of the programari for the Cabinet
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function programari(): HasMany
    {
        return $this->hasMany(Programare::class, 'cabinet_id');
    }
}
