<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Activities;
use App\User;
use App\Rendezvous;
use App\Categories;
use App\Seances;
use App\SeanceServices;
use App\Packages;
use App\Products;
use App\PvProducts;
use App\seancesHistory;
use App\Personnel;
use App\Clients;
use App\Commandes;
use App\Commandesproduits;
use App\CommandesPV;
use Carbon\Carbon;
use Validator;
use File;
use Mail;

use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\Printer; 
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\PrintBuffers\ImagePrintBuffer;
use Mike42\Escpos\GdEscposImage;

// use Mike42\Escpos;
// use Mike42\Escpos\Printer;
// use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
// use Mike42\Escpos\PrintConnectors\FilePrintConnector;
// use Mike42\Escpos\PrintBuffers\ImagePrintBuffer;
// use Mike42\Escpos\CapabilityProfiles\DefaultCapabilityProfile;
// use Mike42\Escpos\CapabilityProfiles\SimpleCapabilityProfile;


class OperationsController extends Controller
{
    /* ************************ RDV ********************* */
    public function newrendezvous(){
        $seances = DB::table('seances')->get();
        $employer = DB::table('employer')->get();
        $packages = DB::table('seancepackages')->get();
        $produits = DB::table('produits')->get();
        $seanceshistory = DB::table('seanceshistory')->get();
        $rendezvous = DB::table('rendezvous')->get();
        return view('admin.rendezvous', compact('seances','employer','packages','produits','seanceshistory','rendezvous'));
    }
    public function rendezvousvalidates(){
        $rendezvous = DB::table('rendezvous')->get();
        return view('admin.rendezvousvalidated', compact('rendezvous'));
    }
    public function rendezvousannule(){
        $rendezvous = DB::table('rendezvous')->get();
        return view('admin.rendezvousannule', compact('rendezvous'));
    }

    public function switchrdvtoseance($id){
        $rdv = Rendezvous::find($id);
        $employer = DB::table('employer')->get();
        $packages = DB::table('seancepackages')->get();
        return view('admin.rdvtoseance', compact('employer','packages','rdv'));
    }
    // Operations
    public function insertrdv(Request $request){
        $rdv = new Rendezvous();
        $client= new Clients();
        $inputrdv = Input::all();

        $rdv->name = $inputrdv['fullname'];
        $rdv->email = $inputrdv['email'];
        $rdv->phone = $inputrdv['phone'];
        $rdv->ville = $inputrdv['ville'];
        $rdv->service = $inputrdv['service'];
        $rdv->statut = 0;
        $rdv->save();

        $client->name = $inputrdv['fullname'];
        $client->email = $inputrdv['email'];
        $client->phone = $inputrdv['phone'];
        $client->ville = $inputrdv['ville'];
        $client->save();

        return redirect('/crm/rendezvous')->with('status','Le Rendez-vous est inséré avec succès.');

    }
    public function switchtoseance($id){
        $seance = new Seances();
        $seance->name = Input::get('name');
        $seance->package = Input::get('package');
        $seance->price = Input::get('price');
        $seance->employer = Input::get('employer');
        $seance->nbrseance = Input::get('nbrseance');
        $seance->avancement = Input::get('avancement');
        $seance->date = Input::get('dateseance');
        $seance->time = Input::get('time');
        $seance->nbreffectue = 1;
        $seance->status = 0;
        $seance->save();
        
        $id_seance = DB::table('seances')->select('id')->where('name',Input::get('name'))->latest()->first()->id;

        $seancehistory = new seancesHistory();
        $seancehistory->date = Carbon::now();
        $seancehistory->seance_id = $id_seance;
        $seancehistory->dateseance = Input::get('dateseance');
        $seancehistory->timeseance = Input::get('time');
        $seancehistory->employer = Input::get('employer');
        $seancehistory->avance = Input::get('avancement');
        $seancehistory->nbreffectue = 1;
        $seancehistory->save();
        
        $activities = new Activities;
        $activities->log_name = 'Seances';
        $activities->description = 'Seances - Process Insertion ';
        $activities->subject_id = 0;
        $activities->subject_type = 'App\Seances';
        $activities->causer_id = \Auth::user()->id;
        $activities->causer_type = 'App\User';
        $activities->properties = ' Seance pour: '.Input::get('name');
        $activities->save(); 

        $rdv = Rendezvous::find($id);
        $rdv->statut = '1';
        $rdv->save();

        return redirect('/crm/rendezvous')->with('status','Le Rendez-vous est inséré avec succès.');
    }
    public function cancelrdv($id){
        $rdv = Rendezvous::find($id);

        $activities = new Activities;
        $activities->log_name = 'RDV';
        $activities->description = 'RDV - Process du Annulation ';
        $activities->subject_id = $id;
        $activities->subject_type = 'App\RDV';
        $activities->causer_id = \Auth::user()->id;
        $activities->causer_type = 'App\User';
        $activities->properties = ' RDV ID: '.$id;
        $activities->save();        

        $rdv->statut = '2';
        $rdv->save();
        return redirect('/crm/rendezvousannule')->with('status','RDV annulé avec succès.');
    }
    public function updaterdv(Request $request, $id){
        $rdv = Rendezvous::find($id);

        $activities = new Activities;
        $activities->log_name = 'RDV';
        $activities->description = 'RDV - Process du Modification ';
        $activities->subject_id = $id;
        $activities->subject_type = 'App\RDV';
        $activities->causer_id = \Auth::user()->id;
        $activities->causer_type = 'App\User';
        $activities->properties = ' RDV ID: '.$id;
        $activities->save();        

        $rdv->name = $request->get('name');
        $rdv->email = $request->get('email');
        $rdv->phone = $request->get('phone');
        $rdv->datetime = $request->get('datetime');
        $rdv->object = $request->get('objet');
        $rdv->description = $request->get('message');
        $rdv->statut = '0';
        $rdv->save();
        return redirect('/crm/rendezvous')->with('status','RDV Modifié avec succès.');
    }
    public function destroyrdv($id){
        $rdv = Rendezvous::find($id);        
        
        $activities = new Activities;
        $activities->log_name = 'RDV';
        $activities->description = 'RDV - Process du Suppression ';
        $activities->subject_id = $id;
        $activities->subject_type = 'App\RDV';
        $activities->causer_id = \Auth::user()->id;
        $activities->causer_type = 'App\User';
        $activities->properties = ' RDV ID: '.$id;
        $activities->save();   

        $rdv->delete();
        return redirect('/crm/rendezvous')->with('status','RDV supprimé avec succès.');
    }
    
    /* ************************ CATEGORIES ********************* */
    public function categories(){
        $categories = DB::table('category')->get();
        return view('admin.categories', compact('categories'));
    }

