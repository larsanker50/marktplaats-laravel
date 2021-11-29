<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use DB;

class postalcode extends Model
{
    protected $table = "postalcodes";
    use HasFactory;

    public function getPostalcodesByDistance($distance){
        $query = "SELECT id FROM (
            SELECT *, 
                (
                    (
                        (
                            acos(
                                sin(( $this->latitude * pi() / 180))
                                *
                                sin(( `latitude` * pi() / 180)) + cos(( $this->latitude * pi() /180 ))
                                *
                                cos(( `latitude` * pi() / 180)) * cos((( $this->longitude - `longitude`) * pi()/180)))
                        ) * 180/pi()
                    ) * 60 * 1.1515 * 1.609344
                )
            as distance FROM `postalcodes`
        ) postalcodes
        WHERE distance <= $distance;";
        $postalcodesWithinRange = DB::select($query);
        $postalcodeIDs = new Collection();
        foreach($postalcodesWithinRange as $postalcode){
            $postalcodeIDs->push($postalcode->id);
        }
        return $postalcodeIDs;
    }



    public function user() {
        return $this->belongsToMany(User::class);
    }
}
