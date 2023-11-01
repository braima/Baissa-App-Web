<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    return redirect('/crm/dashboardadmin')->with('status','Cache à été supprimé.');
});
Route::get('/clear-views', function() {
    $exitCode = Artisan::call('view:clear');
    return redirect('/crm/dashboardadmin')->with('status','Views à été supprimé.');
});

Route::get('/', function () {
    return view('welcome');
})->name('/');

Route::get('/inside', function () {
    return view('pages.inside');
})->name('inside');

Route::get('/about', function () {
    return view('pages.about');
})->name('about');

Auth::routes();

Route::get('/rendezvous', function() { return view('pages.rendezvous'); })->name('rendezvous');
Route::post("saverdv", 'OrdersofclientsController@saverdv');

// Route::get('/products', function() { return view('pages.products'); })->name('products');
Route::get('/reservation', function() { 
    $packages = DB::table('seancepackages')->get();
    return view('pages.reservation', compact('packages')); 
})->name('reservation');
Route::get('/contact', function() { return view('pages.contact'); })->name('contact');


Route::get('/products', function () {
    $bmproducts = DB::table('produits')->orderBy('ordre', 'asc')->get();
    $categories = DB::table('category')->get();
    return view('pages.products', compact('bmproducts', 'categories'));
})->name('products');

Route::get('/productspannier', function () {
    $bmproducts = DB::table('produits')->get();
    $categories = DB::table('category')->get();
    return view('pages.productspannier', compact('bmproducts', 'categories'));
})->name('productspannier');

Route::post("submitorder", 'OrdersofclientsController@submitorder');
Route::post("mailtoteacher", 'OrdersofclientsController@mailtoteacher');
Route::get("/findprixrdv", 'OrdersofclientsController@findprixrdv');


/*
|--------------------------------------------------------------------------
| Admins Routes
|--------------------------------------------------------------------------
|
| Here is where you can register Admins routes for PMT application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "Admin" middleware. Now create something great!
|
*/

