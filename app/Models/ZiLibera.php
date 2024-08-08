<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ZiLibera extends Model
{
    use HasFactory;

    protected $table = 'zile_libere';
    protected $guarded = [];

    public function path()
    {
        return "/zile-libere/{$this->id}";
    }

    /**
     * Get the medic that owns the ZiLibera
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function medic(): BelongsTo
    {
        return $this->belongsTo(Medic::class, 'medic_id');
    }
}
