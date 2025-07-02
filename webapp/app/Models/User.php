<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_image_path',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function updateProfile(array $data)
    {
        if (isset($data['profile_image_path'])) {
            $this->profile_image_path = $data['profile_image_path'];
        }

        $this->name = $data['name'];
        $this->email = $data['email'];

        $this->save();
    }
}
