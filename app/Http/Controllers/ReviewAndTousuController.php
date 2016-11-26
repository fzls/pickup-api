<?php

namespace PickupApi\Http\Controllers;

use Illuminate\Http\Request;
use PickupApi\Models\User;

class ReviewAndTousuController extends Controller
{
    public function rate(){
        $this->validate(
            $this->request,
            [
                'to'=>'required|integer|exists:users,id',
            ]
        );

        /*TODO: meow*/
    }

    public function tousu(){

    }
}
