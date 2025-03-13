<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DeviceController extends Controller
{
    public function turnOn()
    {
        return response()->json(["status" => "Device turned ON"]);
    }

    public function turnOff()
    {
        return response()->json(["status" => "Device turned OFF"]);
    }
}
