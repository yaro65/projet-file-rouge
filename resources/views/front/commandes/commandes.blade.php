@extends('front.layout.layout')
 @section('content')
 <!-- Page Introduction Wrapper -->
 <div class="page-style-a">
        <div class="container">
            <div class="page-intro">
                <h2>Commande</h2>
                <ul class="bread-crumb">
                    <li class="has-separator">
                        <i class="ion ion-md-home"></i>
                        <a href="{{url('/')}}">Accueil</a>
                    </li>
                    <li class="is-marked">
                        <a href="cart.html">Mes Commandes</a>
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
       <table class="table table-striped table-bordeless">
        <tr class="table-danger">
            <th>Commande Id</th>
            <th> Nom<br>Code Produit </th>
            <th>Mode de paiement</th>
            <th>Montant total</th>
            <th>Date de commande</th>
            <th>Actions</th>
        </tr>
        @foreach($commandes as $commande)
        <tr>
            <td>{{ $commande['id']}}</td>
            <td>
            @foreach($commande['commandes_products'] as $product)
            {{$product['product_name']}} : {{$product['product_code']}}  <br>
            @endforeach
            </td>
            <td>{{ $commande['payment_method']}}</td>
            <td>{{ $commande['grand_total']}}</td>
            <td>{{ date('Y-m-d h:i:s', strtotime($commande['created_at']));}}</td>
            <td><a href="{{url('user/commandes/'.$commande['id'] )}}">Details</a></td>
        </tr>
        @endforeach

       </table>
    </div>
   </div>
  </div>
 </div>
    <!-- Cart-Page /- -->
 @endsection