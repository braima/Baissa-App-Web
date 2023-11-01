<?php

namespace App\Http\Controllers;

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


class DashboardAuthorController extends Controller
{
    public function index(){
        $users = DB::table('users')->get();
        return view('author.dashboard', compact('users'));
    }

    public function dashboardweb(){
        $seances = DB::table('seances')->get();
        $seanceshistory = DB::table('seanceshistory')->get();
        $clients = DB::table('clients')->get();
        $packages = DB::table('seancepackages')->get();
        return view('author.dashboardweb', compact('seances','clients','packages','seanceshistory'));
    }

    /* ************************ COMMANDES ********************* */
    public function commandes(){
        $commandes = DB::table('commandes')->get();
        $datas = DB::table('commandes')
            ->join('commande_produit', 'commande_produit.id_commande', '=', 'commandes.id')
            ->join('produits', 'produits.id', '=', 'commande_produit.id_produit')
            ->select('produits.*','commande_produit.id_commande','commande_produit.quantite', 'commande_produit.prix_unitaire', 'commande_produit.montant')
            ->get();

        return view('author.commandes', compact('commandes','datas'));
    }

    public function commandesvalid(){
        $commandes = DB::table('commandes')->get();
        $datas = DB::table('commandes')
            ->join('commande_produit', 'commande_produit.id_commande', '=', 'commandes.id')
            ->join('produits', 'produits.id', '=', 'commande_produit.id_produit')
            ->select('produits.*','commande_produit.id_commande','commande_produit.quantite', 'commande_produit.prix_unitaire', 'commande_produit.montant')
            ->get();

        return view('author.commandesvalid', compact('commandes','datas'));
    }

    public function commandescanceled(){
        $commandes = DB::table('commandes')->get();
        $datas = DB::table('commandes')
            ->join('commande_produit', 'commande_produit.id_commande', '=', 'commandes.id')
            ->join('produits', 'produits.id', '=', 'commande_produit.id_produit')
            ->select('produits.*','commande_produit.id_commande','commande_produit.quantite', 'commande_produit.prix_unitaire', 'commande_produit.montant')
            ->get();

        return view('author.commandescanceled', compact('commandes','datas'));
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

        return redirect('/user/commandes')->with('status','Commande à étés supprimé.');
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
        return view('author.commandeedit', compact('commande','datas','produits'));
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

        return redirect('/user/commandeedit/' .$idcmd)->with('status','Produit à étés supprimé.');
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
        
        return redirect('/user/commandeedit/' .$idcmd)->with('status','Produit à été Modifié');
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
        
        return redirect('/user/commandeedit/' .$idcmd)->with('status','Produit à été Ajouté');
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
        
        return redirect('/user/commandes')->with('status','Status modifié avec succès.');
    }
}
