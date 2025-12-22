<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
        ];
    }

    /**
     * Relación muchos a muchos con módulos (asignación directa)
     */
    public function modules()
    {
        return $this->belongsToMany(Module::class, 'user_module')
                    ->withTimestamps();
    }

    /**
     * Obtener los módulos accesibles para el usuario
     * Si es admin, tiene acceso a todos los módulos
     * Si no es admin, solo tiene acceso a los módulos asignados directamente
     */
    public function getAccessibleModules()
    {
        // Si es administrador, tiene acceso a todos los módulos activos
        if ($this->is_admin) {
            return Module::where('is_active', true)->orderBy('order')->get();
        }
        
        // Si no es admin, solo tiene acceso a los módulos asignados directamente
        return $this->modules()->where('is_active', true)->orderBy('order')->get();
    }
    
    /**
     * Verificar si el usuario tiene acceso a un módulo específico
     */
    public function hasAccessToModule($moduleSlug)
    {
        return $this->getAccessibleModules()->contains('slug', $moduleSlug);
    }
}
