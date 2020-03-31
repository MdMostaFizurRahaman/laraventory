<?php
namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait Historyable
{
    public static function bootHistoryable()
    {
        static::creating(function($model){
            $model->createdBy = Auth::user() ? Auth::user()->id : '0';
            $model->clientId = Auth::user() ? Auth::user()->clientId : '0';
        });

        static::updating(function($model){
            $model->updatedBy = Auth::user()->id;
        });

        static::deleting(function($model){
            $model->deleteBy = Auth::user()->id;
            $model->save();
        });

    }
}