    public function insertcategory(){
        $category = new Categories();
        $category->label = Input::get('label');
        $category->ordre = Input::get('order');
        $category->status = Input::get('status');
        
        $activities = new Activities;
        $activities->log_name = 'Categorie';
        $activities->description = 'Categorie - Process Insertion ';
        $activities->subject_id = 0;
        $activities->subject_type = 'App\Categorie';
        $activities->causer_id = \Auth::user()->id;
        $activities->causer_type = 'App\User';
        $activities->properties = ' Categorie ID: '.Input::get('label');
        $activities->save(); 

        $category->save();
        return redirect('/crm/categories')->with('status','Catégorie ajouté avec succès.');
    }

    public function updatecategory($id){ 
        $category = Categories::find($id);  

        if(Categories::where('ordre', '=', Input::get('order'))->exists()) {
            return redirect('/crm/categories')->with('failed','Ordre de la Catégorie existant.');
        }else{
            $category->label = Input::get('label');
            $category->ordre = Input::get('order');
            $category->status = Input::get('status');
            $category->save();

            $activities = new Activities;
            $activities->log_name = 'Categorie';
            $activities->description = 'Categorie - Process Modification ';
            $activities->subject_id = 0;
            $activities->subject_type = 'App\Categorie';
            $activities->causer_id = \Auth::user()->id;
            $activities->causer_type = 'App\User';
            $activities->properties = ' Categorie Designation: '.Input::get('label');
            $activities->save(); 
        }

        return redirect('/crm/categories')->with('status','Catégorie modifié avec succès.');
    }

    public function categorystatus($id){ 
        $category = Categories::find($id);  
        $category->status = Input::get('statustochange');
        $category->save();

        $activities = new Activities;
        $activities->log_name = 'Categorie';
        $activities->description = 'Categorie - Process Modification ';
        $activities->subject_id = 0;
        $activities->subject_type = 'App\Categorie';
        $activities->causer_id = \Auth::user()->id;
        $activities->causer_type = 'App\User';
        $activities->properties = ' Categorie Designation: '.Input::get('label');
        $activities->save(); 
        
        return redirect('/crm/categories')->with('status','Status modifié avec succès.');
    }

    public function destroycategory($id){
        $Categorie = Categories::find($id);        
        
        $activities = new Activities;
        $activities->log_name = 'Categorie';
        $activities->description = 'Categorie - Process du Suppression ';
        $activities->subject_id = $id;
        $activities->subject_type = 'App\Categorie';
        $activities->causer_id = \Auth::user()->id;
        $activities->causer_type = 'App\User';
        $activities->properties = ' Categorie ID: '.$id;
        $activities->save();   

        $Categorie->delete();
        return redirect('/crm/categories')->with('status','Categorie supprimé avec succès.');
    }

    /* ************************ SEANCES ********************* */
    public function seances(){
        $seances = DB::table('seances')->get();
        $employer = DB::table('employer')->get();
        $packages = DB::table('seancepackages')->get();
        $produits = DB::table('produits')->get();
        $seanceshistory = DB::table('seanceshistory')->get();
        return view('admin.seances', compact('seances','employer','packages','produits','seanceshistory'));
    }

    public function gotoinsert(){
        $seances = DB::table('seances')->get();
        $employer = DB::table('employer')->get();
        $packages = DB::table('seancepackages')->get();
        $produits = DB::table('produits')->get();
        $seanceshistory = DB::table('seanceshistory')->get();
        return view('admin.seancesinsert', compact('seances','employer','packages','produits','seanceshistory'));
    }

    public function seancesdemo(){
        $seances = DB::table('seances')->get();
        $employer = DB::table('employer')->get();
        $packages = DB::table('seancepackages')->get();
        $produits = DB::table('produits')->get();
        $seanceshistory = DB::table('seanceshistory')->get();
        return view('admin.seancesinsertdemo', compact('seances','employer','packages','produits','seanceshistory'));
    }

    public function seancesemploye(){
        $seances = DB::table('seances')->get();
        $employer = DB::table('employer')->get();
        $seanceservices = DB::table('seanceservices')->get();
        
        return view('admin.seancesemploye', compact('seances','employer','seanceservices'));
    }

    public function seancestickets(){
        $seances = DB::table('seances')->get();
        $employer = DB::table('employer')->get();
        $packages = DB::table('seancepackages')->get();
        $produits = DB::table('produits')->get();
        $seanceshistory = DB::table('seanceshistory')->get();
        return view('admin.seancestickets', compact('seances','employer','packages','produits','seanceshistory'));
    }

    public function seancescalendraie(){
        $seances = DB::table('seances')->get();
        $employer = DB::table('employer')->get();
        $packages = DB::table('seancepackages')->get();
        return view('admin.seancescalendraie', compact('seances','employer','packages'));
    }

    public function releveencours(){
        $seances = DB::table('seances')->get();
        $employer = DB::table('employer')->get();
        $packages = DB::table('seancepackages')->get();
        $produits = DB::table('produits')->get();
        $seanceshistory = DB::table('seanceshistory')->get();
        return view('admin.seancesreleveencours', compact('seances','employer','packages','produits','seanceshistory'));
    }

    public function seanceseffectue(){
        $seances = DB::table('seances')->get();
        return view('admin.seanceseffecttuees', compact('seances'));
    }

    public function seancesannules(){
        $seances = DB::table('seances')->get();
        return view('admin.seancesannules', compact('seances'));
    }

    public function seanceshistories($id){
        $seances = Seances::find($id);
        $employer = DB::table('employer')->get();
        $packages = DB::table('seancepackages')->get();
        $employer = DB::table('employer')->get();
        // $produits = DB::table('produits')->get();

        $seanceshistory = DB::table('seanceshistory')
        ->where('seance_id', '=', $id)
        ->select('*')
        ->get();

        $seancespackages = DB::table('seanceservices')
        ->where('id_seance', '=', $id)
        ->select('*')
        ->get();

        $services = DB::table('seanceservices')
        ->where('id_seance', '=', $id)
        ->select('*')
        ->get();

        return view('admin.seanceshistories', compact('seances','employer','packages','seanceshistory','services','seancespackages'));
    }

