<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\User;
use Auth;

class Review extends Model
{

  public function user()
  {
    return $this->belongsTo(User::class, 'user_id', 'id');
  }

  public function product()
  {
    return $this->belongsTo(User::class, 'mecano_id', 'id');
  }

  public function scopeApproved($query)
  {
    return $query->where('approved', true);
  }

  public function scopeSpam($query)
  {
    return $query->where('spam', true);
  }

  public function scopeNotSpam($query)
  {
    return $query->where('spam', false);
  }

  public function storeReviewForProduct($productID, $comment, $rating)
  {
    $product = User::find($productID);

    // this will be added when we add user's login functionality
    $this->user_id = Auth::user()->id;

    $this->comment = $comment;
    $this->rating = $rating;
    $product->reviews()->save($this);

    // recalculate ratings for the specified product
    $product->recalculateRating();
  }
}
