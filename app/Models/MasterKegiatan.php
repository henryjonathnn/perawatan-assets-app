<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterKegiatan extends Model
{
    use HasFactory;

    protected $fillable = ['kegiatan', 'is_custom', 'is_active'];

    public function kegiatans()
    {
        return $this->hasMany(Kegiatan::class, 'id_master_kegiatan');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
