<?php

namespace App\Http\Controllers;

use App\Supporters;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function supporters()
    {
        $supporters = array([
            'orga' => array(
                Supporters::getOrgaSupporters()
            ),
            'person' => array(
                Supporters::getPersonSupporters()
            )
        ]);
        return json_encode($supporters);
    }
}
