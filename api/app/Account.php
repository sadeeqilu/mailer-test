<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $fillable = ['name','balance','currency'];
    protected $hidden = ['id'];

    public function createAccount($data)
    {
        return self::create($data);
    }

    public function updateAccount($data,$id)
    {
        $account = self::find($id);
        $account->update($data);
        return $account;
    }

    public function deductFromBalance($account,$amount)
    {
        $account->update(["balance" => $account->balance - $amount]);
        return $account;
    }

    public function addToBalance($account,$amount)
    {
        $account->update(["balance" => $account->balance + $amount]);
        return $account;
    }

    public function debits()
    {
        return $this->hasMany(Transaction::class,'from');
    }

    public function credits()
    {
        return $this->hasMany(Transaction::class,'to');
    }

    public function currency()
    {
        return $this->hasOne(Currency::class);
    }
}
