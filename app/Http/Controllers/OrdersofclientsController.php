<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Str;
use App\Clients;
use App\Rendezvous;
use App\Photos;
use App\Commandes;
use App\Commandesproduits;
use App\Packages;
use Carbon\Carbon;
use File;
use Mail;

class OrdersofclientsController extends Controller
{

    public function submitorder(Request $request){
        $inputcommande = Input::all();

        if($request->get('payoption') == 'espece'){
            if(Clients::where('phone', '=', Input::get('clientphone'))->exists()){

                $id_client = DB::table('clients')->select('id')->where('phone',Input::get('clientphone'))->first()->id;
                
                $commandes = new Commandes;
                $commandes->id_client = $id_client;
                $commandes->total_ttc = $inputcommande['totat_ttc'];
                $commandes->type_livraison = $inputcommande['payoption'];
                $commandes->client_nom = $inputcommande['clientname'];
                $commandes->client_tel = $inputcommande['clientphone'];
                $commandes->client_adresse = $inputcommande['clientadress'];
                $commandes->status = 0;
                $commandes->save();
                
                $id_commandeeco = DB::table('commandes')->select('id')->where('client_tel',Input::get('clientphone'))->latest()->first()->id;

                $input = Input::all();
                $condition = $input['nomarticle'];
                foreach ($condition as $key => $condition) {
                    $orders = new Commandesproduits;
                    $orders->id_commande = $id_commandeeco;
                    $orders->id_produit = $input['idproduct'][$key];
                    $orders->quantite = $input['quantity'][$key];
                    $orders->prix_unitaire = $input['prix'][$key];
                    $orders->montant = $input['soustotal'][$key];
                $orders->save();
                }
              
            }
            else{
                $inputclients = Input::all();
                $client = new Clients;
                $client->name = $inputclients['clientname'];
                $client->ville = $inputclients['clientville'];
                $client->adresse = $inputclients['clientadress'];
                $client->phone = $inputclients['clientphone'];
                $client->save();

                $id_client = DB::table('clients')->select('id')->where('phone',Input::get('clientphone'))->first()->id;

                $commandes = new Commandes;
                $commandes->id_client = $id_client;
                $commandes->total_ttc = $inputcommande['totat_ttc'];
                $commandes->type_livraison = $inputcommande['payoption'];
                $commandes->client_nom = $inputcommande['clientname'];
                $commandes->client_tel = $inputcommande['clientphone'];
                $commandes->client_adresse = $inputcommande['clientadress'];
                $commandes->status = 0;
                $commandes->save();
                
                $id_commandeeco = DB::table('commandes')->select('id')->where('client_tel',Input::get('clientphone'))->first()->id;
                
                $input = Input::all();
                $condition = $input['nomarticle'];
                foreach ($condition as $key => $condition) {
                    $orders = new Commandesproduits;
                    $orders->id_commande = $id_commandeeco;
                    $orders->id_produit = $input['idproduct'][$key];
                    $orders->quantite = $input['quantity'][$key];
                    $orders->prix_unitaire = $input['prix'][$key];
                    $orders->montant = $input['soustotal'][$key];
                $orders->save();
                }                 
            }
        }else{
            return redirect('/paycommande');
        }
        
        $products = DB::table('produits')->get();
        $categories = DB::table('category')->get();
        return redirect('/products')->with('status','Votre commande a bien été enregistré. Nous vous contacterons dès que possible.');
    }


}
