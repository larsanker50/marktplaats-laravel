<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    public function advertisement() {
        return $this->hasMany(Advertisement::class);
    }

    public function bidding() {
        return $this->hasMany(Bidding::class);
    }

    public function sender() {
        return $this->hasMany(Message::class, 'from_user_id');
    }

    public function receiver() {
        return $this->hasMany(Message::class, 'to_user_id');
    }

}
