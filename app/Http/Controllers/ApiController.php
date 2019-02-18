<?php

namespace App\Http\Controllers;

use App\Supporters;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function supporters()
    {
        $supporters = array([
            'orga' => Supporters::getOrgaSupporters(),
            'person' => Supporters::getPersonSupporters()
        ]);
        return json_encode($supporters);
    }
}