Route::group(['as'=>'admin.','namespace'=>'Admin','middleware'=>['auth','admin']], 
function (){
    Route::get('/crm/dashboard','DashboardController@index')->name('dashboard');
    Route::get('/crm/centerdashboard','DashboardController@centerdashboard')->name('centerdashboard');
    Route::get('/crm/dashboardweb','DashboardController@dashboardweb')->name('dashboardweb');
    Route::get('/crm/dashboardadmin','DashboardController@dashboardadmin')->name('dashboardadmin');

    /******************* USERS ****************/
    Route::get('/crm/utilisateurs', 'DashboardController@utilisateurs')->name('utilisateurs');
    Route::get('/utilisateurs/createuser','DashboardController@createuser')->name('createuser');
    Route::put('/utilisateurs/{id}','DashboardController@updateuser')->name('updateuser');
    Route::delete('/utilisateurs/{id}','DashboardController@destroyuser')->name('destroyuser');

    /******************* Rendezvous ****************/
    Route::get('/crm/rendezvous', 'OperationsController@newrendezvous')->name('newrendezvous');
    Route::get('/crm/rendezvousvalidates', 'OperationsController@rendezvousvalidates')->name('rendezvousvalidates');
    Route::get('/crm/rendezvousannule', 'OperationsController@rendezvousannule')->name('rendezvousannule');
    // Operations
    Route::get('/crm/insertrdv', 'OperationsController@insertrdv')->name('insertrdv');
    Route::get('/crm/switchtoseance/{id}', 'OperationsController@switchtoseance')->name('switchtoseance');
    Route::get('/crm/validaterdv/{id}', 'OperationsController@validaterdv')->name('validaterdv');
    Route::get('/crm/cancelrdv/{id}', 'OperationsController@cancelrdv')->name('cancelrdv');
    Route::get('/crm/updaterdv/{id}', 'OperationsController@updaterdv')->name('updaterdv');
    Route::get('/crm/destroyrdv/{id}', 'OperationsController@destroyrdv')->name('destroyrdv');

    Route::get('/crm/switchrdvtoseance/{id}', 'OperationsController@switchrdvtoseance')->name('switchrdvtoseance');

    /******************* Catégories ****************/
    Route::get('/crm/categories', 'OperationsController@categories')->name('categories');
    // Operations
    Route::get('/crm/insertcategory', 'OperationsController@insertcategory')->name('insertcategory');
    Route::get('/crm/updatecategory/{id}', 'OperationsController@updatecategory')->name('updatecategory');
    Route::get('/crm/destroycategory/{id}', 'OperationsController@destroycategory')->name('destroycategory');
    Route::get('/crm/categorystatus/{id}', 'OperationsController@categorystatus')->name('categorystatus');
    
    /******************* seances ****************/
    Route::get('/crm/seances', 'OperationsController@seances')->name('seances');

    Route::get('/crm/seancesdemo', 'OperationsController@seancesdemo')->name('seancesdemo');

    Route::get('/crm/seanceseffectue', 'OperationsController@seanceseffectue')->name('seanceseffectue');
    Route::get('/crm/seancesannules', 'OperationsController@seancesannules')->name('seancesannules');
    Route::get('/crm/seances/{id}', 'OperationsController@seanceshistories')->name('seanceshistories');
    Route::get('/crm/seancestickets', 'OperationsController@seancestickets')->name('seancestickets');
    Route::get('/crm/releveencours','OperationsController@releveencours')->name('releveencours');
    Route::get('/crm/seancescalendraie','OperationsController@seancescalendraie')->name('seancescalendraie');

    // Operations
    Route::get('/crm/gotoinsert','OperationsController@gotoinsert');
    Route::post('/crm/insertseance', 'OperationsController@insertseance')->name('insertseance');

    Route::post('/crm/setnewseancedemo', 'OperationsController@setnewseancedemo')->name('setnewseancedemo');

    Route::get('/crm/validateseances/{id}', 'OperationsController@validateseances')->name('validateseances');
    Route::get('/crm/updatenbrseance/{id}', 'OperationsController@updatenbrseance')->name('updatenbrseance');
    Route::get('/crm/updateseance/{id}', 'OperationsController@updateseance')->name('updateseance');
    Route::get('/crm/destroyseance/{id}', 'OperationsController@destroyseance')->name('destroyseance');
    Route::get('/crm/cancelseance/{id}', 'OperationsController@cancelseance')->name('cancelseance');
    Route::get('/crm/undocancel/{id}', 'OperationsController@undocancel')->name('undocancel');
    Route::get('/crm/findprixtotal','OperationsController@findprixtotal');
    Route::get('/crm/findservicesforseance','OperationsController@findservicesforseance');

    Route::get('/crm/findpriceonupdate','OperationsController@findpriceonupdate');
    Route::get('/crm/findtimes','OperationsController@findtimes');
    Route::get('/crm/findjourneybydate','OperationsController@findjourneybydate');
    Route::get('/crm/findamountbytwodates','OperationsController@findamountbytwodates');
    
    Route::get('/crm/updateseancehistory/{id}','OperationsController@updateseancehistory')->name('updateseancehistory');
    Route::get('/crm/updatelostprice/{id}','OperationsController@updatelostprice')->name('updatelostprice');
    Route::get('/crm/insertcomment/{id}','OperationsController@insertcomment')->name('insertcomment');
    Route::get('/crm/findemployee','OperationsController@findemployee');
    Route::get('/crm/findreleve','OperationsController@findreleve');
    Route::get('/crm/updatehistoric/{id}/{idseance}','OperationsController@updatehistoric')->name('updatehistoric');
    Route::post('/crm/addservicetoseance/{idseance}','OperationsController@addservicetoseance')->name('addservicetoseance');

    Route::get('/crm/seancesemploye','OperationsController@seancesemploye');
    Route::get('/crm/Spefindservicesperdate','OperationsController@Spefindservicesperdate');
    Route::get('/crm/Spefindservicespertwodate','OperationsController@Spefindservicespertwodate');
    Route::get('/crm/findseancesnotvalid','OperationsController@findseancesnotvalid');
    Route::get('/crm/findseancesvalidate','OperationsController@findseancesvalidate');
    Route::get('/crm/findservicecalendraie','OperationsController@findservicecalendraie');
    Route::get('/crm/findseanceselected','OperationsController@findseanceselected');


    /******************* Packages ****************/
    Route::get('/crm/packages','OperationsController@packages');
    Route::get('/crm/insertpackages','OperationsController@insertpackages');
    Route::get('/crm/updatepackage/{id}', 'OperationsController@updatepackage')->name('updatepackage');
    Route::get('/crm/destroypackage/{id}', 'OperationsController@destroypackage')->name('destroypackage');
    Route::get('/crm/packagesstatus/{id}', 'OperationsController@packagesstatus')->name('packagesstatus');


    /******************* produits ****************/
    Route::get('/crm/allproducts', 'OperationsController@allproducts')->name('allproducts');
    Route::get('/crm/tombola', 'OperationsController@tombola')->name('tombola');
    Route::post('/crm/insertproduct', 'OperationsController@insertproduct')->name('insertproduct');
    Route::get('/crm/destroyproduit/{id}', 'OperationsController@destroyproduit')->name('destroyproduit');
    Route::get('/crm/updateproduit/{id}', 'OperationsController@updateproduit')->name('updateproduit');
    Route::post('/crm/updateimgproduct/{id}', 'OperationsController@updateimgproduct')->name('updateimgproduct');
    Route::get('/crm/produitstatus/{id}', 'OperationsController@produitstatus')->name('produitstatus');

    /******************* clients ****************/
    Route::get('/crm/clients', 'OperationsController@clients')->name('clients');

    /******************* Activités ****************/
    Route::get('/crm/activities', 'OperationsController@activites')->name('activites');

    /******************* Personnels ****************/
    Route::get('/crm/personnelscentre', 'OperationsController@personnels')->name('personnelscentre');
    Route::get('/crm/insertpersonnel', 'OperationsController@insertpersonnel')->name('insertpersonnel');
    Route::get('/crm/destroypersonnel/{id}', 'OperationsController@destroypersonnel')->name('destroypersonnel');

    /******************* Barcode ****************/
    Route::get('/crm/pointsvent', 'OperationsController@generateBarcode')->name('pointsvent');
    Route::get('/crm/barcodeproducts', 'OperationsController@barcodeproducts')->name('barcodeproducts');
    Route::get('/crm/findproducts','OperationsController@findproducts');

    Route::post('/crm/printdata','OperationsController@printdata');


    /******************* Commandes ****************/
    Route::get('/crm/commandes', 'OperationsController@commandes')->name('commandes');
    Route::get('/crm/commandesvalid', 'OperationsController@commandesvalid')->name('commandesvalid');
    Route::get('/crm/commandescanceled', 'OperationsController@commandescanceled')->name('commandescanceled');
    Route::post('/crm/commandes/destroycmd/{id}', 'OperationsController@destroycmd')->name('destroycmd');
    Route::get('/crm/commandeedit/{id}', 'OperationsController@commandeedit')->name('commandeedit');
    Route::post('/crm/commandeedit/{idcmd}/destroy/{idpd}', 'OperationsController@destroycmdonedit')->name('destroycmdonedit');
    Route::post('/crm/commandeedit/{idcmd}/updateqte/{idpd}', 'OperationsController@updatepdtocmd')->name('updatepdtocmd');
    Route::post('/crm/commandeedit/{idcmd}/addpdtocmd/{idpd}', 'OperationsController@addpdtocmd')->name('addpdtocmd');
    Route::get('/crm/commandestatus/{id}', 'OperationsController@commandestatus')->name('commandestatus');
});


