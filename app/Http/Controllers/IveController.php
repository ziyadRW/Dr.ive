<?php

namespace App\Http\Controllers;

use App\Features\IveFeature;
use Illuminate\Http\Request;

class IveController extends Controller
{
    public function store(Request $request)
    {
        return (new IveFeature())->store($request);
    }

    public function show($id)
    {
        return (new IveFeature())->show($id);
    }
}
