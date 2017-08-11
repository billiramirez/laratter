<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'avatar', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function messages()
    {
        return $this->hasMany(Message::class)->orderBy('created_at', 'desc');
    }

    public function follows()
    {
//        This function is to find the user that a user follow
//        table + foreign + related
//        Tell me all the users that I follow

        return $this->belongsToMany(User::class,'followers','user_id','followed_id');
    }

//    I am the followed, tell me all the users who are following me.

    public function followers()
    {
        return $this->belongsToMany(User::class,'followers','followed_id', 'user_id');
    }

    public function isFollowing($user)
    {
        return $this->follows->contains($user);/** We check if a user follow another user, return a boolean**/
    }

    public function socialProfiles()
    {
        return $this->hasMany(SocialProfile::class);
    }

}