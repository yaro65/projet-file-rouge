<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Hash;
use Auth;
use App\Models\Admin;
use App\Models\Vendeur;
use App\Models\BoutiqueVendeur;
use App\Models\BankVendeur;
use File;
use Image;
use Session;

// use App\Http\Middleware\Admin;
// use App\Http\Requests\vlidateformadminRequest;

class AdminController extends Controller
{
    public function amin()
    {
        Session::put('page','dashboard');
        return view('admin.dashboard');
    }
    //modifier le mot de passe 
    public function updateadminpassword(Request $request)
    {
        Session::put('page','modifier_mot_passe');
        if ($request->isMethod('post', 'get')) {
            $data = $request->all();

            if (Hash::check($data['current_Password'], Auth::guard('admin')->user()->password)) {
                // Le mot de passe actuel est correct
                if ($data['confirm_password'] == $data['new_password']) {
                    // Mettre à jour le mot de passe
                    Admin::where('id', Auth::guard('admin')->user()->id)
                        ->update(['password' => bcrypt($data['new_password'])]);
                    return redirect()->back()->with('success', 'Votre mot de passe a été modifié avec succès');
                } else {
                    return redirect()->back()->with('error', 'Le nouveau mot de passe et le mot de passe de confirmation ne correspondent pas');
                }
            } else {
                return redirect()->back()->with('error', 'Votre mot de passe est incorrect');
            }
        }

        // Récupérer les détails de l'administrateur
        $adminDetails = Admin::where('email', Auth::guard('admin')->user()->email)->first()->toArray();
        return view('admin.paramettre.modifier_mot_passe')->with(compact('adminDetails'));
    }

    //permet de verifier dirrectement si le mot de passe est correct dans la base de donnée
    public function checkupdateadminpassword(Request $request)
    {
        $data = $request->all();
        // echo "<pre>"; print_r($data); die;
        if (Hash::check($data['current_password'], Auth::guard('admin')->user()->password)) {
            return "true";
        } else {
            return "false";
        }
    }

    public function updateadmindetail(Request $request)
    {
        Session::put('page','mdifierdetail');
        if ($request->isMethod('post', 'get')) {
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            $rules = [
                'admin_name' => 'required|regex:/^[\pL\s\-]+$/u',
                'admin_mobile' => 'required|numeric',
            ];
            $message = [
                'admin_name.required' => 'Veillez entrer le nom de l\admin',
                'email.regex' => 'Le nom de l\admin est invalide',
                'admin_mobile.required' => 'Veillez entrer le numéro de téléphone ',
                'admin_mobile.required' => 'numéro de téléphone invalide ',
            ];

            $this->validate($request, $rules, $message);

            //ajouter image de ladmin 
            // if ($request->hasFile('image')) {
            //     $fileName = time() . $request->file('image')->getClientOriginalName();
            //     $path = $request->file('image')->storeAs('public', $fileName);
            //     $etudiant->image = '/storage/' . $fileName;
            // }

            if ($request->hasFile('admin_image')) {
                $image_tmp = $request->file('admin_image');
                if ($image_tmp->isValid()) {
                    $extension = $image_tmp->getClientOriginalExtension(); // Utilisez $image_tmp au lieu de $request->file('image')
                    $imageName = rand(111, 99999) . '.' . $extension;
                    $imagePath = 'admin/images/photos/' . $imageName; // Utilisez $image_tmp au lieu de $request->file('image')
                    Image::make($image_tmp)->save($imagePath); // Utilisez $image_tmp au lieu de $request
                }
            } else if (!empty($data['current_admin_image'])) {
                $imageName = $data['current_admin_image'];
            }
            Admin::where('id', Auth::guard('admin')->user()->id)->update([
                'nom' => $data['admin_name'],
                'telephone' => $data['admin_mobile'],
                'image' => $imageName,
            ]);
            // echo "<pre>"; print_r($data); die;
            return redirect()->back()->with('success', 'Admin modifié avec succès');
        }

        return view('admin.paramettre.mdifierdetail'); // Correction 5: Correction de l'orthographe de 'modifierdetail'
    }