    public function insertseance(Request $request){
        $inputseance = Input::all();

        $seance = new Seances();
        $seance->name = $inputseance['name'];
        $seance->phone = $inputseance['phone'];
        // $seance->employer = $inputseance['employer'];
        $seance->nbrseance = $inputseance['nbrseance'];
        $seance->price = $inputseance['totalprice'];
        $seance->avancement = $inputseance['avancement'];
        $seance->modepaiement = $inputseance['modepaiement'];
        $seance->date = $inputseance['dateseance'];
        $seance->time = $inputseance['time'];
        $seance->nbreffectue = $inputseance['nbrseance'];
        $seance->emplacement = $inputseance['emplacement'];
        $seance->status = 0;
        $seance->save();
        
        $seanceid = DB::table('seances')->select('id')->where('phone',Input::get('phone'))->latest()->first()->id;

        $input = Input::all();
        $condition = $input['package'];
        foreach($condition as $key => $condition) {
            $service = new SeanceServices;
            $service->id_seance = $seanceid;
            $service->service = $input['service'][$key];
            $service->package = $input['package'][$key];
            $service->price = $input['price'][$key];
            $service->employer = $input['employer'][$key];
            $service->save();
        }      
        
        $inputsh = Input::all();
        $conditiondt = $inputsh['package'];
        foreach($conditiondt as $key => $conditiondt) {
            $seancehistory = new seancesHistory;
            $seancehistory->date = Carbon::now();
            $seancehistory->timeseance = $inputsh['time'];
            $seancehistory->seance_id = $seanceid;
            $seancehistory->dateseance = $inputsh['dateseance'];
            $seancehistory->avance = $inputsh['avancement'];
            $seancehistory->employer = $inputsh['employer'][$key];
            $seancehistory->nbreffectue += 1;
            $seancehistory->save();
        }    
        
        if($seance->price == $seance->avancement){
            $seance->status = 1;
            $seance->save();
        }

        if(Rendezvous::where('id', '=', Input::get('rdvid'))->exists()){
            $rdv = Rendezvous::find(Input::get('rdvid'));  
            $rdv->statut = 1;
            $rdv->save();
        }

        if($seance->status == 1){
            return redirect('/crm/seanceseffectue')->with('status','Seance ajouté avec succès.');
        }else{
            return redirect('/crm/seances')->with('status','Seance ajouté avec succès.');
        }

    }

    /* -------------------------------------------------------------------------- */

    public function setnewseancedemo(Request $request){
        $inputseance = Input::all();

        $seance = new Seances();
        $seance->name = $inputseance['name'];
        $seance->phone = $inputseance['phone'];
        // $seance->employer = $inputseance['employer'];
        $seance->nbrseance = $inputseance['nbrseance'];
        $seance->price = $inputseance['totalprice'];
        $seance->avancement = $inputseance['avancement'];
        $seance->modepaiement = $inputseance['modepaiement'];
        $seance->date = $inputseance['dateseance'];
        $seance->time = $inputseance['time'];
        $seance->nbreffectue = $inputseance['nbrseance'];
        $seance->emplacement = $inputseance['emplacement'];
        $seance->status = 0;
        $seance->save();
        
        $seanceid = DB::table('seances')->select('id')->where('phone',Input::get('phone'))->latest()->first()->id;

        $input = Input::all();
        $condition = $input['package'];
        foreach($condition as $key => $condition) {
            $service = new SeanceServices;
            $service->id_seance = $seanceid;
            $service->service = $input['service'][$key];
            $service->package = $input['package'][$key];
            $service->price = $input['price'][$key];
            $service->employer = $input['employer'][$key];
            $service->save();
        }      
        
        $inputsh = Input::all();
        $conditiondt = $inputsh['package'];
        foreach($conditiondt as $key => $conditiondt) {
            $seancehistory = new seancesHistory;
            $seancehistory->date = Carbon::now();
            $seancehistory->timeseance = $inputsh['time'];
            $seancehistory->seance_id = $seanceid;
            $seancehistory->dateseance = $inputsh['dateseance'];
            $seancehistory->avance = $inputsh['avancement'];
            $seancehistory->employer = $inputsh['employer'][$key];
            $seancehistory->nbreffectue += 1;
            $seancehistory->save();
        }    
        
        if($seance->price == $seance->avancement){
            $seance->status = 1;
            $seance->save();
        }

        if(Rendezvous::where('id', '=', Input::get('rdvid'))->exists()){
            $rdv = Rendezvous::find(Input::get('rdvid'));  
            $rdv->statut = 1;
            $rdv->save();
        }

        // PRINT TICKET

        // try {          

        //     $connector = new NetworkPrintConnector("192.168.1.111", 9100);
            
        //     $printer = new Printer($connector);

        //     $date = Carbon::now();

        //     /* Start the printer */
        //     $printer = new Printer($connector);

        //     /* Print top logo */
        //     $printer -> setJustification(Printer::JUSTIFY_CENTER);

        //     /* Name of shop */
        //     $printer -> selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
        //     $printer -> text("Baissa Shop.\n");
        //     $printer -> selectPrintMode();
        //     $printer -> text("Vente No. $idcmdpv\n");
        //     $printer -> feed(); 

        //     /* Title of receipt */
        //     $printer -> setEmphasis(true);
        //     $printer -> text("FACTURE DE VENTE\n\n");
        //     $printer -> setEmphasis(false);

        //     $lineTotal = sprintf('%-25.40s %6.05s %13.40s','Designation.','Prix U.', 'Quantite');
        //     $printer -> text("$lineTotal\n");
            
        //     $linebuttom = sprintf('%20.40s','================================================');
        //     $printer -> text("$linebuttom\n");

        //     foreach($request->label as $key => $v){
        //         $data =array(
        //             $line = sprintf('%-25.40s %4.0f %13.2f', "Mon designation", "133", "20"), 
        //             $printer -> text("$line\n"),
        //         );
        //     }
            
        //     $printer -> feed();
        //     $printer -> text("\n\n");       
            
        //     $linebuttomline = sprintf('%20.40s','------------------------------------------------');
        //     $printer -> text("$linebuttomline\n");

        //     /* Tax and total */
        //     $lineallTotal = sprintf('%30.30s %-1.05s %13.40s','Prix Total.','=', $request->get('grand_total') .' Dhs');
        //     $printer -> text("$lineallTotal\n");

        //     /* Footer */
        //     $printer -> feed(2);
        //     $printer -> setJustification(Printer::JUSTIFY_CENTER);
        //     $printer -> text("Merci d'avoir visité chez Baissa\n");
        //     $printer -> text("www.baissa.com\n");
        //     $printer -> feed(2);
        //     $printer -> text($date . "\n");

        //     /* Cut the receipt and open the cash drawer */
        //     $printer -> cut();
        //     $printer -> pulse();

        //     $printer -> close();

        //     return redirect('/crm/seancesdm')->with('status','Seance ajouté avec succès.');

        // } catch(Exception $e) {
        //     return redirect('/crm/seancesdm')->with('status','Couldnt print to this printer: ' . $e -> getMessage());
        // }


        if($seance->status == 1){
            return redirect('/crm/seanceseffectue')->with('status','Seance ajouté avec succès.');
        }else{
            return redirect('/crm/seances')->with('status','Seance ajouté avec succès.');
        }

    }

    /* -------------------------------------------------------------------------- */

    public function validateseances($id){ 
        $seances = Seances::find($id); 
        if($seances->price == $seances->avancement){
            $seances->status = 1;
            $seances->save();
            return redirect('/crm/seances')->with('status','Seance validé avec succès.');
        }else{
            return redirect('/crm/seances')->with('warning','Seance Non validé ! Vérifier le montant !');
        }
        

    }

