<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ErrorController extends Controller
{
    public function show($code)
    {
        $validCodes = [
            401,
            402,
            403,
            404,
            419,
            429,
            500,
            503
        ];

        if (!in_array($code, $validCodes)) {
            abort(404);
        }

        return response()
            ->view("errors.{$code}", [], $code);
    }
}
