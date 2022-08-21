<?php

namespace App\Jobs;

use Illuminate\Support\Facades\App;

class DispatchChainer

{
    public  static function dispatch($obj, array $rings)
    {
        $next = array_shift($rings);

        dispatch(App::makeWith($next, [
            'data' => [
                'obj' => $obj,
                'rings' => $rings,
            ]
        ]));
    }
}
