<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kelas extends Model
{
    use HasFactory;

    protected $table = 'kelas';

    protected $fillable = [
        'nama_kelas',
        'kompetensi_keahlian',
    ];

    /**
     * Get all siswa in this kelas
     */
    public function siswa(): HasMany
    {
        return $this->hasMany(Siswa::class);
    }
}
