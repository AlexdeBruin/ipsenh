<?php

namespace App;

use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

/**
 * Class User
 * @package App
 */
class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name','zip_code', 'birthdate', 'address', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $with = [
        'roles'
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function courses(){
        return $this->belongsToMany(Course::class)->withPivot('role', 'showing');
    }

    public function studentInfo(){
        return $this->hasOne(Student_Info::class);
    }

    public function tests(){
        return $this->belongsToMany(Test::class)->withPivot('grade');
    }

    public function authorizeRoles($roles)
    {
        if (is_array($roles)) {
            return $this->hasAnyRole($roles) ?: abort(401, 'This action is unauthorized.');
        }
        return $this->hasRole($roles) ?: abort(401, 'This action is unauthorized.');
    }

    public function hasAnyRole($roles)
    {
        return null !== $this->roles()->whereIn('name', $roles)->first();
    }

    public function hasRole($role)
    {
        return null !== $this->roles()->where('name', $role)->first();
    }
}
