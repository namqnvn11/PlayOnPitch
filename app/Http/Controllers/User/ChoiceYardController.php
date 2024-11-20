<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ChoiceYardController extends Controller
{
    public function index(){
        return view('user.choice_yard.index');
    }
}
