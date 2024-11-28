<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;

    protected $table = 'projects';

    protected $fillable = [
        'name',
        'description',
        'start_date',
        'end_date',
    ];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function getStartDateAttribute($value)
    {
        return date('H:i', strtotime($value));
    }

    public function getEndDateAttribute($value)
    {
        return date('H:i', strtotime($value));
    }

}
