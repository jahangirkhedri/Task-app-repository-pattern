<?php

namespace App\Http\Facades;

use App\Http\Responses\ApiResponses;
use Illuminate\Support\Facades\Facade;

class ResponseFacade extends Facade
{
    public static function getFacadeAccessor()
    {
        return ApiResponses::class; // we can change to HtmlResponses
    }

}
