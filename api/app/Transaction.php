<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ['from','to','details','amount','currency'];
    protected $hidden = ['from','to','id'];

    public function makeTransaction($data)
    {
        return self::create($data);
    }

    public function debited()
    {
        return $this->belongsTo(Account::class,'from');
    }

    public function credited()
    {
        return $this->belongsTo(Account::class,'to');
    }

//    public function sender()
//    {
//        return $this->hasOne(Account::class,'from');
//    }
//
//    public function receiver()
//    {
//        return $this->hasOne(Account::class,'from');
//    }
}
