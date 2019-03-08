<?php

namespace App\Http\Controllers;

use App\Supporters;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ApiController extends Controller
{
    public function supporters()
    {
        $supporters = array([
            'orga' => Supporters::getOrgaSupporters(),
            'person' => Supporters::getPersonSupporters()
        ]);
        return response()->json($supporters)
            ->withHeaders([
                'Cache-Control' => 'public, must-revalidate, max-age=3600',
                'Access-Control-Allow-Origin' => '*',
                'Access-Control-Allow-Methods' => 'GET, POST, PUT, DELETE, OPTIONS'
            ]);
    }
}
