<?php

namespace App\Jobs;

use Illuminate\Support\Facades\App;
use Illuminate\Bus\Queueable;
// use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

abstract class DispatchRing implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $obj;
    public $rings;

    public function __construct($data)
    {
        $this->obj = $data['obj'];
        $this->rings = $data['rings'];
    }

    abstract function process();

    public function handle()
    {

        $this->obj = $this->process($this->obj);

        if (count($this->rings)) {
            $next = array_shift($this->rings);

            return dispatch(App::makeWith($next, [
                'data' => [
                    'obj' => $this->obj,
                    'rings' => $this->rings,
                ]
            ]));
        }

        return $this->obj;
    }

    // tendenzialmente serve per early exit da pipe infra $this->process, magari poi si puo' pensare a un modo piu pulito di realizzarlo

    public function exit()
    {
        $this->rings = [];
    }
}
