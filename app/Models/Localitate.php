<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Relations\BelongsTo;

class Localitate extends Model
{
    use HasFactory;

    protected $table = 'localitati';
    protected $guarded = [];

    public function path()
    {
        return "/localitati/{$this->id}";
    }

    /**
     * Get the judet that owns the Localitate
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function judet(): BelongsTo
    {
        return $this->belongsTo(Judet::class, 'judet_id');
    }

}
