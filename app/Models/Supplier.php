<?php

namespace App\Models;


use App\Traits\Historyable;
use App\Models\BaseModel as Model;

class Supplier extends Model
{
    use Historyable;
    protected $guarded=[];

}
