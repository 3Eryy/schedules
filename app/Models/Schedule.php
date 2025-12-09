<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'kelas_id',
        'subject_id',
        'date',
        'status',
        'start_time',
        'end_time'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function kelas () {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function subject () {
        return $this->belongsTo(Subjects::class, 'subject_id');
    }
}
