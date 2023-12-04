<?php use App\Models\Product; ?>
@extends('front.layout.layout')
 @section('content')
 <!-- Page Introduction Wrapper -->
 <div class="page-style-a">
        <div class="container">
            <div class="page-intro">
                <h2>Commande #{{$commmandeDetails['id']}} Details</h2>
                <ul class="bread-crumb">
                    <li class="has-separator">
                        <i class="ion ion-md-home"></i>
                        <a href="{{url('/')}}">Accueil</a>
                    </li>
                    <li class="is-marked">
                        <a href="{{url('user/commandes')}}">Mes Commandes</a>
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
          <tr class="table-danger"><td colspan="2"><strong>Commande Details</strong></td></tr>
          <tr><td>Commande Date</td><td>{{ date('Y-m-d h:i:s', strtotime($commmandeDetails['created_at']));}}</td></tr>
          
          <tr><td>Commande status</td><td>{{$commmandeDetails['commande_status']}}</td></tr>
          <tr><td>Commande Total</td><td>{{$commmandeDetails['commande_status']}}</td></tr>
          <tr><td>Frais de Livraison</td><td>{{$commmandeDetails['shipping_charge']}}</td></tr>
          @if($commmandeDetails['coupon_code']!="")
          <tr><td>Code du Coupon</td><td>{{$commmandeDetails['coupon_code']}}</td></tr>
          <tr><td>Montant du Coupon</td><td>{{$commmandeDetails['coupon_amount']}}</td></tr>
          @endif
          @if($commmandeDetails['courier_name']!="")
          <tr><td>Société de Livraison</td><td>{{$commmandeDetails['courier_name']}}</td></tr>
          <tr><td>Numéro de colis</td><td>{{$commmandeDetails['tracking_number']}}</td></tr>
          @endif
          <tr><td>Méthode de Paiement</td><td>{{$commmandeDetails['payment_method']}}</td></tr>
          
       </table>
       <table class="table table-striped table-bordeless">
             <tr class="table-danger">
                <th>Image du Produit</th>
                <th>Code du Produit</th>
                <th>Nom du Produit</th>
                <th>Taille du Produit</th>
                <th>Couleur du Produit</th>
                <th>Quantité du Produit</th>
             </tr>
             @foreach($commmandeDetails['commandes_products'] as $product)
            <tr>
                <td>
                    @php $getProductImage = 
                    Product::getProductImage($product['product_id']) @endphp
                    <a target="_blank" href="{{url('product/'.$product['product_id'])}}">
                    <img src="{{asset('front/images/product_images/small/'.$getProductImage)}}" style="width:80px;" alt="">
                    </a>
                </td>
                <td>{{$product['product_code']}}</td>
                <td>{{$product['product_name']}}</td>
                <td>{{$product['product_size']}}</td>
                <td>{{$product['product_color']}}</td>
                <td>{{$product['product_qty']}}</td>
            </tr>
            @endforeach
       </table>
       <table class="table table-striped table-bordeless">
           <tr class="table-danger"><td colspan="2"><strong>Address de livraison</strong></td></tr>
             <tr><td>Nom</td><td>{{$commmandeDetails['name']}}</td></tr>
             <tr><td>Address</td><td>{{$commmandeDetails['address']}}</td></tr>
             <tr><td>Ville</td><td>{{$commmandeDetails['ville']}}</td></tr>
             <tr><td>Pays</td><td>{{$commmandeDetails['pays']}}</td></tr>
             <tr><td>Rue</td><td>{{$commmandeDetails['rue']}}</td></tr>
             <tr><td>Code postale</td><td>{{$commmandeDetails['codepostal']}}</td></tr>
             <tr><td>Telephone</td><td>{{$commmandeDetails['telephone']}}</td></tr>

       </table>
    </div>
   </div>
  </div>
 </div>
    <!-- Cart-Page /- -->
 @endsection