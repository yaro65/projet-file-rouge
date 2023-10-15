<?php

namespace App\Http\Controllers\Front;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Vendeur;
use Validator;
use DB;


class vendeursController extends Controller
{
    public function loginRegister()
    {
        return view('front.vendeurs.login_register');
    }
    public function vendeurRegister(Request $request)
    {
        if($request->isMethod('post')){
            $data = $request->all();
            // echo"<pre>"; print_r($data); die;
            //validation
            $rules = [
                'nom' => 'required',
                'email' => 'required|email|unique:admins|unique:vendeurs',
                'telephone' => 'required|min:8|numeric|unique:admins|unique:vendeurs',
                'accept' => 'required',
            ];
            $message = [
                'nom.required' => 'Le Nom Obliger',
                'email.required' => 'Email Obliger',
                'email.unique' => 'Email Existe déja',
                'telephone.required' => 'Numéro Obliger',
                'telephone.unique' => 'Numéro Existe déja',
                'accept.required' => 'Accepter les termes',
            ];
            $validator = Validator::make($data, $rules, $message);
            // dd($validator);
            if($validator->fails()){
                return Redirect::back()->withErrors($validator);
            }

            DB::beginTransaction();
            // create vendeur accunte
             $vendeur = new Vendeur;
             $vendeur->nom = $data['nom'];
             $vendeur->telephone = $data['telephone'];
             $vendeur->email = $data['email'];
             $vendeur->status = 0;
             $vendeur->save();
             $vendeur_id = DB::getPdo()->lastInsertId();

             //insert in admins table 

             $admin = new Admin;

             $admin->type = 'vendeur';
             $admin->vendeur_id = $vendeur_id;
             $admin->nom = $data['nom'];
             $admin->telephone = $data['telephone'];
             $admin->email  = $data['email'];
             $admin->password  = bcrypt($data['password']);
             $admin->status = 0;

            //  date_default_timezone_set("Asia/Kolkata");
            //  $admin->crea  = $data['email'];
            //  $admin->email  = $data['email'];

             $admin->save();

             DB::commit();

             // send confirmation email 

             $email = $data["email"];
             $messageData = [
                'email' => $data['email'],
                'nom' => $data['nom'],
                'code' => base64_decode($data['email'])
             ];

             Mail::send('emails.vendeur_confirmation',$messageData , function($message)use($email){
                $message->to($email)->subject('confirmez votre compte vendeur');
             });
             //redirecte back fournisseur avect un message de success

             $message = "Merci de vous inscrire en tant que vendeur. Nous confirmerons par e-mail une fois votre compte approuvé.";
             return redirect()->back()->with('success_message',$message );

            }          
    }

    public function vendeurconfirm($email)
    {
        //  echo"<pre>"; print_r($data); die;
        $vendeurCount = Vendeur::where('email',$email)->first();
        if($vendeurCount>0){
            $vendeurDetails = Vendeur::where('email',$email)->first();
            if($vendeurDetails->confirm == "Yes"){
                $message = "Votre compte vendeur est déjà confirmé. Vous pouvez vous connecter";
                return redirect('vendeur/login-register')->with('error_message',$message);  
            } else{
                Admin::where('email',$email)->update(['confirm'=>'Yes']);
                Vendeur::where('email',$email)->update(['confirm'=>'Yes']);

                // send email
                $messageData = [
                   'email' => $email,
                   'nom' => $vendeurDetails->nom,
                   'telephone' =>  $vendeurDetails->telephone
                ];
   
                Mail::send('emails.vendeur_confirmer',$messageData , function($message)use($email){
                   $message->to($email)->subject('Votre compte vendeur est confirmez ');
                });
                // redirect vendeur a login et register 

                $message = "Votre compte de vendeur est confirmé. Vous pouvez vous connecter et ajouter vos 
                   détails professionnels personnels et bancaires pour activer votre compte vendeur pour ajouter des produits";
                 return redirect('vendeur/login-register')->with('success_message',$message);  
            }
        } else{
            abort(404);
        }
    }

}
