<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Programare extends Model
{
    use HasFactory;

    protected $table = 'programari';
    protected $guarded = [];

    public function path()
    {
        return "/programari/{$this->id}";
    }

    /**
     * Get the specializare that owns the Programare
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function specializare(): BelongsTo
    {
        return $this->belongsTo(Specializare::class, 'specializare_id');
    }

    /**
     * Get the medic that owns the Programare
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function medic(): BelongsTo
    {
        return $this->belongsTo(Medic::class, 'medic_id');
    }

    /**
     * Get the cabinet that owns the Programare
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cabinet(): BelongsTo
    {
        return $this->belongsTo(Cabinet::class, 'cabinet_id');
    }

    /**
     * Get the orar that owns the Programare
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function orar(): BelongsTo
    {
        return $this->belongsTo(Orar::class, 'orar_id');
    }

    /**
     * Get the pacient that owns the Programare
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pacient(): BelongsTo
    {
        return $this->belongsTo(Pacient::class, 'pacient_id');
    }
}