    public function updateseance($id){ 
        $seances = Seances::find($id);  

        $seances->name = Input::get('client');
        $seances->phone = Input::get('phone');
        $seances->date = Input::get('dateseance');
        $seances->time = Input::get('time');
        $seances->save();

        $activities = new Activities;
        $activities->log_name = 'Seances';
        $activities->description = 'Séances - Process Modification ';
        $activities->subject_id = 0;
        $activities->subject_type = 'App\Seances';
        $activities->causer_id = \Auth::user()->id;
        $activities->causer_type = 'App\User';
        $activities->properties = ' Seances ID: '.$id;
        $activities->save(); 
            
        return redirect('/crm/seances')->with('status','Seance modifié avec succès.');
    }
    
    public function updateseancehistory($id){ 

        $seancehistory = new seancesHistory();
        $seancehistory->date = Carbon::now();
        $seancehistory->seance_id = $id;
        $seancehistory->dateseance = Input::get('dateseance');
        $seancehistory->timeseance = Input::get('time');
        $seancehistory->employer = Input::get('employer');
        $seancehistory->avance = Input::get('avancement');
        $seancehistory->nbreffectue = Input::get('nbrseance');
        $seancehistory->save();

        $seances = Seances::find($id);
        $seances->avancement += Input::get('avancement');
        $seances->nbreffectue = Input::get('nbrseance');
        $seances->save();

        $activities = new Activities;
        $activities->log_name = 'Seances';
        $activities->description = 'Séances - Process Modification ';
        $activities->subject_id = 0;
        $activities->subject_type = 'App\Seances';
        $activities->causer_id = \Auth::user()->id;
        $activities->causer_type = 'App\User';
        $activities->properties = ' Seances ID: '.$id;
        $activities->save(); 

        if($seances->nbrseance == $seances->nbreffectue && $seances->price == $seances->avancement){
            $seances->status = 1;
            $seances->save();
        }
           
        return redirect('/crm/seances/'.$id)->with('status','Seance crée avec succès.');
    }

    public function updatehistoric($id, $idseance){
        $serivce = SeanceServices::find($id);  
        $seance = Seances::find($idseance); 
        $allserivces = DB::table('seanceservices')->get(); 

        $serivce->package = Input::get('package');
        $serivce->service = Input::get('service');
        $serivce->price = Input::get('price');
        $serivce->employer = Input::get('employe');
        $serivce->save();

        $seance->price = 0;
        $seance->save();
        
        $total = DB::table('seanceservices')->where('seanceservices.id_seance',$idseance)->sum('price');
        $seance->price = $total;
        $seance->save();

        return redirect('/crm/seances/'.$idseance)->with('status','Services modifiées avec succès.');
    }

    public function addservicetoseance($idseance){
        $seance = Seances::find($idseance); 

        $serivce = new SeanceServices; 
        $serivce->package = Input::get('package');
        $serivce->service = Input::get('service');
        $serivce->price = Input::get('price');
        $serivce->employer = Input::get('employe');
        $serivce->id_seance = $idseance;
        $serivce->save();

        $seance->price = 0;
        $seance->save();
        
        $total = DB::table('seanceservices')->where('seanceservices.id_seance',$idseance)->sum('price');
        $seance->price = $total;
        $seance->save();

        return redirect('/crm/seances/'.$idseance)->with('status','Service ajouté avec succès.');
    }

    public function updatelostprice($id){ 
        // $seancehistory = new seancesHistory();
        // $seancehistory->date = Carbon::now();
        // $seancehistory->seance_id = $id;
        // $seancehistory->dateseance = Input::get('dateseance');
        // $seancehistory->timeseance = Input::get('timeseance');
        // $seancehistory->employer = Input::get('employer');
        // $seancehistory->avance = Input::get('lostprice');
        // $seancehistory->nbreffectue = Input::get('nbreffectue');
        // $seancehistory->save();

        $seances = Seances::find($id);
        $seances->avancement += Input::get('lostprice');
        $seances->save();

        if($seances->price == $seances->avancement){
            $seances->status = 1;
            $seances->save();
        }

        $activities = new Activities;
        $activities->log_name = 'Seances';
        $activities->description = 'Séances - Process cloture du seance ';
        $activities->subject_id = 0;
        $activities->subject_type = 'App\Seances';
        $activities->causer_id = \Auth::user()->id;
        $activities->causer_type = 'App\User';
        $activities->properties = ' Seances ID: '.$id;
        $activities->save(); 
           
        return redirect('/crm/seances/'.$id)->with('status','Seance cloturé avec succès.');
    }

    public function destroyseance($id){
        $seances = Seances::find($id);       
        
            $activities = new Activities;
            $activities->log_name = 'Seances';
            $activities->description = 'Séances - Process Supression ';
            $activities->subject_id = 0;
            $activities->subject_type = 'App\Seances';
            $activities->causer_id = \Auth::user()->id;
            $activities->causer_type = 'App\User';
            $activities->properties = ' Seances ID: '.$id;
            $activities->save(); 

        $seances->delete();
        return redirect('/crm/seances')->with('status','Seance supprimé avec succès.');
    }

    public function cancelseance($id){ 
        $seances = Seances::find($id);

        $seances->status = 2;
        $seances->save();

        $activities = new Activities;
        $activities->log_name = 'Seances';
        $activities->description = 'Séances - Process Annulation ';
        $activities->subject_id = 0;
        $activities->subject_type = 'App\Seances';
        $activities->causer_id = \Auth::user()->id;
        $activities->causer_type = 'App\User';
        $activities->properties = ' Seances ID: '.$id;
        $activities->save(); 
    
        return redirect('/crm/seances')->with('status','Seance annulé avec succès.');
    }

    public function undocancel($id){ 
        $seances = Seances::find($id);

        $seances->status = 0;
        $seances->save();

        $activities = new Activities;
        $activities->log_name = 'Seances';
        $activities->description = 'Séances - Process Libération ';
        $activities->subject_id = 0;
        $activities->subject_type = 'App\Seances';
        $activities->causer_id = \Auth::user()->id;
        $activities->causer_type = 'App\User';
        $activities->properties = ' Seances ID: '.$id;
        $activities->save(); 
    
        return redirect('/crm/seancesannules')->with('status','Seance libérer avec succès.');
    }

    public function findseancesnotvalid(Request $request){    
        $user = auth()->user();

        $data = DB::table('seanceservices')
            ->join('seances', 'seances.id', '=', 'seanceservices.id_seance')
            ->select('seanceservices.package','seanceservices.service','seances.name','seanceservices.price','seances.avancement','seances.id')
            ->where('seances.date', '=', $request->date)
            ->where('seances.emplacement', '=', $user->emplacement)
            ->where('seances.status',0)
            ->get();

        $avances = DB::table('seances')
            ->select('seances.avancement')
            ->where('seances.date', '=', $request->date)
            ->where('seances.emplacement', '=', $user->emplacement)
            ->where('seances.status',0)
            ->get();

        return response()->json([$data,$avances]);
    }

