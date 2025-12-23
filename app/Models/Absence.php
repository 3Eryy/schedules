<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absence extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'schedule_id',
        'date',
        'status',
        'student_name'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
    
    public function schedule()
    {
        return $this->belongsTo(Schedule::class, 'schedule_id');
    }

    protected static function booted()
    {
        // Ketika absence dibuat/diupdate
        static::saved(function ($absence) {
            $absence->schedule->updateStatusAutomatically();
        });
        
        // Ketika absence dihapus
        static::deleted(function ($absence) {
            $absence->schedule->updateStatusAutomatically();
        });
    }
}