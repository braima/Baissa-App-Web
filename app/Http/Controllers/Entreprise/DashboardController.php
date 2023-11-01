<?php

namespace App\Http\Controllers\Entreprise;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Validator;


class DashboardController extends Controller
{
    public function index(){
        return view('thirdeditor.dashboard');
    }
    
}
