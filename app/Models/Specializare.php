<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Specializare extends Model
{
    use HasFactory;

    protected $table = 'specializari';
    protected $guarded = [];

    public function path()
    {
        return "/specializari/{$this->id}";
    }

    /**
     * Get all of the medici for the Specializare
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function medici(): HasMany
    {
        return $this->hasMany(Medic::class, 'specializare_id');
    }
}
