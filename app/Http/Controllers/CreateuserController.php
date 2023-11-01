<?php

namespace App\Http\Controllers;

use Mail;
use App\Mail\OrderCompleted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\User;
use App\Courses;
use Validator;

class CreateuserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $drivers = User::orderBy('id','desc')->get();
        $count = User::count();
        $courses = Courses::orderBy('id_course','desc')->get();
        $reservations = DB::table('reservations')->get();
        // $result = DB::table('courses_chauffeur')
        //     ->select('courses_chauffeur.id_chauffeur')
        //     ->leftJoin('users','users.name','=','courses_chauffeur.id_chauffeur')
        //     ->get();
        //     $courses = count($result);
        return view('admin.createUser', compact('drivers', 'count', 'courses', 'reservations'));
    }

    public function showInfos($id){
        $driver = User::find($id);
        $courses = Courses::orderBy('id_chauffeur','desc')->get();
        $reservations = DB::table('reservations')->get();
        return view('admin.Userinfos', compact('driver', 'courses', 'reservations'));
    }

    public function toadmin()
    {
        return view('admin.createAdmin');
    }

    public function todriver()
    {
        return view('admin.createDriver');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'fullname' => 'required',
            'username' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'pass' => 'required',
        ]);
        
        if ((User::where('name', '=', Input::get('fullname'))->exists()) || (User::where('email', '=', Input::get('email'))->exists()) ) {
            return redirect('/createAdmin')->with('failed','Utilisateur déjà existé. (Nom ou Email: existait)');
        }
        DB::table('users')->insert(
            [
                'role_id' => $request->get('idrol'), 
                'name' =>$request->get('fullname'),
                'username' =>$request->get('username'),
                'email' =>$request->get('email'),
                'password' =>bcrypt($request->get('pass')),
                'birthday' => '1990-01-01',
                'phone' => $request->get('phone'),
                'nationality' => 'null',
                'immatriculation' => 'null',
                'carmarque' => 'null',
                'carmodel' => 'null',
                'caryear' => 'null',
                'permis' => 'null',
                'vtccarte' => 'null',
                'description' => 'null',
            ]
        );
        return redirect('/createAdmin')->with('status','Utilisateur a été inséré.');
    }
    public function createchauffeur(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'username' => 'required',
            'birthday' => 'required',
            'email' => 'required',
            'password' => 'required',
            'phone' => 'required',
            'nationality' => 'required',
            'immatriculation' => 'required',
            'carmarque' => 'required',
            'carmodel' => 'required',
            'caryear' => 'required',
            'permis' => 'required',
            'vtccarte' => 'required',
        ]);

        if ((User::where('vtccarte', '=', Input::get('vtccarte'))->exists()) || (User::where('email', '=', Input::get('email'))->exists())  || (User::where('permis', '=', Input::get('permis'))->exists())) {
            return redirect('/createDriver')->with('failed','Chauffeur déjà existé. (Permis ou Carte VTC ou Email: existait)');
        }
        DB::table('users')->insert(
            [
                'role_id' => $request->get('idrol'), 
                'name' => $request->get('name'), 
                'username' =>$request->get('username'),
                'birthday' =>$request->get('birthday'),
                'email' =>$request->get('email'),
                'password' =>bcrypt($request->get('password')),
                'phone' =>$request->get('phone'),
                'nationality' =>$request->get('nationality'),
                'immatriculation' =>$request->get('immatriculation'),
                'carmarque' =>$request->get('carmarque'),
                'carmodel' =>$request->get('carmodel'),
                'caryear' =>$request->get('caryear'),
                'permis' =>$request->get('permis'),
                'vtccarte' =>$request->get('vtccarte'),
                'description' =>$request->get('description'),
            ]
        );
        
        //Mail::to($request->user())->send(new OrderCompleted($request->get('name'), $request->get('birthday'), $request->get('email'), $request->get('phone'), $request->get('permis')));
        return redirect('/createDriver')->with('status','Utilisateur a été inséré.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $driver = User::find($id);
        return view('admin.showUser', compact('driver'));
    }

    public function showChauffeur($id)
    {
        $driver = User::find($id);
        return view('admin.showChauffeur', compact('driver'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $driver = User::find($id);
        return view('admin.editUser', compact('driver'));
    }
    
    public function editChauffeur($id)
    {
        $driver = User::find($id);
        return view('admin.editChauffeur', compact('driver'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $user->name = $request->nameUser;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->phone = $request->phone;

        $user->save();

        return redirect('/createUser')->with('status','Utilisateur a été mis à jour');
    }

    public function updateChauffeur(Request $request, $id)
    {
        $user = User::find($id);
        $user->name = $request->nameUser;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->phone = $request->phone;
        $user->immatriculation = $request->immatriculation;
        $user->carmarque = $request->carmarque;
        $user->carmodel = $request->carmodel;
        $user->caryear = $request->caryear;
        $user->permis = $request->permistype;
        $user->vtccarte = $request->vtccarte;

        $user->save();

        return redirect('/createUser')->with('status','Utilisateur a été mis à jour');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $driver = User::find($id);
        $driver->delete();

        return redirect('/createUser')->with('status','Utilisateur a été supprimé');
    }

    public function destroyChauffeur($id)
    {
        $driver = User::find($id);
        $driver->delete();

        return redirect('/createUser')->with('status','Utilisateur a été supprimé');
    }
}
