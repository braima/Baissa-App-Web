<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Activities;
use View;
class DashboardController extends Controller
{
    public function index(){
        return View::make('admin.dashboard');
    }

    public function dashboardweb(){
        $seances = DB::table('seances')->get();
        $seanceshistory = DB::table('seanceshistory')->get();
        $clients = DB::table('clients')->get();
        $packages = DB::table('seancepackages')->get();
        return view('admin.dashboardweb', compact('seances','clients','packages','seanceshistory'));
    }

    public function centerdashboard(){
        $seances = DB::table('seances')->get();
        $seanceshistory = DB::table('seanceshistory')->get();
        $clients = DB::table('clients')->get();
        $packages = DB::table('seancepackages')->get();
        return view('admin.centerdashboard', compact('seances','clients','packages','seanceshistory'));
    }

    public function dashboardadmin(){
        $seances = DB::table('seances')->get();
        $seanceshistory = DB::table('seanceshistory')->get();
        $clients = DB::table('clients')->get();
        $packages = DB::table('seancepackages')->get();
        return view('admin.dashboardadmin', compact('seances','clients','packages','seanceshistory'));
    }

    public function utilisateurs(){
        $users = DB::table('users')->get();
        return view('admin.utilisateurs', compact('users'));
    }

    public function createuser(Request $request){
        $checkusers = User::all();
        
        DB::table('users')->insert([
            'role_id' => $request->get('roleuser'),
            'subuser_id' => $request->get('subuser_id'),
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'emplacement' => $request->get('emplacement'),
            'password' => bcrypt($request->get('password')),
        ]);

        $role = '';
            if($request->get('roleuser') == 1){
                $role = 'Admin';
            }else{
                $role = 'Utilisateur';
            }

        $activities = new Activities;
        $activities->log_name = 'User';
        $activities->description = 'Account Inserted';
        $activities->subject_id = '1';
        $activities->subject_type = 'App\User';
        $activities->causer_id = \Auth::user()->id;
        $activities->causer_type = 'App\User';
        $activities->properties = ' Name: '.$request->get('name'). ', E-mail: ' .$request->get('email'). ', Role: '.$role;
        $activities->save(); 

        return redirect('/crm/utilisateurs')->with('status','Utilisateur Ajouté avec succès.');
    }

    public function destroyuser($id){
        $users = User::find($id);
        $checkusers = User::all();
        
        $name = '';
        foreach($checkusers as $user){
            if($user->id == $id){
                $name = $user->name;
            }
        }
        $activities = new Activities;
        $activities->log_name = 'User';
        $activities->description = 'Account Deleted';
        $activities->subject_id = '1';
        $activities->subject_type = 'App\User';
        $activities->causer_id = \Auth::user()->id;
        $activities->causer_type = 'App\User';
        $activities->properties = 'ID: ' . $id .', Name: '.$name;
        $activities->save(); 

        $users->delete();
        return redirect('/crm/utilisateurs')->with('status','Utilisateur Supprimé avec succès.');
    }
    
    public function updateuser(Request $request, $id){         
        $obj_user = User::find($id);
        $obj_user->name =  $request->nom;
        $obj_user->email =  $request->email;
        $obj_user->password = Hash::make($request['password']);;
        $obj_user->save();  

        $activities = new Activities;
        $activities->log_name = 'User';
        $activities->description = 'Password Updated';
        $activities->subject_id = '1';
        $activities->subject_type = 'App\User';
        $activities->causer_id = \Auth::user()->id;
        $activities->causer_type = 'App\User';
        $activities->properties = 'ID: ' . $id .', Name: '.$request->nom;
        $activities->save(); 

        return redirect('/crm/utilisateurs')->with('status','Utilisateur Modifié avec succès.');
    }
}
