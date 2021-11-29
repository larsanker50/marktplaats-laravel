<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class User extends Model implements AuthenticatableContract
{
    use Authenticatable;
    use HasFactory;

    protected $fillable = ['email', 'username', 'password', 'residence', 'postalcode_id'];

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

    public function postalcode() {
        return $this->hasOne(Postalcode::class, 'postalcode_id');
    }


}