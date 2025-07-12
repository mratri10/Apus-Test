<?php

namespace App\Models;


use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Users extends Authenticatable
{
    use HasFactory;

    protected $table = 'users';
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'uuid',
        'name',
        'username',
        'password',
    ];
    protected $hidden = ['password'];

    public function tasks()
    {
        return $this->hasMany(Tasks::class, 'user_id', 'uuid');
    }
    public function positions()
    {
        return $this->belongsToMany(Positions::class, 'user_positions', 'user_id', 'position_id', 'uuid', 'uuid');
    }
}
