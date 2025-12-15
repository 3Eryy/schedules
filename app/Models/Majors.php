<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Majors extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'code', 'max_pararel'];

    public function kelas() {
        return $this->hasMany(Kelas::class, 'majors_id');
    }

}
