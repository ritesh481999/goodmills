<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens, SoftDeletes;

    protected $fillable = [
        'role_id',
        'name',
        'email',
        'mobile_number',
        'selected_country_id',
        'password',
        'role_id',
        'is_active',
        'fcm_token'
    ];

    protected $hidden = [
        'password',
        'remember_token',
        //'role_id'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function scopeActive($q, $active = true)
    {
        return $q->where('is_active', $active ? '1' : '0');
    }

    public function scopeRole($q, $role)
    {
        return $q->where('role_id', $role);
    }

    public function scopeAdmin($q, $isAdmin = true)
    {
        $adminRoles = [1, 2];

        return $q
            ->when($isAdmin, function ($w) use ($adminRoles) {
                return $w->whereIn('role_id', $adminRoles);
            })
            ->when(!$isAdmin, function ($w) use ($adminRoles) {
                return $w->whereNotIn('role_id', $adminRoles);
            });
    }

    public function getIsSuperAdminAttribute()
    {
        return $this->role_id == config('common.user_role.SUPERADMIN');
    }

    public function getIsFarmerAttribute()
    {
        return $this->role_id == config('common.user_role.FARMER');
    }

    public function roles()
    {
        return $this->belongsTo('App\Models\Role', 'role_id', 'id');
    }

    public function countries()
    {
        return $this->belongsToMany(CountryMaster::class, 'country_user', 'user_id', 'country_id');
    }

    public function selected_country()
    {
        return $this->hasOne('App\Models\CountryMaster', 'id', 'selected_country_id');
    }
}