/*
|--------------------------------------------------------------------------
| Drivers Routes
|--------------------------------------------------------------------------
|
| Here is where you can register Drivers routes for PMT application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "Author" middleware. Now create something great!
|
*/
Route::group(['middleware'=>['auth','author']], 
function (){
    Route::get('/user/dashboard','DashboardAuthorController@index')->name('author.dashboard');
    Route::get('/user/dashboardweb','DashboardAuthorController@dashboardweb')->name('admin.dashboardweb');

    /******************* Commandes ****************/
    Route::get('/user/commandes', 'DashboardAuthorController@commandes')->name('commandes');
    Route::get('/user/commandesvalid', 'DashboardAuthorController@commandesvalid')->name('commandesvalid');
    Route::get('/user/commandescanceled', 'DashboardAuthorController@commandescanceled')->name('commandescanceled');
    Route::post('/user/commandes/destroycmd/{id}', 'DashboardAuthorController@destroycmd')->name('destroycmd');
    Route::get('/user/commandeedit/{id}', 'DashboardAuthorController@commandeedit')->name('commandeedit');
    Route::post('/user/commandeedit/{idcmd}/destroy/{idpd}', 'DashboardAuthorController@destroycmdonedit')->name('destroycmdonedit');
    Route::post('/user/commandeedit/{idcmd}/updateqte/{idpd}', 'DashboardAuthorController@updatepdtocmd')->name('updatepdtocmd');
    Route::post('/user/commandeedit/{idcmd}/addpdtocmd/{idpd}', 'DashboardAuthorController@addpdtocmd')->name('addpdtocmd');
    Route::get('/user/commandestatus/{id}', 'DashboardAuthorController@commandestatus')->name('commandestatus');
    
});


/*
|--------------------------------------------------------------------------
| Entreprise Routes
|--------------------------------------------------------------------------
|
| Here is where you can register Drivers routes for PMT application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "Author" middleware. Now create something great!
|
*/
Route::group(['namespace'=>'Entreprise', 'middleware'=>['auth','entreprise']], 
function (){
    Route::get('/thirdeditor/dashboard','DashboardController@index')->name('thirdeditor.dashboard');

});


/*
|--------------------------------------------------------------------------
| PAYMENT ONLINE
|--------------------------------------------------------------------------
|
| Here is where you can register Payment routes for PMT application. These
| routes are loaded by the Payment links. Now create something great!
|
*/
