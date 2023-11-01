<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class GlobalFunctions extends Controller
{
    public static function globalController1(){
        $status = Pagestatus::all();
        return $status;
    }

    public static function globalNotification(){
        $notif = "0";
        return $notif;
    }
    public function pagestatus(Request $request, $id){
        $categories = Pagestatus::find($id);
        $categories->status = $request->statusid;
        $categories->save();

        return redirect('/crm/dashboard');
    }
}