    public function findseancesvalidate(Request $request){

        if($request->ajax())
        {
            $data = DB::table('seanceservices')
            ->join('seances', 'seances.id', '=', 'seanceservices.id_seance')
            ->select('seanceservices.employer','seanceservices.package','seanceservices.service','seanceservices.price','seances.name')
            ->whereBetween('seances.date', [$request->startDate, $request->endDate])
            ->where('seances.status',0)
            ->get();

            $avances = DB::table('seances')
            ->select('seances.avancement')
            ->whereBetween('seances.date', [$request->startDate, $request->endDate])
            ->where('seances.status',0)
            ->get();

            return response([$data,$avances]);
        }
               
    }

    public function findprixtotal(Request $request){
        $data=Packages::select('pack','label', 'pu')->where('pack',$request->id)->take(100)->get();
        return response()->json($data);
    }

    public function findjourneybydate(Request $request){
        // $data=Seances::select('id','name','package','employer','price')->where('date',$request->date)->where('status',1)->take(100)->get();
        
        $data = DB::table('seanceservices')
            ->join('seances', 'seances.id', '=', 'seanceservices.id_seance')
            ->select('seanceservices.package','seanceservices.service','seances.name','seanceservices.price','seances.id')
            ->where('seances.date', '=', $request->date)
            ->where('.seances.status',1)
            ->get();

        return response()->json($data);
    }

    public function Spefindservicesperdate(Request $request){     
        $data = DB::table('seanceservices')
            ->join('seances', 'seances.id', '=', 'seanceservices.id_seance')
            ->select('seanceservices.employer','seanceservices.package','seanceservices.service','seanceservices.price','seances.name')
            ->where('seances.date', '=', $request->date)
            ->where('.seances.status',1)
            ->where('seanceservices.employer', '=', $request->employe)
            ->get();

        return response()->json($data);
    }

    public function Spefindservicespertwodate(Request $request){

        if($request->ajax())
        {
            $data = DB::table('seanceservices')
            ->join('seances', 'seances.id', '=', 'seanceservices.id_seance')
            ->select('seanceservices.employer','seanceservices.package','seanceservices.service','seanceservices.price','seances.name')
            ->whereBetween('seances.date', [$request->startDate, $request->endDate])
            ->where('.seances.status',1)
            ->where('seanceservices.employer', '=', $request->employe)
            ->get();

            return response($data);
        }
               
    }

    public function findamountbytwodates(Request $request){

        if($request->ajax())
        {
            // $data=Seances::whereBetween('date', [$request->startDate, $request->endDate])
            // ->where('status', 1)
            // ->get();
            // return response($data);

            $data = DB::table('seanceservices')
            ->join('seances', 'seances.id', '=', 'seanceservices.id_seance')
            ->select('seanceservices.package','seanceservices.service','seances.name','seanceservices.price','seances.id')
            ->whereBetween('seances.date', [$request->startDate, $request->endDate])
            ->where('.seances.status',1)
            ->get();

            return response($data);
        }
               
    }

    public function findservicesforseance(Request $request){
        $data=Packages::select('pu')->where('pack',$request->pack)->where('label',$request->label)->take(100)->get();
        return response()->json($data);
    }
    
    public function findpriceonupdate(Request $request){
        $data=Packages::select('pu','id')->where('label',$request->id)->take(100)->get();
        return response()->json($data);
	}

    public function findtimes(Request $request){
        $data=seancesHistory::select('timeseance')->where('dateseance',$request->dateselected)->get();
        return response()->json($data);
    }

    public function insertcomment($id){
        $seances = Seances::find($id);  
        $seances->comment = Input::get('comment');
        $seances->save();

        $activities = new Activities;
        $activities->log_name = 'Seances';
        $activities->description = 'Séances - Ajout de Commentaire ';
        $activities->subject_id = 0;
        $activities->subject_type = 'App\Seances';
        $activities->causer_id = \Auth::user()->id;
        $activities->causer_type = 'App\User';
        $activities->properties = ' Seances ID: '.$id;
        $activities->save(); 

        return redirect('/crm/seances/'.$id)->with('status','Commentaire Ajouté avec succès.');
    }

    public function findemployee(Request $request){
        $data=Personnel::select('name')->where('service',$request->service)->take(100)->get();
        // $data=seancesHistory::select('employer')->where([
        //     ['dateseance', '=', $request->dateselecte],
        //     ['timeseance', '=', $request->timeselected],
        // ])->get();
        return response()->json($data);
    }

    public function findreleve(Request $request){
        $data=Seances::select('name','package','price','date')->where('dateselected',$request->date)->where('status',1)->take(100)->get();
        return response()->json($data);
    }

    public function findservicecalendraie(Request $request){
        $data=Packages::select('label')->where('pack',$request->pack)->get();
        return response()->json($data);
    }

    public function findseanceselected(Request $request){

        if($request->ajax())
        {
            $data = DB::table('seanceservices')
            ->join('seances', 'seances.id', '=', 'seanceservices.id_seance')
            ->select('seanceservices.package','seanceservices.service','seanceservices.employer','seances.name','seances.date','seances.time')
            ->where('seanceservices.package', $request->package)
            ->where('seanceservices.service', $request->service)
            ->where('seances.date', $request->date)
            ->where('seances.emplacement',\Auth::user()->emplacement)
            ->where('seances.status',0)
            ->get();

            return response($data);
        }
               
    }


    /* ************************ Packages ********************* */

    public function packages(){
        $seancepackages = DB::table('seancepackages')->get();
        return view('admin.packages', compact('seancepackages'));
    }

    public function insertpackages(){
        $services = new Packages();

        $services->pack = Input::get('pack');
        $services->label = Input::get('label');
        $services->pu = Input::get('pu');
        $services->status = 0;
        $services->save();

        $activities = new Activities;
        $activities->log_name = 'Services';
        $activities->description = 'Services - Process Insertion ';
        $activities->subject_id = 0;
        $activities->subject_type = 'App\Services';
        $activities->causer_id = \Auth::user()->id;
        $activities->causer_type = 'App\User';
        $activities->properties = ' Services pour: '.Input::get('label');
        $activities->save(); 

        return redirect('/crm/packages')->with('status','Package/Service ajouté avec succès.');
    }

