<?php

namespace App\Traits;

use App\Scopes\ClientScope;

trait HasClientScope
{
    protected static function boot()
        {
            parent::boot();
            static::addGlobalScope(new ClientScope);
        }
}
