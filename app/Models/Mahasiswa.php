<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['nrp', 'nama', 'departemen_id', 'angkatan', 'is_active'])]
class Mahasiswa extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function departemen(): BelongsTo
    {
        return $this->belongsTo(Departemen::class);
    }
}
