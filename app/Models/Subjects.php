<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subjects extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'code'];

    public function schedule () {
        return $this->hasMany(Schedule::class, 'subject_id');
    }
}
