<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $table = 'subject';
    protected $fillable = [
        'name',
        'id',
        'academic_year',
        'department',
        'credit',
        'dr_name',
        'requirement',
        'location',
        'schedule',

    ];

    public function user(){

        return $this->belongsToMany(User::class , 'user_subject','subject_id','user_id');
    }
}
