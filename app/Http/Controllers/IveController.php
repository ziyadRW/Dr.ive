<?php

namespace App\Http\Controllers;

use App\Features\IveFeature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class IveController extends Controller
{
    public function store(Request $request)
    {
        return (new IveFeature())->store($request);
    }

    public function show($uniqueIdentifier, Request $request)
    {
        return (new IveFeature())->show($uniqueIdentifier, $request);
    }
}
