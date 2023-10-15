<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\AdminController; 
use App\Http\Controllers\admin\SectionController; 
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\MarqueController;
use App\Http\Controllers\admin\ProductsController;
use App\Http\Controllers\Front\ProductController;
use App\Http\Controllers\Front\IndexController;
use App\Http\Controllers\admin\BannersController;
use App\Http\Controllers\Front\vendeursController;
use App\Models\Category;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('auth.connexion');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__.'/auth.php';

// Route::Controllers('/admin')->group(function() {
    //admin dashboar
    // routes/web.php

// Route::prefix('/admin')-namespace('App\Http\Controllers\Admin')->group(function(){
    Route::match(['get', 'post'], 'admin/connexion', [AdminController::class , 'connexion']);
    Route::group(['middleware'=>['admin']], function () {
        //admin dashboar
        Route::get('admin/dashboard', [AdminController::class , 'amin']);
        //modifier le mot de passe 
        Route::match(['get', 'post'], 'admin/paramettre/pasword', [AdminController::class , 'updateadminpassword']);
        //verification de mot de passe actuel
        Route::post('/admin/check-admin-password', [AdminController::class , 'checkupdateadminpassword']);
        //modifier les details de ladmin 
        Route::match(['get', 'post'], 'admin/paramettre', [AdminController::class , 'updateadmindetail']);
        //modifier les details du fourniseure 
        Route::match(['get', 'post'], 'mdifier_fournisseur/{slug}', [AdminController::class, 'updatefournisseurdetail']);
         //admin /superadmin /vendeur 
         Route::get('admin/admins/{type?}', [AdminController::class,   'admins']);
         // detailll
         Route::get('admin/view-mdifier-fournisseur/{id}', [AdminController::class , 'viewmdifierfournisseur']);
         // updat admin status
         Route::post('admin/update-admin-status', [AdminController::class , 'updateAdminStatus']);
         //admin connexion 
         Route::get('deconnexion', [AdminController::class , 'deconnexion']);
         // section
         Route::get('admin/sections', [SectionController::class , 'sections']);
         Route::post('admin/update-section-status', [SectionController::class , 'updateSectionStatus']);
         Route::get('admin/delete-section/{id}', [SectionController::class , 'deletesections']);
         Route::match(['get', 'post'], 'admin/add-edit-section/{id?}', [SectionController::class, 'addEditSection']);

         // Marque
         Route::get('admin/marques', [MarqueController::class , 'marques']);
         Route::post('admin/update-marque-status', [MarqueController::class , 'updateMarqueStatus']);
         Route::get('admin/delete-marque/{id}', [MarqueController::class , 'deleteMarques']);
         Route::match(['get', 'post'], 'admin/add-edit-marque/{id?}', [MarqueController::class, 'addEditMarque']);
         //categorie
         Route::get('admin/categories', [CategoryController::class , 'categories']);
         Route::post('admin/update-category-status', [CategoryController::class , 'updateCategoryStatus']);
         Route::match(['get', 'post'], 'admin/add-edit-category/{id?}', [CategoryController::class, 'addEditCategory']);
         Route::get('/admin/append-categories-level', [CategoryController::class , 'appendCategoryLevel']);
         Route::get('admin/delete-category/{id}', [CategoryController::class , 'deletecategory']);
         Route::get('admin/delete-category-image/{id}', [CategoryController::class , 'deletecategory']);

         // produit 
         Route::get('admin/products', [ProductsController::class , 'products']);
         Route::post('admin/update-product-status', [ProductsController::class , 'updateProductStatus']);
         Route::get('admin/delete-product/{id}', [ProductsController::class , 'deleteProduct']);
         Route::match(['get', 'post'], 'admin/add-edit-product/{id?}', [ProductsController::class, 'addEditProduct']);
         Route::get('admin/delete-product-image/{id}', [ProductsController::class , 'deleteproductimage']);
         Route::get('admin/delete-product-videos/{id}', [ProductsController::class , 'deleteproductVideo']);
         //attributes
         Route::post('admin/update-attribute-status', [ProductsController::class , 'updateAttributeStatus']);
         Route::get('admin/delete-attribute/{id}', [ProductsController::class , 'deleteAttribute']);
         Route::match(['get', 'post'], 'admin/add-edit-attributes/{id?}', [ProductsController::class, 'addAttributes']);
         Route::match(['get', 'post'], 'admin/edit-attributes/{id?}', [ProductsController::class, 'EditAttributes']);
         // add image 
         Route::match(['get', 'post'], 'admin/add-images/{id?}', [ProductsController::class, 'addImages']);
         Route::post('admin/update-image-status', [ProductsController::class , 'updateImageStatus']);
         Route::get('admin/delete-image/{id}', [ProductsController::class , 'deleteImage']);
         // bannier 
        Route::get('banners', [BannersController::class , 'Banners']);
        Route::post('admin/update-banner-status', [BannersController::class , 'updateBannerStatus']);
        Route::get('admin/delete-banner/{id}', [BannersController::class , 'deletebanner']);
        Route::match(['get', 'post'], 'admin/add-edit-banner/{id?}', [BannersController::class, 'addEditbanner']);
         
    });
// });

Route::namespace('App\Http\Controllers\Fronts')->group(function(){
    Route::match(['get', 'post'],'/', [IndexController::class, 'index']);
    //lister les categories 
    $catUrls = Category::select('url')->where('status',1)->get()->pluck('url')->toArray();
    // dd($catUrls);

    foreach($catUrls as $key => $url){
    Route::match(['get', 'post'],'/'.$url, [ProductController::class, 'listing']);
    }
    
    // product page detail
    Route::get('/product/{id}', [ProductController::class, 'detail']);
    //Get product attribue 
    Route::post('get-product-price', [ProductController::class, 'getproductprice']);
    //vendeur login register
    Route::get('/vendeur/login-register', [vendeursController::class, 'loginRegister']);
    Route::post('/vendeur/register', [vendeursController::class, 'vendeurRegister']);
    Route::get('/vendeur/confirm{code}', [vendeursController::class, 'vendeurconfirm']);

});


Route::get('/carosel', [ProductController::class, 'carosel']);


