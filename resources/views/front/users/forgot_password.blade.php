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
                        <a href="{{url('/']}}">Accueil</a>
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
                 <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; right: 0; top: 0;">
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
                <!-- Login -->
                <div class="col-lg-6">
                    <div class="login-wrapper">
                        <h2 class="account-h2 u-s-m-b-20">Mot de passe oublié</h2>
                        <h6 class="account-h6 u-s-m-b-30">Bienvenue retour! connectez-vous à votre compte</h6>
                        <p id="forgot-error"></p>
                        <p id="forgot-success"></p>
                        <form id="forgotForm" action="javascript:;" method="POST">
                            @csrf
                            <div class="u-s-m-b-30">
                                <label for="user-email">Email
                                    <span class="astk">*</span>
                                </label>
                                <input type="email" id="user-email" name="email" class="text-field" placeholder="Email">
                                <p id="login-email"></p> <!-- Correction de l'ID pour les messages d'erreur -->
                            </div>
                        <p id="forgot-email"></p>
                        <div class="group-2 text-right">
                                <div classe="page-anchor">
                                    <a href="{{url('user/login-register')}}" >
                                        <i class="fas fa-circle-o-notch u-s-m-r-9">Retour à la connexion</i>
                                    </a>
                                </div>
                            </div>
                            
                            <!-- <div class="u-s-m-b-30">
                                <label for="user-password">Password
                                    <span class="astk">*</span>
                                </label>
                                <input type="password" id="user-password" name="password" class="text-field" placeholder="Password">
                                <p id="login-password"></p> 
                            </div>
                            <div class="group-2 text-right">
                                <div classe="page-anchor">
                                    <a href="{{url('user-forgot-password')}}" >
                                        <i class="fas fa-circle-o-notch u-s-m-r-9">Mot de passe oublié</i>
                                    </a>
                                </div>
                            </div> -->

                            <div class="m-b-45 mt-3">
                                <button type="submit" class="button button-outline-secondary w-100">Connexion</button>
                            </div>
                        </form>

                    </div>
                </div>
                <!-- Login /- -->
                <!-- Register -->
                <div class="col-lg-6">
                    <div class="reg-wrapper">
                        <h2 class="account-h2 u-s-m-b-20">Incription</h2>
                        <h6 class="account-h6 u-s-m-b-30">l'inscription à ce site vous oermet d'accéder à votre statut et à votre historique.</h6>
                        <form id="registerForm"  action="javascript:;" method="POST">
                            @csrf
                            @method ('POST')
                            <div class="u-s-m-b-30">
                                <label for="user-name">Nom
                                    <span class="astk">*</span>
                                </label>
                                <input type="text" id="user-name" name="name" class="text-field" placeholder="name">
                                 <p id="register-name"></p>
                            </div>
                            <div class="u-s-m-b-30">
                                <label for="usermobile">Mobile
                                    <span class="astk">*</span>
                                </label>
                                <input type="text" id="user-telephone" name="telephone" class="text-field" placeholder="Telephone">
                                <p id="register-telephone"></p>
                            </div>
                            <div class="u-s-m-b-30">
                                <label for="email">Email
                                    <span class="astk">*</span>
                                </label>
                                <input type="text" id="user-email" name="email" class="text-field" placeholder="Email">
                                <p id="register-email"></p>
                            </div>
                            <div class="u-s-m-b-30">
                                <label for="userpassword">Password
                                    <span class="astk">*</span>
                                </label>
                                <input type="password" id="user-password" name="password" class="text-field" placeholder="Password">
                                <p id="register-password"></p>
                            </div>
                            <div class="u-s-m-b-30">
                                <input type="checkbox" class="check-box" id="accept" name="accept">
                                <label class="label-text no-color" for="accept">I’ve read and accept the
                                    <a href="terms-and-conditions.html" class="u-c-brand">terms & conditions</a>
                                </label>
                                <p id="register-accept"></p>
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
    <!-- Account-Page /- -->
 @endsection