<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    // Nombre de la tabla (opcional si sigue la convención)
    protected $table = 'task';

    // Campos que se pueden asignar de manera masiva
    protected $fillable = [
        'project_id',
        'user_id',
        'name',
        'start_date',
        'end_date',
        'status',
    ];

    // Relación con el modelo Project (una tarea pertenece a un proyecto)
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    // Relación con el modelo User (una tarea puede estar asignada a un usuario)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Accesor para mostrar el estado como texto
    public function getStatusLabelAttribute()
    {
        return match ($this->status) {
            0 => 'Pendiente',
            1 => 'En Progreso',
            2 => 'Completado',
            default => 'Pendiente',
        };
    }
}