    public function updatefournisseurdetail($slug, Request $request)
    {
        if($slug=="profile"){
            Session::put('page','mdifier_fournisseur_profile');
            if ($request->isMethod('post')) {
                $data = $request->all();
                $rules = [
                    'fournisseure_nom' => 'required|regex:/^[\pL\s\-]+$/u',
                    'fournisseure_ville' => 'required|regex:/^[\pL\s\-]+$/u',
                    'fournisseure_telephone' => 'required|numeric',
                ];
                $message = [
                    'fournisseure_nom.required' => 'Veillez entrer le nom du fournisseur',
                    'fournisseure_ville.required' => 'Veillez entrer la ville',
                    'fournisseure_nom.regex' => 'Le nom du fournisseure est invalide',
                    'fournisseure_ville.regex' => 'La ville du fournisseure est invalide',
                    'fournisseure_telephonr.required' => 'Veillez entrer le numéro de téléphone ',
                    'fournisseure_telephone.required' => 'numéro de téléphone invalide ',
                ];
                $this->validate($request, $rules, $message);
                if ($request->hasFile('fournisseure_image')) {
                    $image_tmp = $request->file('fournisseure_image');
                    if ($image_tmp->isValid()) {
                        $extension = $image_tmp->getClientOriginalExtension(); // Utilisez $image_tmp au lieu de $request->file('image')
                        $imageName = rand(111, 99999) . '.' . $extension;
                        $imagePath = 'admin/images/photos/' . $imageName; // Utilisez $image_tmp au lieu de $request->file('image')
    
                        Image::make($image_tmp)->save($imagePath); // Utilisez $image_tmp au lieu de $request
                    }
                } else if (!empty($data['current_fournisseure_image'])) {
                    $imageName = $data['current_fournisseure_image'];
                }
                Admin::where('id', Auth::guard('admin')->user()->id)->update([
                    'nom' => $data['fournisseure_nom'],
                    'telephone' => $data['fournisseure_telephone'],
                    'image' => $imageName,
                ]);
                // detail fournisseur 
                Vendeur::where('id', Auth::guard('admin')->user()->vendeur_id)->update([
                    'nom' => $data['fournisseure_nom'],
                    'address' => $data['fournisseure_address'],
                    'ville' => $data['fournisseure_ville'],
                    'secteur' => $data['fournisseure_secteur'],
                    'telephone' => $data['fournisseure_telephone'],
                    'email' => $data['fournisseure_email'],
                    'status' => $data['fournisseure_status'],
                ]);
                return redirect()->back()->with('success', 'fournisseur modifié avec succès');
                // Logique de traitement pour le scénario "profile" lorsqu'une requête POST est soumise
            }
            // Logique générale pour le scénario "profile"
            $fournisseureDetail = Vendeur::where('id', Auth::guard('admin')->user()->vendeur_id)->first()->toArray();
            
       
        }else if($slug=="boutique"){
            Session::put('page','mdifier_fournisseur_boutique');
            // Logique pour le scénario "Boutique"
            if ($request->isMethod('post','get')) {
                $data = $request->all();
                if ($request->hasFile('photos_de_boutique')) {
                    $image_tmp = $request->file('photos_de_boutique');
                    if ($image_tmp->isValid()) {
                        $extension = $image_tmp->getClientOriginalExtension(); // Utilisez $image_tmp au lieu de $request->file('image')
                        $imageName = rand(111, 99999).'.'.$extension;
                        $imagePath = 'admin/images/preuve/'.$imageName; // Utilisez $image_tmp au lieu de $request->file('image')
                        Image::make($image_tmp)->save($imagePath); // Utilisez $image_tmp au lieu de $request
                    }
                } else if (!empty($data['current_photos_de_boutique'])) {
                    $imageName = $data['current_photos_de_boutique'];
                }
                $vendeurCount =  BoutiqueVendeur::where('id', Auth::guard('admin')->user()->vendeur_id)->count();
                if($vendeurCount>0){
                // detail de la boutique 
                BoutiqueVendeur::where('vendeur_id', Auth::guard('admin')->user()->vendeur_id)->update([
                    'nom_de_boutique' => $data['nom_de_boutique'],
                    'adresse_de_boutique' => $data['adresse_de_boutique'],
                    'ville_de_boutique' => $data['ville_de_boutique'],
                    'secteur_de_boutique' => $data['secteur_de_boutique'],
                    'tell_de_boutique' => $data['tell_de_boutique'],
                    'email_de_boutique' => $data['email_de_boutique'],
                    'document_de_boutique' => $data['document_de_boutique'],
                    'photos_de_boutique' => $imageName
                ]);
                } else {
                // detail de la boutique 
                BoutiqueVendeur::insert(['vendeur_id'=>Auth::guard('admin')->user()->
                    vendeur_id,
                    'nom_de_boutique' => $data['nom_de_boutique'],
                    'adresse_de_boutique' => $data['adresse_de_boutique'],
                    'ville_de_boutique' => $data['ville_de_boutique'],
                    'secteur_de_boutique' => $data['secteur_de_boutique'],
                    'tell_de_boutique' => $data['tell_de_boutique'],
                    'email_de_boutique' => $data['email_de_boutique'],
                    'document_de_boutique' => $data['document_de_boutique'],
                    'photos_de_boutique' => $imageName
                ]);
                }

                return redirect()->back()->with('success', 'boutique modifié avec succès');
                // Logique de traitement pour le scénario "profile" lorsqu'une requête POST est soumise
            }
            $vendeurCount = BoutiqueVendeur::where('id', Auth::guard('admin')->user()->vendeur_id)->count();
            if($vendeurCount>0){
                $fournisseureDetail = BoutiqueVendeur::where('id', Auth::guard('admin')->user()->vendeur_id)->first()->toArray(); 
            } else {
                $fournisseureDetail = array();
            }
        }else if($slug=="Bank"){
            Session::put('page','mdifier_fournisseur_Bank');
            // Logique pour le scénario "Bank"
            if ($request->isMethod('post','get')) {
                $data = $request->all(); 
                
                $vendeurCount =  BankVendeur::where('id', Auth::guard('admin')->user()->vendeur_id)->count();
                if($vendeurCount>0){
                BankVendeur::where('vendeur_id', Auth::guard('admin')->user()->vendeur_id)->update([
                        'nom_du_titulaire_du_compte' => $data['nom_du_titulaire_du_compte'],
                        'nom_de_la_bank' => $data['nom_de_la_bank'],
                        'numero_de_compte' => $data['numero_de_compte'],
                        'bank_ifsc_code' => $data['bank_ifsc_code'],
                    ]);
                } else {
                    BankVendeur::insert(['vendeur_id'=>Auth::guard('admin')->user()->
                        vendeur_id,
                        'nom_du_titulaire_du_compte' => $data['nom_du_titulaire_du_compte'],
                        'nom_de_la_bank' => $data['nom_de_la_bank'],
                        'numero_de_compte' => $data['numero_de_compte'],
                        'bank_ifsc_code' => $data['bank_ifsc_code'],
                    ]);
                }

                return redirect()->back()->with('success', 'fournisseur modifié avec succès');
                // Logique de traitement pour le scénario "profile" lorsqu'une requête POST est soumise

            }       
            $vendeurCount = BankVendeur::where('id', Auth::guard('admin')->user()->vendeur_id)->count();
            if($vendeurCount>0){
                $fournisseureDetail = BankVendeur::where('id', Auth::guard('admin')->user()->vendeur_id)->first()->toArray(); 
            } else {
                $fournisseureDetail = array();
            }
        }
        // $countries = Country::where('status',1)->get();
        return view('admin.paramettre.mdifier_fournisseur')->with(compact('slug', 'fournisseureDetail'));
    }

