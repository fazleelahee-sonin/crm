<?php

namespace App\Http\Controllers;

class LogoController extends Controller
{
    public function __invoke($name)
    {
        $location = storage_path('app/public/logo') . '/' . $name;
        if (file_exists($location)) {
            $image = \Image::make($location);
            return $image->response();
        }
        return response()->json([], 404);
    }
}