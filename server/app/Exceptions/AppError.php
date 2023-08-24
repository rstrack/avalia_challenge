<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AppError extends Exception
{
    public $msg;
    public function __construct($msg){
        $this->msg = $msg;
    }

    public function render(Request $request): Response
    {
        $status = 422;

        return response(["errors" => true, "message" => $this->msg], $status);
    }
}