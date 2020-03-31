<?php
namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait HasClient
{
    public static function bootHasClient()
    {
        static::creating(function($model){
            $model->clientId = Auth::user() ? Auth::user()->clientId : '0' ;
        });
    }
}
