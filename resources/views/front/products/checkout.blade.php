<?php use App\Models\Product; ?>
@extends('front.layout.layout')
 @section('content')
    <!-- Page Introduction Wrapper -->
    <div class="page-style-a">
        <div class="container">
            <div class="page-intro">
                <h2>Passer à la caisse</h2>
                <ul class="bread-crumb">
                    <li class="has-separator">
                        <i class="ion ion-md-home"></i>
                        <a href="{{url('/')}}">Home</a>
                    </li>
                    <li class="is-marked">
                        <a href="checkout.html">Passer à la caisse</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Page Introduction Wrapper /- -->
    <!-- Checkout-Page -->
    <div class="page-checkout u-s-p-t-80">
        <div class="container">
        @if (Session::has('error_message'))
             <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error:</strong> <?php echo Session::get('error_message'); ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; right: 0; top: 0;">
                   <span aria-hidden="true">&times;</span>
                </button>
             </div>
        @endif
            <div class="row">
                <div class="col-lg-12 col-md-12">
                        <div class="row">
                            <!-- Billing-&-Shipping-Details -->
                            <div class="col-lg-6" id="deliveryAddresses">
                                @include('front.products.delivery_address')
                                
                            </div>
                            <!-- Billing-&-Shipping-Details /- -->
                            <!-- Checkout -->

                            <div class="col-lg-6">
                            <form name="checkoutForm" id="checkoutForm" action="{{url('/checkout')}}"  method="post">@csrf
                              
                            @if (count($deliveryAddresses)>0)
                              <h4 class="section-h4">Adresse de livraison</h4>
                                @foreach($deliveryAddresses as $address)       
                                   <div class="control-group" style="float: left; margin-right:10px">
                                      <input type="radio" name="address_id" id="address{{ $address['id']}}"
                                          value="{{$address['id']}}" shipping_charges="{{$address['shipping_charges']}}"
                                           total_price="{{$total_price}}" coupon_amount="{{Session::get('couponAmount')}}">
                                        </div>
                                  <div>
                                      <label for="" class="control-label">{{ $address['name']}},{{ $address['address']}},
                                      {{ $address['codepostal']}},{{ $address['ville']}},{{ $address['pays']}},
                                      ({{ $address['telephone']}})
                                      </label>
                                      <div style="float: right;">
                                      <a  href="javascript:;" data-addressid="{{ $address['id'] }}" class="removeAddress">Suprimer</a>
                                      <a  href="javascript:;" data-addressid="{{ $address['id'] }}" class="editAddress">Modifier</a>
                                      </div>
                                  </div>
                                @endforeach<br>
                              @endif
                            
                            <h4 class="section-h4">Votre commande</h4>
                                <div class="order-table">
                                    <table class="u-s-m-b-13">

                                        <thead>
                                            <tr>
                                                <th>Produit</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                             @php $total_price = 0 @endphp
                                               @foreach($getPanierItems as $item)
                                               <?php 
                                               $getDiscountAttributePrice = Product::getDiscountAttributePrice($item['product_id'], $item['size']);
                                               ?>
                                            <tr>
                                                <td>
                                                <a href="{{url('product/'.$item['product_id'])}}">
                                                     <img width="30" src="{{asset('front/images/product_images/small/'.$item['product']['product_image'])}}" alt="Product">
                                                    <h6 class="order-h6">{{$item['product']['product_name']}}    X</h6></a>
                                                    <span class="order-span-quantity">  {{$item['quantity']}}</span>
                                                </td>
                                                <td>
                                                    <h6 class="order-h6">Fr.{{ $getDiscountAttributePrice['final_price'] * $item['quantity'] }}</h6>
                                                </td>
                                            </tr>
                                            @php $total_price = $total_price + ($getDiscountAttributePrice['final_price'] * $item['quantity']) @endphp
                                            @endforeach
                                            <tr>
                                                <td>
                                                    <h3 class="order-h3">Sous-total</h3>
                                                </td>
                                                <td>
                                                    <h3 class="order-h3">{{$total_price}} Fr cfa</h3>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <h6 class="order-h6">Frais d'expédition</h6>
                                                </td>
                                                <td>
                                                    <h6 class="order-h6"><strong class="shipping_charges">.Fr
                                                    </strong></h6>
                                                </td>
                                                <tr>
                                                <td>
                                                    <h6 class="order-h6">Coupon de  Réduction</h6>
                                                </td>
                                                <td>
                                                    <h6 class="order-h6">
                                                         @if(Session::has('couponAmount'))
                                                       <strong class="couponAmount">
                                                         Fr.{{ Session::get('couponAmount')}}
                                                       </strong> 
                                                      @else
                                                     Fr.0
                                                   @endif</h6>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <h3 class="order-h3">Total</h3>
                                                </td>
                                                <td>
                                                    <h3 class="order-h3"><strong class="grand_total">
                                                    {{$total_price - Session::get('couponAmount')}} .Fr
                                                    </strong>
                                                       </h3>
                                                </td>
                                            </tr>
                                        </tbody>

                                    </table>
                                    <div class="u-s-m-b-13">
                                        <input type="radio" class="radio-box" name="payment_gateway"  id="cash-on-delivery" value="COD">
                                        <label class="label-text" for="cash-on-delivery">Paiement à la livraison</label>
                                    </div>
                                    <div class="u-s-m-b-13">
                                        <input type="radio" class="radio-box" name="payment_gateway"  id="paypal" value="Paypal">
                                        <label class="label-text" for="paypal">Paypal</label>
                                    </div>
                                    <div class="u-s-m-b-13">
                                        <input type="checkbox" class="check-box" id="accept"
                                        name="accept" value="Yes" title="Veuillez accepter les termes et conditions">
                                        <label class="label-text no-color" for="accept">J'ai lu et j'accepte les
                                            <a href="terms-and-conditions.html" class="u-c-brand">terms & conditions</a>
                                        </label>
                                    </div>
                                    <button type="submit" id="placerCommande" class="button button-outline-secondary">Passer la commande</button>
                                </div>
                            </form>
                            </div>

                            <!-- Checkout /- -->
                        </div>
                </div>
            </div>
           
        </div>
    </div>
    <!-- Checkout-Page /- -->
 @endsection