    public function updatepackage($id){ 
        $package = Packages::find($id);  
        $package->pack = Input::get('pack');
        $package->label = Input::get('label');
        $package->pu = Input::get('pu');
        $package->status = Input::get('status');
        $package->save();

        $activities = new Activities;
        $activities->log_name = 'Services';
        $activities->description = 'Services - Process modification du Services ';
        $activities->subject_id = 0;
        $activities->subject_type = 'App\Services';
        $activities->causer_id = \Auth::user()->id;
        $activities->causer_type = 'App\User';
        $activities->properties = ' Services ID: '.$id;
        $activities->save(); 
          
        return redirect('/crm/packages')->with('status','Package/Service modifé avec succès.');
    }

    public function destroypackage($id){
        $package = Packages::find($id);       
        
        $activities = new Activities;
        $activities->log_name = 'Services';
        $activities->description = 'Services - Process Supression ';
        $activities->subject_id = 0;
        $activities->subject_type = 'App\Services';
        $activities->causer_id = \Auth::user()->id;
        $activities->causer_type = 'App\User';
        $activities->properties = ' Pack/Services ID: '.$id;
        $activities->save(); 

        $package->delete();
        return redirect('/crm/packages')->with('status','Package/Service supprimé avec succès.');
    }

    public function packagesstatus($id){ 
        $package = Packages::find($id);  
        $package->status = Input::get('statustochange');
        $package->save();

        $activities = new Activities;
        $activities->log_name = 'Services';
        $activities->description = 'Services - Process Modification du status';
        $activities->subject_id = 0;
        $activities->subject_type = 'App\Services';
        $activities->causer_id = \Auth::user()->id;
        $activities->causer_type = 'App\User';
        $activities->properties = ' Services ID: '.$id;
        $activities->save(); 
        
        return redirect('/crm/packages')->with('status','Status modifié avec succès.');
    }


    /* ************************ TOMBOLA ********************* */
    public function tombola(){

        $duplicatedRecords = Commandes::select('client_nom','client_tel', DB::raw('COUNT(*) as count'))
            ->groupBy('client_nom', 'client_tel')
            ->having('count', '>=', 1)
            ->orderBy('count', 'desc')
            ->get();

            $totalDuplicatedCount = $duplicatedRecords->sum('count');

        return view('admin.tombola', compact('duplicatedRecords'));
    }

    /* ************************ PRODUITS ********************* */
    public function allproducts(){
        $produits = DB::table('produits')->get();
        $categories = DB::table('category')->get();
        return view('admin.allproducts', compact('produits','categories'));
    }

    public function insertproduct(Request $request){
        $produit = new Products();
        $produit->label = Input::get('label');
        $produit->pu = Input::get('pu');
        $produit->id_category = Input::get('id_category');
        $produit->stock = Input::get('stock');
        $produit->ordre = Input::get('ordre');
        $produit->descriptions = Input::get('descriptions');
        $produit->status = 0;

        if(Input::hasFile('file')){
            $file = $request->file('file');
            $filename = $file->getClientOriginalName();
            $file->move('produits/images', $filename);
            $produit->photo = $filename;
        }
        $produit->save();

        $activities = new Activities;
        $activities->log_name = 'Produits';
        $activities->description = 'Produits - Process Insertion ';
        $activities->subject_id = 0;
        $activities->subject_type = 'App\Produits';
        $activities->causer_id = \Auth::user()->id;
        $activities->causer_type = 'App\User';
        $activities->properties = ' Produits : '.Input::get('label');
        $activities->save(); 

        
        return redirect('/crm/allproducts')->with('status','Produit ajouté avec succès.');
    }

    public function destroyproduit($id){
        $produit = Products::find($id);       
        
        $activities = new Activities;
        $activities->log_name = 'Produits';
        $activities->description = 'Produits - Process Supression ';
        $activities->subject_id = 0;
        $activities->subject_type = 'App\Produits';
        $activities->causer_id = \Auth::user()->id;
        $activities->causer_type = 'App\User';
        $activities->properties = ' Produits : '.$produit->label;
        $activities->save(); 

        $produit->delete();
        return redirect('/crm/allproducts')->with('status','Produit supprimé avec succès.');
    }

    public function updateproduit($id){ 
        $produit = Products::find($id);  

        $produit->label = Input::get('label');
        $produit->pu = Input::get('pu');
        $produit->id_category = Input::get('id_category');
        $produit->stock = Input::get('stock');
        $produit->ordre = Input::get('ordre');
        $produit->descriptions = Input::get('descriptions');
        $produit->save();

        $activities = new Activities;
        $activities->log_name = 'Produits';
        $activities->description = 'Produits - Process Modification ';
        $activities->subject_id = 0;
        $activities->subject_type = 'App\Produits';
        $activities->causer_id = \Auth::user()->id;
        $activities->causer_type = 'App\User';
        $activities->properties = ' Produits : '.$produit->label;
        $activities->save(); 
            
        return redirect('/crm/allproducts')->with('status','Produit modifié avec succès.');
    }

    public function updateimgproduct(Request $request, $id){ 
        $produit = Products::find($id);  

        if($request->file != ''){        
            $path = 'produits/images/';
  
            //code for remove old file
            if($produit->photo != ''  && $produit->photo != null){
                $file_old = $path.$produit->photo;
                unlink($file_old);
            }
  
            //upload new file
            $file = $request->file;
            $filename = $file->getClientOriginalName();
            $file->move($path, $filename);
  
            //for update in table
            $produit->update(['photo' => $filename]);
       }        
        $produit->save();

        $activities = new Activities;
        $activities->log_name = 'Produits';
        $activities->description = 'Produits - Process Modification de Photo';
        $activities->subject_id = 0;
        $activities->subject_type = 'App\Produits';
        $activities->causer_id = \Auth::user()->id;
        $activities->causer_type = 'App\User';
        $activities->properties = ' Produits : '.$produit->label;
        $activities->save(); 
            
        return redirect('/crm/allproducts')->with('status','Produit modifié avec succès.');
    }

    public function produitstatus($id){ 
        $product = Products::find($id);  
        $product->status = Input::get('statustochange');
        $product->save();

        $activities = new Activities;
        $activities->log_name = 'Produits';
        $activities->description = 'Produits - Process Modification ';
        $activities->subject_id = 0;
        $activities->subject_type = 'App\Produits';
        $activities->causer_id = \Auth::user()->id;
        $activities->causer_type = 'App\User';
        $activities->properties = ' Produits Designation: '.$product->label;
        $activities->save(); 
        
        return redirect('/crm/allproducts')->with('status','Status modifié avec succès.');
    }

    /* ************************ CLIENTS ********************* */
    public function clients(){
        $clients = DB::table('clients')->get();
        return view('admin.clients', compact('clients'));
    }

    /* ************************ PERSONNELS ********************* */
    public function personnels(){
        $employers = DB::table('employer')->get();
        $packages = DB::table('seancepackages')->get();
        return view('admin.personnelscentre', compact('employers','packages'));
    }

