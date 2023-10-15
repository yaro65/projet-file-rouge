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
                        <a href="index.html">Home</a>
                    </li>
                    <li class="is-marked">
                        <a href="account.html">Account</a>
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
                 <button type="button" class="Close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                 </button>
              </div>
              @endif

              @if (Session::has('error_message'))
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                 <strong>Error:</strong> {{ Session::get('error_message')}}
                 <button type="button" class="Close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                 </button>
              </div>
              @endif

              @if ($errors->any())
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                 <strong></strong> <?php echo implode('', $errors->all('<div>:message</div>')); ?>
                 <button type="button" class="Close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                 </button>
              </div>
              @endif 
            <div class="row">
                <!-- Login -->
                <div class="col-lg-6">
                    <div class="login-wrapper">
                        <h2 class="account-h2 u-s-m-b-20">Connexion</h2>
                        <h6 class="account-h6 u-s-m-b-30">Connecter vous a votre compte</h6>
                        <form class="pt-3" action="{{url('admin/connexion')}}" method="POST">
                            @csrf
                              @method ('POST')
                            <div class="u-s-m-b-30">
                                <label for="vendeur-email">Email
                                    <span class="astk">*</span>
                                </label>
                                <input type="email" id="vendeur-email" name="email"  class="text-field" placeholder="Email">
                            </div>
                            <div class="u-s-m-b-30">
                                <label for="vendeur-password">Password
                                    <span class="astk">*</span>
                                </label>
                                <input type="text" id="vendeur-password" name="password" class="text-field" placeholder="Password">
                            </div>
                            <!-- <div class="group-inline u-s-m-b-30">
                                <div class="group-1">
                                    <input type="checkbox" class="check-box" id="remember-me-token">
                                    <label class="label-text" for="remember-me-token">Remember me</label>
                                </div>
                                <div class="group-2 text-right">
                                    <div class="page-anchor">
                                        <a href="lost-password.html">
                                            <i class="fas fa-circle-o-notch u-s-m-r-9"></i>Lost your password?</a>
                                    </div>
                                </div>
                            </div> -->
                            <div class="m-b-45">
                                <button class="button button-outline-secondary w-100">Connexion</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Login /- -->
                <!-- Register -->
                <div class="col-lg-6">
                    <div class="reg-wrapper">
                        <h2 class="account-h2 u-s-m-b-20">Incription</h2>
                        <h6 class="account-h6 u-s-m-b-30">Registering for this site allows you to access your order status and history.</h6>
                        <form id="VendeurForm"  action="{{url('/vendeur/register')}}" method="post">
                            @csrf
                            <div class="u-s-m-b-30">
                                <label for="fournisseurenom">Nom
                                    <span class="astk">*</span>
                                </label>
                                <input type="text" id="nom" name="nom" class="text-field" placeholder="Nom">
                            </div>
                            <div class="u-s-m-b-30">
                                <label for="fournisseuremobile">Mobile
                                    <span class="astk">*</span>
                                </label>
                                <input type="text" id="fournisseuretelephone" name="telephone" class="text-field" placeholder="Mobile">
                            </div>
                            <div class="u-s-m-b-30">
                                <label for="email">Email
                                    <span class="astk">*</span>
                                </label>
                                <input type="text" id="fournisseureemail" name="email" class="text-field" placeholder="Email">
                            </div>
                            <div class="u-s-m-b-30">
                                <label for="fournisseurepassword">Password
                                    <span class="astk">*</span>
                                </label>
                                <input type="text" id="vedeurpassword" name="password" class="text-field" placeholder="Password">
                            </div>
                            <div class="u-s-m-b-30">
                                <input type="checkbox" class="check-box" id="accept" name="accept">
                                <label class="label-text no-color" for="accept">I’ve read and accept the
                                    <a href="terms-and-conditions.html" class="u-c-brand">terms & conditions</a>
                                </label>
                            </div>
                            <div class="u-s-m-b-45">
                                <button class="button button-primary w-100">Inscrire</button>
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