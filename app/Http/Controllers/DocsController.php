<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DocsController extends Controller
{
    public function show($page = 'getting-started')
    {
        $viewName = 'docs.' . str_replace('/', '.', $page);

        if (!view()->exists($viewName)) {
            abort(404);
        }

        return view($viewName);
    }
}
