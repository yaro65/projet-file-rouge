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
                        <a href="cart.html">Mercie</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Page Introduction Wrapper /- -->
    <!-- Cart-Page -->
 <div class="page-cart u-s-p-t-80">
  <div class="container">
   <div class="row">
    <div class="col-lg-12" align="center">
        <h3> VOTRE COMMANDE A ÉTÉ ENREGISTRÉE AVEC SUCCÈS</h3>
        <P>Votre numéro de commande est {{Session::get('commande_id')}} Et le montant total est : {{Session::get('grand_total')}}</P>
    </div>
   </div>
  </div>
 </div>
    <!-- Cart-Page /- -->
 @endsection