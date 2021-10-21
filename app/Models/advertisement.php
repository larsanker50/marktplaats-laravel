<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'body', 'status', 'premium', 'user_id'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function rubric() {
        return $this->belongsToMany(Rubric::class);
    }

    public function bidding() {
        return $this->hasMany(Bidding::class);
    }

}
