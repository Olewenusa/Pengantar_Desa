<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class resident extends Model
{
    protected $table = "residents";

    protected $guarded = [
        'user_id',
        'rt',
        'rw'
    ];

     public function user()
{
    return $this->belongsTo(User::class);
}

}



