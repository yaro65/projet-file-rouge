<?php use App\Models\Product; ?>
@extends('front.layout.layout')
 @section('content')
 <!-- Page Introduction Wrapper -->
 <div class="page-style-a">
        <div class="container">
            <div class="page-intro">
                <h2>Panier</h2>
                <ul class="bread-crumb">
                    <li class="has-separator">
                        <i class="ion ion-md-home"></i>
                        <a href="{{url('/')}}">Accueil</a>
                    </li>
                    <li class="is-marked">
                        <a href="cart.html">Panier</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Page Introduction Wrapper /- -->
    <!-- Cart-Page -->
 <div class="page-cart u-s-p-t-80">
  <div class="container">
  @if (Session::has('success_message'))
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                 <strong>Success:</strong> <?php echo Session::get('success_message'); ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; right: 0; top: 0;">
                    <span aria-hidden="true">&times;</span>
                 </button>
              </div>
      @endif
      
   @if (Session::has('error_message'))
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                 <strong>Error:</strong> <?php echo Session::get('error_message'); ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; right: 0; top: 0;">
                    <span aria-hidden="true">&times;</span>
                 </button>
              </div>
    @endif
   <div class="row">

    <div class="col-lg-12">
        <div id="appendPanierItems">
            @include('front.products.panier_item')
        </div>
        <!-- Coupon -->
<div class="coupon-continue-checkout u-s-m-b-60">
    <div class="coupon-area">
         <h6>Entrez votre code de coupon si vous en avez un.</h6>
         <form id="ApplyCoupon" method="post" action="javascript:void(0);"
           @if(Auth::check()) user="1" @endif> @csrf
           <div class="coupon-field">
            <label class="sr-only" for="coupon-code">Appliquer le coupon</label>
            <input id="code" name="code" type="text" class="text-field" placeholder="Entrer le code">
            <button type="submit" class="button">Appliquer le coupon</button>
        </div>
         </form>
    </div> 
    <div class="button-area">
        <!-- Boutons pour continuer vos achats ou passer à la caisse -->
        <a href="{{url('/')}}" class="continue">Poursuivre vos achats</a>
        <a href="{{url('/checkout')}}" class="checkout">Passer à la caisse</a>
    </div>
</div>
<!-- Coupon /- -->
    </div>
   </div>
  </div>
 </div>
    <!-- Cart-Page /- -->
 @endsection