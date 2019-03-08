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
        Response::header('Cache-Control', 'public, must-revalidate, max-age=3600');
        return response()->json($supporters);
    }
}
