<?php

namespace App\Http\Controllers\Front;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Panier;
use App\Models\Country;
use App\Models\User;
use Auth;
use Session;
use Hash;


class UserController extends Controller
{
    public function  LoginRegister()
    {
        return view('front.users.login_register');
    }
    public function userRegister(Request $request)
    {
        
        if($request->ajax()){
            $data = $request->all();
            $validator = Validator::make($request->all(),[
                'name' => 'required|string|max:100',
                'telephone' => 'required|numeric|min:8',
                'email' => 'required|email|max:100|unique:users',
                'password' => 'required|min:6',
                'accept' => 'required',
            ],
            [
                'name.required' => 'Le champ Nom est requis.',
                'name.string' => 'Le champ Nom doit être une chaîne de caractères.',
                'name.max' => 'Le champ Nom ne doit pas dépasser 100 caractères.',
                'telephone.required' => 'Le champ Téléphone est requis.',
                'telephone.numeric' => 'Le champ Téléphone doit être un numéro.',
                'telephone.digits' => 'Le champ Téléphone doit avoir 8 chiffres minimum.',
                'email.required' => 'Le champ Email est requis.',
                'email.email' => 'Le champ Email doit être une adresse email valide.',
                'email.max' => 'Le champ Email ne doit pas dépasser 100 caractères.',
                'email.unique' => 'Cet email est déjà utilisé.',
                'password.required' => 'Le champ Mot de passe est requis.',
                'password.min' => 'Le champ Mot de passe doit contenir au moins 6 caractères.',
                'accept.required' => 'Accepter les termes & conditions'
            ]
            );
            if ($validator->passes()) {
                // Enregistrement de l'utilisateur
                $user = new User;
                $user->name = $data['name'];
                $user->telephone = $data['telephone'];
                $user->email = $data['email'];
                $user->password = bcrypt($data['password']);
                $user->status = 0;
                $user->save();

                // email confirme
                $email = $data["email"];
                $messageData = [
                   'email' => $data['email'],
                   'name' => $data['name'],
                   'telephone' => $data['telephone'],
                   'code' => base64_encode($data['email'])
                ];
   
                Mail::send('emails.confirmation',$messageData , function($message)use($email){
                   $message->to($email)->subject('confirmez votre compte');
                });

                $redirectTo = url('user/login-register');
                return response()->json(['type'=>'success','url'=>$redirectTo,'message'=>'Veuillez confirmer votre adresse e-mail pour activer votre compte.']);
                // Envoi de l'e-mail d'inscription
                // $email = $data['email'];
                // $messageData = [
                //     'name' => $data['name'], 
                //     'telephone' => $data['telephone'], 
                //     'email' => $data['email']
                // ];
                // Mail::send('emails.registers', $messageData, function($message) use ($email) {
                //     $message->to($email)->subject('Bienvenue aux développeurs de Stack.');
                // });
        
                // if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
                //     $redirectTo = url('panier');
                //     // mettre a jour le panier du clien 
                //     if(empty(Session::get('session_id'))){
                //         $user_id = Auth::user()->id;
                //         $session_id = Session::get('session_id');
                //         Panier::where('session_id',$session_id)->update(['user_id'=>$user_id]);
                //     }
            //         return response()->json(['type' => 'success', 'url' => $redirectTo]);
            //     }

            // } else {
            }
            return response()->json(['type' => 'error', 'errors' => $validator->messages()]);
        }
    }

