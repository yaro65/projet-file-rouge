@extends('admin.layout.layout')
@section('content')
<div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Commandes</h4>
                  <!-- <p class="card-description">
                    Add class <code>.table-bordered</code>
                  </p> --> 
                  <div class="table-responsive pt-3">
                    <table id="commandes" class="table table-bordered">
                      <thead>
                        <tr>
                          <th>
                            ID
                          </th>
                          <th>
                            Commande Date
                          </th>
                          <th>
                            Customers Name
                          </th>
                          <th>
                          Customers Email
                          </th>
                          <th>
                            Ordered Product
                          </th>
                          <th>
                            Order Amount
                          </th>
                          <th>
                            Order Status
                          </th>
                          <th>
                           Payment Method
                          </th>
                          <th>
                            Actions
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($commandes as $commande)
                        @if($commande['commandes_products'])
                        <tr>
                          <td>
                            {{ $commande['id'] }}
                          </td>
                          <td>
                          {{ date('Y-m-d h:i:s', strtotime($commande['created_at']));}}
                          </td>
                          <td>
                            {{ $commande['name']}}
                          </td>
                          <td>
                            {{ $commande['email']}}
                          </td>
                          <td>
                          @foreach($commande['commandes_products'] as $product)
                               {{$product['product_code']}} ({{$product['product_qty']}})<br>
                          @endforeach
                          </td>
                          <td>
                            {{ $commande['grand_total']}}
                          </td>
                          <td>
                            {{ $commande['commande_status']}}
                          </td>
                          <td>
                            {{ $commande['payment_method']}}
                          </td>
                          <td>
                             <a title=" Voir les détails de la commande" href="{{url('admin/commandes/'.$commande['id'] )}}">
                             <i  style="font-size: 25px;" class="mdi mdi-file-document"></i>
                              </a>
                              &nbsp; &nbsp; 
                              <a title=" Voir la facture de la commande" href="{{url('admin/view/commande/invoice/'.$commande['id'] )}}">
                             <i  style="font-size: 25px;" class="mdi mdi-printer"></i>
                              </a>
                              &nbsp; &nbsp; 
                              <a title=" Voir la facture de la commande" href="{{url('admin/commande/pdf/'.$commande['id'] )}}">
                             <i  style="font-size: 25px;" class="mdi mdi-file-pdf"></i>
                              </a>
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
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:../../partials/_footer.html -->
        <footer class="footer">
          <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2021.  Premium <a href="https://www.bootstrapdash.com/" target="_blank">Bootstrap section template</a> from BootstrapDash. All rights reserved.</span>
            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with <i class="ti-heart text-danger ml-1"></i></span>
          </div>
        </footer>
        <!-- partial -->
</div>

 @endsection
