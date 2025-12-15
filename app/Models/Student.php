<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;

class Student extends Model
{
    use HasFactory;
    use InteractsWithMedia;
    protected $fillable = ['name', 'kelas_id', 'photo', 'nis'];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

}