    public function insertpersonnel(){
        $personnel = new Personnel();
        $personnel->name = Input::get('name');
        $personnel->service = Input::get('package');
        $personnel->adresse = Input::get('adresse');
        $personnel->phone = Input::get('phone');
        $personnel->emplacement = Input::get('emplacement');
        $personnel->save();
        
        $activities = new Activities;
        $activities->log_name = 'Personnel Centre Abattoirs';
        $activities->description = 'Personnel - Process Insertion ';
        $activities->subject_id = 0;
        $activities->subject_type = 'App\Personnel';
        $activities->causer_id = \Auth::user()->id;
        $activities->causer_type = 'App\User';
        $activities->properties = ' Personnel : '.Input::get('name');
        $activities->save(); 

        return redirect('/crm/personnelscentre')->with('status','Personnel ajouté avec succès.');
    }

    public function destroypersonnel($id){
        $employee = Personnel::find($id);       
        
        $activities = new Activities;
        $activities->log_name = 'Personnel';
        $activities->description = 'Personnel - Process Supression ';
        $activities->subject_id = 0;
        $activities->subject_type = 'App\Personnel';
        $activities->causer_id = \Auth::user()->id;
        $activities->causer_type = 'App\User';
        $activities->properties = ' Personnel : '.$employee->id;
        $activities->save(); 

        $employee->delete();
        return redirect('/crm/personnelscentre')->with('status','Employé supprimé avec succès.');
    }

    /* ************************ ACTIVITIES ********************* */
    public function activites(){
        $activities = DB::table('activity_log')->where('subject_type', 'App\RDV')->get();
        $utilisateurs = DB::table('activity_log')->where('subject_type', 'App\User')->get();
        $users = User::all();
        return view('admin.activitylog', compact('activities', 'users', 'utilisateurs'));
    }

    /* ************************ BARCODES ********************* */
    public function generateBarcode(Request $request){
        $product = DB::table('produits')->get();
        $label = '';
        $pu = '';
        return view('admin.barcode', compact('product', 'label', 'pu'));
    }

    public function barcodeproducts(Request $request){
        $codebar = $request->get('barcode');
        $product = Products::find($codebar);
        return view('admin.barcode', compact('product'));
    }

    public function findproducts(Request $request){
        $data=Products::select('id', 'id_category', 'photo', 'label','pu')->where('barcode',$request->barcode)->get();
        return response()->json($data);
	}

    public function printdata(Request $request){
        try {

            // Save Commandes ------------------------------------------------------
            $input = Input::all();
            $cmdpv = CommandesPV::all();
            $condition = $request->get("label");

            if($cmdpv->isEmpty()){
                $idcmdpv = 1;
            }else{
                $id = DB::table('commandespv')->latest()->first()->id_commandepv;
                $idcmdpv = $id +1;
            }
            

            foreach ($condition as $key => $condition) {
                $orderspv = new CommandesPV;
                $orderspv->id_commandepv = $idcmdpv;
                $orderspv->id_produit  = $input["product_id"][$key];
                $orderspv->pu = $input['pu'][$key];
                $orderspv->quantite = $input['quantite'][$key];
                $orderspv->prixtotal = $input['grand_total'];
                $orderspv->save();
            }

            // Print Invoice Commandes ------------------------------------------------------
            // $connector = new WindowsPrintConnector("smb://braimapc/gpprinter");
            
            // $connector = new WindowsPrintConnector("php://stdout");
            // $connector = new FilePrintConnector("/dev/USB002");
            $connector = new NetworkPrintConnector("192.168.123.100", 9100);
            
            $printer = new Printer($connector);

            $date = Carbon::now();

            /* Start the printer */
            // $logo = EscposImage::load(dirname(public_path("images")) . "\images\logo-inverse.png", false);
            $printer = new Printer($connector);

            /* Print top logo */
            $printer -> setJustification(Printer::JUSTIFY_CENTER);
            // $printer -> bitImage($logo);

            /* Name of shop */
            $printer -> selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
            $printer -> text("Baissa Shop.\n");
            $printer -> selectPrintMode();
            $printer -> text("Vente No. $idcmdpv\n");
            $printer -> feed(); 

            /* Title of receipt */
            $printer -> setEmphasis(true);
            $printer -> text("FACTURE DE VENTE\n\n");
            $printer -> setEmphasis(false);

            $lineTotal = sprintf('%-25.40s %6.05s %13.40s','Designation.','Prix U.', 'Quantite');
            $printer -> text("$lineTotal\n");
            
            $linebuttom = sprintf('%20.40s','================================================');
            $printer -> text("$linebuttom\n");

            foreach($request->label as $key => $v){
                $data =array(
                    $line = sprintf('%-25.40s %4.0f %13.2f', $request->label[$key], $request->pu[$key], $request->quantite[$key]), 
                    $printer -> text("$line\n"),
                );
            }
            
            $printer -> feed();
            $printer -> text("\n\n");       
            
            $linebuttomline = sprintf('%20.40s','------------------------------------------------');
            $printer -> text("$linebuttomline\n");

            /* Tax and total */
            $lineallTotal = sprintf('%30.30s %-1.05s %13.40s','Prix Total.','=', $request->get('grand_total') .' Dhs');
            $printer -> text("$lineallTotal\n");

            /* Footer */
            $printer -> feed(2);
            $printer -> setJustification(Printer::JUSTIFY_CENTER);
            $printer -> text("Merci d'avoir visité chez Baissa\n");
            $printer -> text("www.baissa.com\n");
            $printer -> feed(2);
            $printer -> text($date . "\n");

            /* Cut the receipt and open the cash drawer */
            $printer -> cut();
            $printer -> pulse();

            $printer -> close();

            
            
            return redirect('/crm/pointsvent')->with('status','Payement éffectué, prenez votre étiquitte.');
        } catch(Exception $e) {
            return redirect('/crm/pointsvent')->with('status','Couldnt print to this printer: ' . $e -> getMessage());
        }
        
        
    }

    /* ************************ COMMANDES ********************* */
    public function commandes(){
        $commandes = DB::table('commandes')->get();
        $datas = DB::table('commandes')
            ->join('commande_produit', 'commande_produit.id_commande', '=', 'commandes.id')
            ->join('produits', 'produits.id', '=', 'commande_produit.id_produit')
            ->select('produits.*','commande_produit.id_commande','commande_produit.quantite', 'commande_produit.prix_unitaire', 'commande_produit.montant')
            ->get();

        return view('admin.commandes', compact('commandes','datas'));
    }

    public function commandesvalid(){
        $commandes = DB::table('commandes')->get();
        $datas = DB::table('commandes')
            ->join('commande_produit', 'commande_produit.id_commande', '=', 'commandes.id')
            ->join('produits', 'produits.id', '=', 'commande_produit.id_produit')
            ->select('produits.*','commande_produit.id_commande','commande_produit.quantite', 'commande_produit.prix_unitaire', 'commande_produit.montant')
            ->get();

        return view('admin.commandesvalid', compact('commandes','datas'));
    }