    public function connexion(Request $request)
    {
        // echo $password = Hash::make('1234'); die ;

        if ($request->isMethod('post')) {
            $data = $request->all();

            // $request->validate([
            // 'email' => 'required|email|max:250',
            // 'password' => 'required',
            // ]);
            $rules = [
                'email' => 'required|email|max:250',
                'password' => 'required',
            ];
            $customMessages = [
                'email.required' => 'Veillez saisir un email',
                'email.email' => 'Veillez saisir un email correct',
                'password.required' => 'Veillez saisir un mot de passe',
            ];

            $this->validate($request, $rules, $customMessages);

            // Attempt to log in the admin user
            if (
                Auth::guard('admin')->attempt([
                    'email' => $data['email'],
                    'password' => $data['password'],
                ])
            ) {
                if(Auth::guard('admin')->user()->type=="vendeur" && Auth::guard('admin')->user()->confirm=="No"){
                    return redirect()->back()->with('error_message', 'Veuillez confirmer votre Email pour activer votre compte vendeur');
                } else if(Auth::guard('admin')->user()->type!="vendeur" && Auth::guard('admin')->user()->status=="0"){
                    return redirect()->back()->with('error_message', 'votre compte admin n/est pas actif');
                } else {
                    return redirect('admin/dashboard');
                }
                
            } else {
                return redirect()->back()->with('error_message', 'adress email ou mot de passe incorect');
            }
            ;
        }
        return view('admin.connexion');
    }
    public function admins($type=null)
    {
        $admins = Admin::query();
        if(!empty($type)){
            $admins = $admins->where('type' , $type);
            $title = ucfirst($type)."s";
            Session::put('page','view_'.strtolower($title));
        }else{
            $title = "All Admins/Super admins/Vendeur";
            Session::put('page','view_all');
        }
            $admins = $admins->get()->toArray();
            return view('admin.admins.admins')->with(compact('admins','title'));
    }



    public function viewmdifierfournisseur($id)
    {
        $fournisseureDetail = Admin::with('fournisseureProfile','fournisseureBoutique','fournisseureBank')->where('id' , $id)->first();
        $fournisseureDetail = json_decode(json_encode($fournisseureDetail), true);
        // dd($fournisseureDetail);
        return view('admin.admins.view-mdifier-fournisseur')->with(compact('fournisseureDetail'));
    }

    public function updateAdminStatus(Request $request)
    {
        if($request->ajax()){
            $data = $request->all();
        }if($data['status']=="Active"){
            $status = 0;
        }else{
            $status = 1;
        }
        Admin::where('id',$data['admin_id'])->update(['status'=>$status]);
        $adminDetails = Admin::where('id',$data['admin_id'])->first()->toArray;
        if($adminDetails['type']=="vendeur" && $status==1){
             // send confirmation email 

             $email = $adminDetails["email"];
             $messageData = [
                'email' => $adminDetails['email'],
                'nom' => $adminDetails['nom'],
                'telephone' => $adminDetails['telephone']
             ];

             Mail::send('emails.vendeur_aprouver',$messageData , function($message)use($email){
                $message->to($email)->subject('Compte vendeur Approver');
             });
        }
        $adminType = Auth::guard('admin')->user()->type;
        return response()->json(['status'=>$status,'admin_id'=>$data['admin_id']]);
    }
    
    public function deconnexion()
    {
        Auth::guard('admin')->logout();
        return redirect('admin/connexion');
    }
}