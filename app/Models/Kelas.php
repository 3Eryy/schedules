<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $fillable = ['majors_id', 'level', 'pararel'];
    protected $appends = ['full_class'];

    public function majors () {
        return $this->belongsTo(Majors::class, 'majors_id');
    }

    public function student () {
        return $this->hasMany(Student::class, 'kelas_id');
    }

    public function schedule() {
        return $this->hasMany(Schedule::class, 'kelas_id');
    }

    public function getFullClassAttribute()
    {
        return "{$this->level} {$this->majors->code} {$this->pararel}";
    }
}