    public function userAccount(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            $validator = Validator::make($request->all(),[
                'name' => 'required|string|max:100',
                'prenom' => 'required|string|max:100',
                'ville' => 'required|string|max:100',
                'region' => 'required|string|max:100',
                'address' => 'required|string|max:100',
                'pays' => 'required|string|max:100',
                'telephone' => 'required|numeric|min:10',
            ],
            [
        
                'name.required' => 'Le champ Nom est requis.',
                'prenom.required' => 'Le champ Prénom est requis.',
                'region.required' => 'Le champ Region est requis.',
                'region.string' => 'Le champ Region doit être une chaîne de caractères.',
                'prenom.string' => 'Le champ Préenom doit être une chaîne de caractères.',
                'ville.string' => 'Le champ ville doit être une chaîne de caractères.',
                'name.string' => 'Le champ Nom doit être une chaîne de caractères.',
                'name.max' => 'Le champ Nom ne doit pas dépasser 100 caractères.',
                'ville.required' => 'Le champ ville est requis.',
                'telephone.required' => 'Le champ Téléphone est requis.',
                'telephone.numeric' => 'Le champ Téléphone doit être un numéro.',
            
            ]);
            if($validator->passes()){
                User::where('id',Auth::user()->id)->update(['name'=>$data['name'],'prenom'=>$data['prenom'],
                'telephone'=>$data['telephone'],
                'ville'=>$data['ville'],'pays'=>$data['pays'],'address'=>$data['address'],'region'=>$data['region'],'date_naissance'=>$data['date_naissance']]);
                return response()->json(['type'=>'success', 'message'=>'Vos coordonnées de contact ont été mises à jour avec succès!.']);
            }else{
            return response()->json(['type' => 'error', 'errors' => $validator->messages()]);
            }
        }else{
            $countries = Country::where('status',1)->get()->toArray();
            return view('front.users.user_account')->with(compact('countries'));
        }
        
    }

    public function userUpdatePassword(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            $validator = Validator::make($request->all(),[
                'current_password' => 'required',
                'new_password' => 'required|min:6',
                'comfirm_password' => 'required|min:6|same:new_password',
            ],
            [
        
                'current_password.required' => 'Le champ Mot de passe actuel est requis.',
                'new_password.required' => 'Le champ Nouveau mot de passe est requis.',
                'comfirm_password.required' => 'Le champ Comfirmé le mot de passe est requis.',
                'comfirm_password.same' => 'Le mot de passe de comfirmation ne correspond pas.',
                'new_password.min' => 'Le minimum 6 chiffre est requis.',
        
            ]);

            if($validator->passes()){
                $current_password = $data['current_password'];
                $checkPassword = User::where('id',Auth::user()->id)->first();
                if(Hash::check($current_password,$checkPassword->password)){
                    $user = User::find(Auth::user()->id);
                    $user->password=bcrypt($data['new_password']);
                    $user->save();
                     return response()->json(['type'=>'success', 'message'=>'Le mot de passe du compte a été mis à jour avec succès .']);
                } else{
                return response()->json(['type'=>'incorrect', 'message'=>'Votre mot de passe actuel est incorrect.']);
               }
                return response()->json(['type'=>'success', 'message'=>'Vos coordonnées de contact ont été mises à jour avec succès!.']);
            }else{
                return response()->json(['type' => 'error', 'errors' => $validator->messages()]);

            }
        }
    }
    

    public function ForgotPassword(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|max:150|exists:users',
            ],
             [
                'email.required' => 'Le champ Email est requis.',
                'email.email' => 'Le champ Email doit être une adresse email valide.',
                'email.exists' => "L'adresse e-mail n'existe pas",
             ]);
             if($validator->passes()){
                //generer un nouveau mot de passe 
                $new_password = Str::random(16);
                //mettre ajour le nouveau mot de passe 
                 User::where('email',$data['email'])->update(['password'=>bcrypt($new_password)]);

                // get user details 
                $userDetails = User::where('email',$data['email'])->first()->toArray();

                //send email user 
                $email = $data["email"];
                $messageData = [
                   'email' => $email,
                   'name' => $userDetails['name'],
                   'password' => $new_password,
                ];
   
                Mail::send('emails.user_forgot_password',$messageData , function($message)use($email){
                   $message->to($email)->subject('Nouveau mot de passe');
                });
                // success message
                return response()->json(['type'=>'success', 'message' => 'Un nouveau mot de passe a été envoyé à votre adresse e-mail enregistrée.']);
             }else{
                return response()->json(['type'=>'error','errors'=>$validator->messages()]);
             }
        
        }else{

        }
        return view('front.users.forgot_password');
    }


    public function userLogin(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|max:150|exists:users',
                'password' => 'required|min:6',
            ],
             [
                'email.required' => 'Le champ Email est requis.',
                'email.email' => 'Le champ Email doit être une adresse email valide.',
                'email.exists' => "l'adresse e-mail sélectionnée est invalide",
             ]);
        
            if ($validator->passes()) {
                if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
                    if(Auth::user()->status==0){
                        Auth::logout();
                    return response()->json(['type'=>'inactive', 'message' => "Votre compte n'est pas activé. Veuillez confirmer votre email pour l'activer"]);
                    }
                    // mettre a jour le panier du clien 
                    if(empty(Session::get('session_id'))){
                        $user_id = Auth::user()->id;
                        $session_id = Session::get('session_id');
                        Panier::where('session_id',$session_id)->update(['user_id'=>$user_id]);
                    }
                    $redirectTo = url('panier');
                    return response()->json(['type'=>'success','url' => $redirectTo]);
                }else {
                    return response()->json(['type'=>'incorrect', 'message' => 'Email ou Mot de passe incorrect.']);
                }
            }else {
                return response()->json(['type'=>'error','errors'=>$validator->messages()]);
        }
      }
        
    }



    public function userDeconnexion()
    {
        Auth::logout();
        return redirect('/');
    }
    public function confirmAcount($code)
    {
        $email = base64_decode($code);
        $userCount = User::where('email', $email)->count();
        if ($userCount > 0) {
            $userDetails = User::where('email', $email)->first();
            if ($userDetails->status == 1) {
                return redirect('user/login-register')->with('error_message', 'Votre compte est déjà activé. Vous pouvez vous connecter maintenant.');
            } else {
                User::where('email', $email)->update(['status' => 1]);
                // Envoi de l'e-mail de bienvenue
                $messageData = [
                    'name' => $userDetails->name,
                    'telephone' => $userDetails->telephone,
                    'email' => $userDetails->email
                ];
                Mail::send('emails.registers', $messageData, function ($message) use ($email) {
                    $message->to($email)->subject('Bienvenue aux développeurs de Stack.');
                });
                return redirect('user/login-register')->with('success_message', 'Votre compte a été activé avec succès. Vous pouvez maintenant vous connecter.');
            }
        } else {
            abort(404);
        }
        
    }
}

     



 //  if($validator->passes()){
        //     if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
        //         if(Auth::user()->status==0){
        //             Auth::logout();
        //             return response()->json(['type'=>'inactive','message'=>'your account is inactive. Please cantact Admin']);
        //         }
        //         //update User cart with user id 
        //         if(!empty(Session::get('session_id'))){
        //             $user_id = Auth::user()->id;
        //             $session_id = Session::get('session_id');
        //             Panier::where('session_id',$session_id)->update(['user_id'=>$user_id]);
        //         }
        //         $redirectTo = url('panier');
        //         return response()->json(['type' => 'success','url' => $redirectTo]);
        //     }else{
        //         return response()->json(['type' => 'incorrect','message' => 'Email ou Mot de passe incorrecte']);
        //     }
        //     return response()->json(['type'=>'error','errors'=>$validator->messages()]);
        //  }