<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'store_id',
        'role',
        'customer_group_id',
        'is_admin',
        'phone',
        'status',
        'locale',
        'currency',
        'custom_attributes',
    ];

    protected $casts = [
        'custom_attributes' => 'array',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function addresses()
    {
        return $this->hasMany(UserAddress::class);
    }

    public function shippingAddress()
    {
        return $this->hasOne(UserAddress::class)->where('type', 'shipping');
    }

    public function billingAddress()
    {
        return $this->hasOne(UserAddress::class)->where('type', 'billing');
    }

    // Optional helper for convenience
    public function getAddressByType($type)
    {
        return $this->addresses->where('type', $type)->first();
    }
    
    public function customerGroup()
    {
        return $this->belongsTo(CustomerGroup::class);
    }

    public function wishlist()
    {
        return $this->hasMany(Wishlist::class);
    }
}
