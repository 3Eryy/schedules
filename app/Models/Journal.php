<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'kelas_id',
        'subject_id',
        'schedule_id',
        'date',
        'start_time',
        'end_time',
        'notes',
        'teacher_name',
        'class_name',
        'major_name',
        'level_name',
        'subject_name',
        'photo',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subjects::class, 'subject_id');
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class, 'schedule_id');
    }

    protected static function booted()
    {
        // Ketika journal dibuat/diupdate
        static::saved(function ($journal) {
            $journal->schedule->updateStatusAutomatically();
        });
        
        // Ketika journal dihapus
        static::deleted(function ($journal) {
            $journal->schedule->updateStatusAutomatically();
        });
    }
}