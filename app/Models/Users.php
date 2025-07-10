<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    use HasFactory;

    protected $table = 'users';
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'username',
        'password',
    ];
    protected $hidden =['password',];

    public function tasks(){
        return $this->hasMany(Tasks::class, 'user_id','uuid');
    }
    public function positions(){
        return $this->belongsToMany(Positions::class, 'user_positions', 'user_id', 'position_id', 'uuid', 'uuid');
    }

}
