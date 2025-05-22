<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Spp extends Model
{
    use HasFactory;

    protected $table = 'spps';

    protected $fillable = [
        'tahun',
        'nominal',
    ];

    /**
     * Get all siswa with this spp
     */
    public function siswa(): HasMany
    {
        return $this->hasMany(Siswa::class);
    }
}
