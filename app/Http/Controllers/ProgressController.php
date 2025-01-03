<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Services;

class ProgressController extends Controller
{
    public function index(Request $request)
    {
        // dd($request->all());
        $services_id = $request->input('services-id');
        $services = Services::where('services_id', $services_id)->first();
        // dd($services);
        $name = $services->customer->name;
        $status = $services->status;
        // dd($status);
        return view('progress', compact('services'));
    }
}
