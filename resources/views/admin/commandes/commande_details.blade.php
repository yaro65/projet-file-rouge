<?php use App\Models\Product; ?>
@extends('admin.layout.layout')
@section('content')

<div class="main-panel">

        <div class="content-wrapper">
          <div class="row">
         
            <div class="col-md-12 grid-margin">
            @if (Session::has('success_message'))
                             <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>Success:</strong> {{ Session::get('success_message')}}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; right: 0; top: 0;">
                                   <span aria-hidden="true">&times;</span>
                                </button>
                             </div>
                     @endif
              <div class="row">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                  <h3 class="font-weight-bold">Detail #{{$commandeDetails['id']}} Commande</h3>
                  <h6 class="font-weight-normal mb-0"><a href="{{url('admin/commandes')}}">Back to order</a></h6>
                  <!-- <h6 class="font-weight-normal mb-0">Modifier le mot de passe</h6> -->
                </div>
                <div class="col-12 col-xl-4">
                 <div class="justify-content-end d-flex">
                  <div class="dropdown flex-md-grow-1 flex-xl-grow-0">
                    <button class="btn btn-sm btn-light bg-white dropdown-toggle" type="button" id="dropdownMenuDate2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                     <i class="mdi mdi-calendar"></i> Today (10 Jan 2021)
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuDate2">
                      <a class="dropdown-item" href="#">January - March</a>
                      <a class="dropdown-item" href="#">March - June</a>
                      <a class="dropdown-item" href="#">June - August</a>
                      <a class="dropdown-item" href="#">August - November</a>
                    </div>
                  </div>
                 </div>
                </div>
              </div>
            </div>
          </div>
         <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Détails de la commande</h4>
                    <div class="form-group" style="height:15px;">
                      <label style="font-weigth:600;">ID :</label>
                      <label>{{ $commandeDetails['id']}}</label>
                    </div>
                    <div class="form-group" style="height:15px;">
                      <label style="font-weigth:600;">Date de Commande :</label>
                      <label>{{ date('Y-m-d h:i:s', strtotime($commandeDetails['created_at']));}}</label>
                    </div>

                    <div class="form-group" style="height:15px;">
                      <label style="font-weigth:600;">Status de la Commande :</label>
                      <label>{{ $commandeDetails['commande_status']}}</label>
                    </div>

                    <div class="form-group" style="height:15px;">
                      <label style="font-weigth:600;">Total de la commande :</label>
                      <label>{{ $commandeDetails['grand_total']}}</label>
                    </div>

                    <div class="form-group" style="height:15px;">
                      <label style="font-weigth:600;">Frais de livraison :</label>
                      <label>{{ $commandeDetails['shipping_charge']}}</label>
                    </div>
                    @if(!empty($commandeDetails['coupon_code']))
                    <div class="form-group" style="height:15px;">
                      <label style="font-weigth:600;">Code de réduction :</label>
                      <label>{{ $commandeDetails['coupon_code']}}</label>
                    </div>

                    <div class="form-group" style="height:15px;">
                      <label style="font-weigth:600;">Montant du coupon :</label>
                      <label>{{ $commandeDetails['coupon_amount']}}</label>
                    </div>
                    @endif
                    <div class="form-group" style="height:15px;">
                      <label style="font-weigth:600;">Méthode de paiement :</label>
                      <label>{{ $commandeDetails['payment_method']}}</label>
                    </div>

                    <div class="form-group" style="height:15px;">
                      <label style="font-weigth:600;">Passerelle de paiement :</label>
                      <label>{{ $commandeDetails['payment_gateway']}}</label>
                    </div>

                </div>
              </div>
            </div>

            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Coordonnées du Client</h4>

                  <div class="form-group" style="height:15px;">
                      <label style="font-weigth:600;">Nom :</label>
                      <label>{{ $userDetails['name']}}</label>
                    </div>
                    @if(!empty($userDetails['address']))
                    <div class="form-group" style="height:15px;">
                      <label style="font-weigth:600;">Address :</label>
                      <label>{{ $userDetails['address']}}</label>
                    </div>
                    @endif
                    @if(!empty($userDetails['ville']))
                    <div class="form-group" style="height:15px;">
                      <label style="font-weigth:600;">Ville :</label>
                      <label>{{ $userDetails['ville']}}</label>
                    </div>
                    @endif
                    @if(!empty($userDetails['region']))
                    <div class="form-group" style="height:15px;">
                      <label style="font-weigth:600;">Region :</label>
                      <label>{{ $userDetails['region']}}</label>
                    </div>
                    @endif
                    @if(!empty($userDetails['pays']))
                    <div class="form-group" style="height:15px;">
                      <label style="font-weigth:600;">Pays :</label>
                      <label>{{ $userDetails['pays']}}</label>
                    </div>
                    @endif
                    @if(!empty($userDetails['telephone']))
                    <div class="form-group" style="height:15px;">
                      <label style="font-weigth:600;">Telephone :</label>
                      <label>{{ $userDetails['telephone']}}</label>
                    </div>
                    @endif
                    <div class="form-group" style="height:15px;">
                      <label style="font-weigth:600;">Email :</label>
                      <label>{{ $userDetails['email']}}</label>
                    </div>

                </div>
              </div>
            </div>

            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Adresse de livraison</h4>

                  <div class="form-group" style="height:15px;">
                      <label style="font-weigth:600;">Nom :</label>
                      <label>{{ $commandeDetails['name']}}</label>
                    </div>
                    @if(!empty($commandeDetails['address']))
                    <div class="form-group" style="height:15px;">
                      <label style="font-weigth:600;">Address :</label>
                      <label>{{ $commandeDetails['address']}}</label>
                    </div>
                    @endif
                    @if(!empty($commandeDetails['rue']))
                    <div class="form-group" style="height:15px;">
                      <label style="font-weigth:600;">Rue :</label>
                      <label>{{ $commandeDetails['rue']}}</label>
                    </div>
                    @endif
                    @if(!empty($commandeDetails['ville']))
                    <div class="form-group" style="height:15px;">
                      <label style="font-weigth:600;">Ville :</label>
                      <label>{{ $commandeDetails['ville']}}</label>
                    </div>
                    @endif
                    @if(!empty($commandeDetails['region']))
                    <div class="form-group" style="height:15px;">
                      <label style="font-weigth:600;">Region :</label>
                      <label>{{ $commandeDetails['region']}}</label>
                    </div>
                    @endif
                    @if(!empty($commandeDetails['pays']))
                    <div class="form-group" style="height:15px;">
                      <label style="font-weigth:600;">Pays :</label>
                      <label>{{ $commandeDetails['pays']}}</label>
                    </div>
                    @endif
                    @if(!empty($commandeDetails['codepostal']))
                    <div class="form-group" style="height:15px;">
                      <label style="font-weigth:600;">Code Postal :</label>
                      <label>{{ $commandeDetails['codepostal']}}</label>
                    </div>
                    @endif
                    @if(!empty($commandeDetails['telephone']))
                    <div class="form-group" style="height:15px;">
                      <label style="font-weigth:600;">Telephone :</label>
                      <label>{{ $commandeDetails['telephone']}}</label>
                    </div>
                    @endif
                    <div class="form-group" style="height:15px;">
                      <label style="font-weigth:600;">Email :</label>
                      <label>{{ $commandeDetails['email']}}</label>
                    </div>

                </div>
              </div>
            </div>

            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Mettre à jour le statut de la commande</h4>
                  @if(Auth::guard('admin')->user()->type!="vendeur")
                  <form action="{{url('admin/update-commande-status')}}" method="post">@csrf
                    <input type="hidden" name="commande_id" value="{{ $commandeDetails['id']}}">
                    <select name="commande_status" id="order_status" required="" >
                      <option value="" selected="">Sélectionner</option>
                      @foreach($commandesStatus as $status)
                      <option value="{{$status['name']}}" 
                      @if(!empty($commandeDetails['commande_status']) && $commandeDetails['commande_status']==$status['name'] )
                        selected="" @endif>{{$status['name']}}</option>
                      @endforeach
                    </select>
                       <input type="text" name="courier_name" id="courier_name" placeholder="Courier Name" value="">
                       <input type="text" name="tracking_number" id="tracking_number" placeholder="Courier Name" value="">
                    <button type="submit">Mettre à jour</button>
                  </form>
                  <br>
                   @foreach($commandeLog as $log)
                      <strong>{{ $log['commande_status'] }}</strong>
                      
                      @if($log['commande_status'] == "Expédié")
                          @if(!empty($log['commandes_products'][0]['product_code']))
                              <span>-Pour l'article : {{ $log['commandes_products'][0]['product_code'] }}</span>
                             
                              @if(!empty($log['commandes_products'][0]['item_courier_name']))
                              <br><span>Nom du Transporteur: {{ $log['commandes_products'][0]['item_courier_name'] }}</span>
                          @endif
                          
                          @if(!empty($log['commandes_products'][0]['item_tracking_number']))
                              <br><span>Numéro de Suivi: {{ $log['commandes_products'][0]['item_tracking_number'] }}</span>
                          @endif
                         
                      @else
                             
                          
                          @if(!empty($commandeDetails['courier_name']))
                              <br><span>Société de Livraison {{ $commandeDetails['courier_name'] }}</span>
                          @endif
                          
                          @if(!empty($commandeDetails['tracking_number']))
                              <br><span>Numéro de colis: {{ $commandeDetails['tracking_number'] }}</span>
                          @endif
                        @endif
                      @endif
                      
                      <br>{{ date('Y-m-d h:i:s', strtotime($log['created_at'])) }} <br>
                      <hr>
                  @endforeach
                  
                  @else
                  <h3  style="font-weigth:900;">Statut:</h3>
                  <table class="table">
                      <thead>
                        <tr class="table-primary">
                          <th scope="col">Code produit</th>
                          <th scope="col">Statut</th>
                        </tr>
                      </thead>
                      <tbody>
                      @foreach($commandeDetails['commandes_products'] as $product)
                        @if($commandeDetails['commandes_products'])
                        <tr>
                          <td>{{$product['product_code']}}</td>
                          <td>{{$product['item_status']}}</td>
                        </tr>
                                     
                      @endif
                    @endforeach
                    </tbody>
                   </table>
                
                 @endif

                </div>
              </div>
            </div>

            <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Order Product</h4>

            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="table-danger">
                        <tr>
                            <th>Product Image</th>
                            <th>Product Code</th>
                            <th>Product Name</th>
                            <th>Product Size</th>
                            <th>Product Color</th>
                            <th>Product Quantity</th>
                            <th>Item Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($commandeDetails['commandes_products'] as $product)
                        @if($commandeDetails['commandes_products'])
                        <tr>
                            <td>
                                @php $getProductImage = Product::getProductImage($product['product_id']) @endphp
                                <a target="_blank" href="{{url('product/'.$product['product_id'])}}">
                                    <img src="{{asset('front/images/product_images/small/'.$getProductImage)}}" alt="">
                                </a>
                            </td>
                            <td>{{$product['product_code']}}</td>
                            <td>{{$product['product_name']}}</td>
                            <td>{{$product['product_size']}}</td>
                            <td>{{$product['product_color']}}</td>
                            <td>{{$product['product_qty']}}</td>
                            <td>
                                <form action="{{url('admin/update-commande-item-status')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="commande_item_id" value="{{ $product['id']}}">
                                    <select name="commande_item_status" id="commande_item_status" class="form-control" required="">
                                        <option value="">Sélectionner</option>
                                        @foreach($commandeItemStatus as $status)
                                        <option value="{{$status['name']}}" @if(!empty($product['item_status']) && $product['item_status']==$status['name'] ) selected="" @endif>{{$status['name']}}</option>
                                        @endforeach
                                    </select>
                                    <input type="text" name="item_courier_name" id="item_courier_name" class="form-control" placeholder="Courier Name">
                                    <input type="text" name="item_tracking_number" id="item_tracking_number" class="form-control" placeholder="Courier Name">
                                    <button type="submit" class="btn btn-primary">Valider</button>
                                </form>
                            </td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

          </div>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        @include('admin.layout.footer')
        <!-- partial -->
 </div>


@endsection
