<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AuthModel extends Model
{
    use Notifiable;

    protected $table = 'user'; 
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'Name',
        'Email',
        'Password',
        'ReferralCode',
        'Active',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Mutator to automatically hash the password when setting it.
     *
     * @param string $password
     * @return void
     */
    public function setPasswordAttribute($password)
    {
        // Hash the password using bcrypt before saving
        $this->attributes['password'] = Hash::make($password);
    }

}
