@extends('front.layout.layout')
 @section('content')
   <!-- Page Introduction Wrapper -->
   <div class="page-style-a">
        <div class="container">
            <div class="page-intro">
                <h2>Account</h2>
                <ul class="bread-crumb">
                    <li class="has-separator">
                        <i class="ion ion-md-home"></i>
                        <a href="{{url('/')}}">Accueil</a>
                    </li>
                    <li class="is-marked">
                        <a href="account.html">Compte</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Page Introduction Wrapper /- -->
    <!-- Account-Page -->
    <div class="page-account u-s-p-t-80">
        <div class="container">

        @if (Session::has('success_message'))
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                 <strong>Success:</strong> {{ Session::get('success_message')}}
                 <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; right: 0; top: 0;">
                    <span aria-hidden="true">&times;</span>
                 </button>
              </div>
              @endif

              @if (Session::has('error_message'))
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                 <strong>Error:</strong> {{ Session::get('error_message')}}
                 <<button type="button" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; right: 0; top: 0;">
                    <span aria-hidden="true">&times;</span>
                 </button>
              </div>
              @endif

              @if ($errors->any())
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                 <strong></strong> <?php echo implode('', $errors->all('<div>:message</div>')); ?>
                 <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; right: 0; top: 0;">
                    <span aria-hidden="true">&times;</span>
                 </button>
              </div>
              @endif 
            <div class="row">
                <!-- account -->
                <div class="col-lg-6">
                    <div class="account-wrapper">
                         <p id="account-error"></p>
                        <p id="account-success"></p>
                        <h4 class="account-h4 u-s-m-b-20">Met à jour les données de contact</h4>
                        <p id="account-error"></p>
                        <form id="accountForm" action="javascript:;" method="POST">
                            @csrf
                            <div class="u-s-m-b-30">
                                <label for="user-email">Email
                                    <span class="astk">*</span>
                                </label>
                                <input class="text-field"  value="{{Auth::user()->email}}" readonly=""
                                   disabled="" style="background-color: #e9e9e9;">
                                <p id="account-email"></p> 
                            </div>

                            <div class="u-s-m-b-30">
                                <label for="user-name">Nom
                                    <span class="astk">*</span>
                                </label>
                                <input class="text-field" type="text" id="user-name" name="name"  value="{{Auth::user()->name}}" 
                                   >
                                <p id="account-name"></p> 
                            </div>

                            <div class="u-s-m-b-30">
                                <label for="user-name">Prénom
                                    <span class="astk">*</span>
                                </label>
                                <input class="text-field" type="text" id="user-prenom" name="prenom"  value="{{Auth::user()->prenom}}" 
                                   >
                                <p id="account-prenom"></p> 
                            </div>

                            <div class="u-s-m-b-30">
                                <label for="user-date_naissance">Date de naissance
                                    <span class="astk">*</span>
                                </label>
                                <input class="text-field" type="date" id="user-date_naissance" name="date_naissance"  value="{{Auth::user()->date_naissance}}" 
                                   >
                                <p id="account-date_naissance"></p> 
                            </div>

                            <div class="u-s-m-b-30">
                                <label for="user-address">Address
                                    <span class="astk">*</span>
                                </label>
                                <input class="text-field" type="text" id="user-address" name="address"  value="{{Auth::user()->address}}" 
                                   >
                                <p id="account-address"></p> 
                            </div>

                            <div class="u-s-m-b-30">
                                <label for="user-pays">Pays
                                    <span class="astk">*</span>
                                </label>
                                <select class="text-field" name="pays" id="conutry" style="color:495057;">
                                    <option value="">Selection votre pays</option>
                                    @foreach($countries as $country)
                                      <option value="{{$country['pays']}}" @if($country['pays']==Auth::user()->country) selected @endif >
                                      {{$country['pays']}}
                                        </option>
                                    @endforeach
                                </select>
                                <p id="account-pays"></p> 
                            </div>

                            

                            <div class="u-s-m-b-30">
                                <label for="user-region">Region
                                    <span class="astk">*</span>
                                </label>
                                <input class="text-field" type="text" id="user-region" name="region"  value="{{Auth::user()->region}}" 
                                   >
                                <p id="account-region"></p> 
                            </div>


                            <div class="u-s-m-b-30">
                                <label for="user-ville">Ville/Commune
                                    <span class="astk">*</span>
                                </label>
                                <input class="text-field" type="text" id="user-ville" name="ville"  value="{{Auth::user()->ville}}"
                                   >
                                <p id="account-ville"></p> 
                            </div>

                            <div class="u-s-m-b-30">
                                <label for="user-telephone">Téléphone
                                    <span class="astk">*</span>
                                </label>
                                <input class="text-field"  type="text" id="user-telephone" name="telephone"  value="{{Auth::user()->telephone}}" 
                                   >
                                <p id="account-telephone"></p> 
                            </div>
                           


                            <div class="m-b-45 mt-3">
                                <button type="submit" class="button button-outline-secondary w-100">Mettre à jour</button>
                            </div>
                        </form>

                    </div>
                </div>
                <!-- account /- -->
                <div class="col-lg-6">
                    <div class="reg-wrapper">
                        <h2 class="account-h2 u-s-m-b-20" style="font-size:18px;">Mettre à jour le mot de passe</h2>
                            <p id="password-error"></p>
                            <p id="password-success"></p>
                        <form id="passwordForm"  action="javascript:;" method="POST">
                            @csrf
                            <div class="u-s-m-b-30">
                                <label for="userpassword">Mot de passe actuel
                                    <span class="astk">*</span>
                                </label>
                                <input type="password" id="current_password" name="current_password" class="text-field" placeholder="Mot de passe actuel">
                                <p id="password-current_password"></p>
                            </div>
                            <div class="u-s-m-b-30">
                                <label for="userpassword">Nouveau mot de passe
                                    <span class="astk">*</span>
                                </label>
                                <input type="password" id="new_password" name="new_password" class="text-field" placeholder="Nouveau mot de passe">
                                <p id="password-new_password"></p>
                            </div>
                            <div class="u-s-m-b-30">
                                <label for="userpassword">Comfirmé le mot de passe 
                                    <span class="astk">*</span>
                                </label>
                                <input type="password" id="comfirm_password" name="comfirm_password" class="text-field" placeholder="Comfirmé le mot de passe">
                                <p id="password-comfirm_password"></p>
                            </div>
                            <div class="u-s-m-b-45">
                                <button type="submit" class="button button-primary w-100">Inscrire</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Register /- -->
            </div>
        </div>
    </div>
    <br><br><br>
    <!-- Account-Page /- -->
 @endsection