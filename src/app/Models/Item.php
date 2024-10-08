<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'brand',
        'price',
        'description',
        'seller_id',
        'condition_id',
    ];

    public function user() {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function categories() {
        return $this->belongsToMany(Category::class);
    }

    public function condition() {
        return $this->belongsTo(Condition::class);
    }

    public function itemImages() {
        return $this->hasMany(ItemImage::class);
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }

    public function likes() {
        return $this->hasMany(Like::class);
    }

    public function transaction() {
        return $this->hasOne(Transaction::class);
    }
}
