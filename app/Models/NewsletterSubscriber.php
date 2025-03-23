<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsletterSubscriber extends Model
{
    protected $fillable = ['user_id', 'email', 'is_subscribed', 'subscribed_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
