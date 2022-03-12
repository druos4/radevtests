<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    protected $table = 'tests';

    protected $dates = [
        'updated_at',
        'created_at'
    ];

    protected $fillable = [
        'fio',
        'day',
        'location',
        'mark',
        'criteria',
        'user_id',
    ];

    public function manager()
    {
        return $this->belongsTo(User::class,'user_id');
    }

}
