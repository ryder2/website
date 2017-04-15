<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Review;

class User extends Authenticatable
{
    use Notifiable;

    public function reviews()
    {
        return $this->hasMany(Review::class, 'mecano_id', 'id');
    }

    public function recalculateRating()
    {
        $reviews = $this->reviews()->notSpam()->approved();
        $avgRating = $reviews->avg('rating');
        $this->rating_cache = round($avgRating,1);
        $this->rating_count = $reviews->count();
        $this->save();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'rue', 'codepostal', 'ville', 'province', 'pays', 'mecano'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