    public function commandescanceled(){
        $commandes = DB::table('commandes')->get();
        $datas = DB::table('commandes')
            ->join('commande_produit', 'commande_produit.id_commande', '=', 'commandes.id')
            ->join('produits', 'produits.id', '=', 'commande_produit.id_produit')
            ->select('produits.*','commande_produit.id_commande','commande_produit.quantite', 'commande_produit.prix_unitaire', 'commande_produit.montant')
            ->get();

        return view('admin.commandescanceled', compact('commandes','datas'));
    }

    public function destroycmd(Request $request, $id){
        $commande = Commandes::find($id);

        $activities = new Activities;
        $activities->log_name = 'Commande';
        $activities->description = 'Suppression du Commande';
        $activities->subject_id = '1';
        $activities->subject_type = 'App\Commandes';
        $activities->causer_id = \Auth::user()->id;
        $activities->causer_type = 'App\User';
        $activities->properties = ' Commande ID: '.$id;
        $activities->save(); 

        $commande->delete();

        DB::table('commande_produit')
        ->where('id_commande', $id)
        ->delete();

        return redirect('/crm/commandes')->with('status','Commande à étés supprimé.');
    }

    public function commandeedit($id){
        $commande = Commandes::find($id);

        $datas = DB::table('commande_produit')
            ->join('produits', 'produits.id', '=', 'commande_produit.id_produit')
            ->where('commande_produit.id_commande', '=', $id)
            ->select('produits.label','produits.photo','commande_produit.id','commande_produit.id_commande','commande_produit.id_produit','commande_produit.quantite','commande_produit.montant',)
            ->get();

        // $clients = DB::table('commandes')
        //     ->join('clientsys', 'clientsys.tel', '=', 'commandeeco.client_tel')
        //     ->where('commandeeco.id_commande', '=', $id)
        //     ->select('clientsys.*')
        //     ->first();

        $produits = DB::table('produits')->get();
        return view('admin.commandeedit', compact('commande','datas','produits'));
    }

    public function destroycmdonedit(Request $request, $idcmd, $idpd){
        $commande = Commandes::find($idcmd);
        $labelproduct = Products::all();

        $labelname='';
        foreach($labelproduct as $prd){
            if($prd->id == $idpd){
                $labelname = $prd->label;
            }
        }

        $activities = new Activities;
        $activities->log_name = 'Commande';
        $activities->description = 'Supprission de produit lors la modification du commande';
        $activities->subject_id = '1';
        $activities->subject_type = 'App\Commandes';
        $activities->causer_id = \Auth::user()->id;
        $activities->causer_type = 'App\Commandes';
        $activities->properties = ' Commande ID: '.$idcmd. ', Produit: '.$labelname;
        $activities->save();   

        DB::table('commande_produit')
        ->where('id_produit', $idpd)
        ->delete();

        $cmdprd = Commandesproduits::all();
        $amount = 0;
        foreach($cmdprd as $pdtotal){
            if($pdtotal->id_commande == $idcmd){
                $amount += $pdtotal->montant;
            }
        }
        $commande->total_ttc = $amount;
        $commande->save();

        return redirect('/crm/commandeedit/' .$idcmd)->with('status','Produit à étés supprimé.');
    }

    public function updatepdtocmd(Request $request, $idcmd, $idpd){
        $commande = Commandes::find($idcmd);
        $cmdproduct = Commandesproduits::all();
        $product = Products::find($idpd);

        $ancienqte = DB::table('commande_produit')->select('quantite')->where('id_produit',$idpd)->get();
        
        $activities = new Activities;
        $activities->log_name = 'Commande';
        $activities->description = 'Modification de Quantité lors la modification du commande';
        $activities->subject_id = '1';
        $activities->subject_type = 'App\Commandes';
        $activities->causer_id = \Auth::user()->id;
        $activities->causer_type = 'App\Commandes';
        $activities->properties = ' Commande ID: '.$idcmd. ', Produit: '.$product->label. ', Ancien Quantité: '.$ancienqte. ', Nouvelle Quantité: ' .$request->get('qtepd');
        $activities->save();  
        
        $total = 0 ;
        foreach($cmdproduct as $cmd){
            if($cmd->id_produit == $idpd){
                $cmd->quantite = $request->get('qtepd');
                $cmd->montant = $cmd->prix_unitaire * $request->get('qtepd');
                $cmd->save();
            }
        }
        
        $amount = 0;
        foreach($cmdproduct as $pdtotal){
            if($pdtotal->id_commande == $idcmd){
                $amount += $pdtotal->montant;
            }
        }
        $commande->total_ttc = $amount;
        $commande->save();
        
        return redirect('/crm/commandeedit/' .$idcmd)->with('status','Produit à été Modifié');
    }

    public function addpdtocmd(Request $request, $idcmd, $idpd){
        $commande = Commandes::find($idcmd);
        $product = Products::find($idpd);
        $input = Input::all();
        
        $activities = new Activities;
        $activities->log_name = 'Commande';
        $activities->description = 'Modification du commande - insertion du produits';
        $activities->subject_id = '1';
        $activities->subject_type = 'App\Commandes';
        $activities->causer_id = \Auth::user()->id;
        $activities->causer_type = 'App\Commandes';
        $activities->properties = ' Commande ID: '.$idcmd. ', Produit: '.$product->label;
        $activities->save();  
        
        $cmdproduct = new Commandesproduits;
        $cmdproduct->id_commande = $idcmd;
        $cmdproduct->id_produit = $product->id;
        $cmdproduct->quantite = $request->get('addqtepd');
        $cmdproduct->prix_unitaire = $product->pu;
        $cmdproduct->montant = $product->pu * $request->get('addqtepd');
        $cmdproduct->save();

        $cmdprd = Commandesproduits::all();
        $amount = 0;
        foreach($cmdprd as $pdtotal){
            if($pdtotal->id_commande == $idcmd){
                $amount += $pdtotal->montant;
            }
        }
        $commande->total_ttc = $amount;
        $commande->save();
        
        return redirect('/crm/commandeedit/' .$idcmd)->with('status','Produit à été Ajouté');
    }

    public function commandestatus($id){ 
        $commande = Commandes::find($id);  
        $commande->status = Input::get('statustochange');
        $commande->save();

        $activities = new Activities;
        $activities->log_name = 'Commande';
        $activities->description = 'Commande - Process Modification ';
        $activities->subject_id = 0;
        $activities->subject_type = 'App\Commandes';
        $activities->causer_id = \Auth::user()->id;
        $activities->causer_type = 'App\User';
        $activities->properties = ' Commande ID: '.$commande->id;
        $activities->save(); 
        
        return redirect('/crm/commandes')->with('status','Status modifié avec succès.');
    }
    
}
 