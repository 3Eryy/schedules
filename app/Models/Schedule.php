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

    // Tambahkan relationship ke journal
    public function journal()
    {
        return $this->hasOne(Journal::class, 'schedule_id');
    }

    public function absence()
    {
        return $this->hasMany(Absence::class, 'schedule_id');
    }

    // Booted method
    public function updateStatusAutomatically(): void
    {
        $hasAbsences = $this->absence()->exists();
        $hasJournals = $this->journal()->exists();

        // status hanya berubah jika ADA DI KEDUA TABLE
        $newStatus = ($hasAbsences && $hasJournals)
            ? 'terlaksana'
            : 'terjadwal';

        // Update hanya jika status berbeda
        if ($this->status !== $newStatus) {
            $this->update(['status' => $newStatus]);
        }
    }
}
