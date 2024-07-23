<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pacient extends Model
{
    use HasFactory;

    protected $table = 'pacienti';
    protected $guarded = [];

    public function path()
    {
        return "/pacienti/{$this->id}";
    }

    /**
     * Get the localitate that owns the Localitate
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function localitate(): BelongsTo
    {
        return $this->belongsTo(Localitate::class, 'localitate_id');
    }

    /**
     * Get the judetNastere that owns the Localitate
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function judetNastere(): BelongsTo
    {
        return $this->belongsTo(Judet::class, 'judet_nastere_id');
    }

    /**
     * Get all of the programari for the Pacient
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function programari(): HasMany
    {
        return $this->hasMany(Programare::class, 'pacient_id');
    }
}
