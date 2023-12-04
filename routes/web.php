<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\AdminController; 
use App\Http\Controllers\admin\SectionController; 
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\MarqueController;
use App\Http\Controllers\admin\ProductsController;
use App\Http\Controllers\admin\CouponsController;
use App\Http\Controllers\Front\ProductController;
use App\Http\Controllers\Front\IndexController;
use App\Http\Controllers\admin\BannersController;
use App\Http\Controllers\Front\vendeursController;
use App\Http\Controllers\Front\UserController;
use App\Http\Controllers\admin\UsersController;
use App\Http\Controllers\admin\ShippingController;
use App\Http\Controllers\Front\AddressController;
use App\Http\Controllers\Front\CommandesController;
use App\Http\Controllers\admin\CommandeController;
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
         //coupon 
        Route::get('admin/coupons', [CouponsController::class , 'Coupons']);
        Route::post('/admin/update-coupon-status', [CouponsController::class , 'updateCouponStatus']);
        Route::get('admin/delete-coupon/{id}', [CouponsController::class , 'deletecoupon']);
        Route::match(['get', 'post'], 'admin/add-edit-coupon/{id?}', [CouponsController::class, 'addEditCoupon']);
        //user 
        Route::get('admin/users', [UsersController::class , 'Users']);
        Route::post('/admin/update-user-status', [UsersController::class , 'updateUserStatus']);
        // commande 
        Route::get('admin/commandes', [CommandeController::class , 'Commandes']);
        Route::get('admin/commandes/{id?}', [CommandeController::class, 'DetailsCommandes']);
        //mettre a jour le status de la commande 
        Route::post('admin/update-commande-status', [CommandeController::class , 'updateCommandeStatus']);
        Route::post('admin/update-commande-item-status', [CommandeController::class , 'updateCommandeItemStatus']);
        //pdf
        Route::get('admin/view/commande/invoice/{id?}', [CommandeController::class, 'Viewcommandepdf']);
        Route::get('admin/commande/pdf/{id?}', [CommandeController::class, 'commandepdf']); 
        // frais de livraison /admin/update-shipping-status
        Route::get('shipping-charges', [ShippingController::class, 'Shipping']);
        Route::post('admin/shipping-status', [ShippingController::class , 'ShippingStatus']);
        Route::match(['get', 'post'], 'admin/add-edit-shipping/{id?}', [ShippingController::class, 'addEditShipping']);


    });
// });
   Route::get('admin/commande/telechargerpdf/{id?}', [App\Http\Controllers\admin\CommandeController::class, 'commandepdf']);

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
    Route::get('/vendeur/confirm/{code}', [vendeursController::class, 'vendeurconfirm']);
    Route::post('panier/add', [ProductController::class, 'Ajouteraupanier']);
    // afficher le panier 
    Route::get('/panier', [ProductController::class, 'Panier']);

    //update panier item quantity
    Route::post('panier/update', [ProductController::class, 'Panierupdate']);
    //delete panier
    Route::post('panier/delete', [ProductController::class, 'Panierdelete']);

    // user login/register
    Route::get('/user/login-register', [UserController::class, 'LoginRegister'])->name('login');
    // User register 
    Route::post('/user/register', [UserController::class, 'userRegister']);
    // User login 
    Route::post('user/login', [UserController::class, 'userLogin']);

    Route::group(['middleware' => ['auth']], function () {
        // user account 
        Route::match(['get', 'post'], 'user/account', [UserController::class, 'userAccount']);
        // user update password
        Route::post('/user/update-password', [UserController::class, 'userUpdatePassword']);
        // apply coupon 
        Route::post('/apply-coupon', [ProductController::class, 'ApplyCoupon']);
        //
        Route::match(['get', 'post'], '/checkout', [ProductController::class, 'Checkout']);

        ///get-delivery-address
        Route::post('get-delivery-address', [AddressController::class, 'getDeliveryAddress']);

         //save address
         Route::post('save-address-address', [AddressController::class, 'saveDeliveryAddress']);

         //remove address
         Route::post('remove-address-address', [AddressController::class, 'removeDeliveryAddress']);
         //thanks
         Route::get('thanks', [ProductController::class, 'Thanks']);
         // user commande 
         Route::get('user/commandes/{id?}', [CommandesController::class, 'Commandes']);

    });
    
   
    Route::match(['get', 'post'],'user/forgot-password', [UserController::class, 'ForgotPassword']);
    // confirm user 
    Route::get('user/confirm/{code}', [UserController::class, 'confirmAcount']);
    //User Logout
    Route::get('user/deconnexion', [UserController::class, 'userDeconnexion']);






});


Route::get('/carosel', [ProductController::class, 'carosel']);


