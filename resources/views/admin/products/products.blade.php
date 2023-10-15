@extends('admin.layout.layout')
@section('content')
<div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Products</h4>
                  <!-- <p class="card-description">
                    Add class <code>.table-bordered</code>
                  </p> --> 

                  <a style="max-width: 170px ;  float: right; display:inline-block;" href="{{ url('admin/add-edit-product')}}" class="btn btn-block btn-primary">Ajouter Categorie</a>

                  @if (Session::has('success_message'))
                             <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>Success:</strong> {{ Session::get('success_message')}}
                                <button type="button" class="Close" data-dismiss="alert" aria-label="Close">
                                   <span aria-hidden="true">&times;</span>
                                </button>
                             </div>
                     @endif


                  <div class="table-responsive pt-3">
                    <table id="products" class="table table-bordered">
                      <thead>
                        <tr>
                          <th>
                            ID
                          </th>
                          <th>
                               Product Name
                          </th>
                          <th>
                          Product code
                          </th>
                          <th>
                          Product color
                          </th>
                          <th>
                          Product image
                          </th>
                          <th>
                          Categorie
                          </th>
                          <th>
                          Section
                          </th>
                          <th>
                          Added by 
                          </th>
                          <th>
                            Status
                          </th>
                          <th>
                            Actions
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                      @foreach($products as $product)
                      <tr>
                          <td>
                              {{ $product['id'] }}
                          </td>
                          <td>
                              {{ $product['product_name'] }}
                          </td>
                          <td>
                              {{ $product['product_code'] }}
                          </td>
                          <td>
                              {{ $product['product_color'] }}
                          </td>
                          <td>
                             @if(!empty($product['product_image']))
                             <img
                               style="width: 90px; height: 120px;"
                             src="{{ asset('front/images/product_images/small/'.$product['product_image'])}}" >
                             @else
                             <img class="rounded"
                             style="width: 90px; height: 120px;"
                             src="{{ asset('front/images/product_images/small/Noimage.png')}}" >
                             @endif
                          </td>
                          <td>
                              {{ $product['category']['category_nom'] }}
                          </td>
                          <td>
                               {{ $product['section']['nom'] }}
                          </td>
                          <td>
                              @if($product['admin_type']=="vendeur")
                              <a target="_blank" href="{{ url('admin/view-mdifier-fournisseur/'.$product['admin_id']) }}">
                                {{ ucfirst($product['admin_type']) }}</a>
                              @else
                                {{  ucfirst($product['admin_type']) }}
                              @endif
                          </td>
                          <td>
                              @if($product['status'] == 1)
                                  <a class="updateProductStatus" id="product-{{ $product['id'] }}" product_id="{{ $product['id'] }}" href="javascript:void(0)">
                                      <i style="font-size: 25px;" class="mdi mdi-bookmark-check" status="Active"></i>
                                  </a>
                              @else
                                  <a class="updateProductStatus" id="product-{{ $product['id'] }}" product_id="{{ $product['id'] }}" href="javascript:void(0)">
                                      <i style="font-size: 25px;" class="mdi mdi-bookmark-outline" status="Inactive"></i>
                                  </a>
                              @endif
                          </td>
                          <td>
                              <a  title="Edit Product" href="{{ url('admin/add-edit-product/'.$product['id']) }}">
                                  <i style="font-size: 25px;" class="mdi mdi-pencil-box"></i>
                              </a>
                              <a  title="Add Attributes" href="{{ url('admin/add-edit-attributes/'.$product['id']) }}">
                                  <i style="font-size: 25px;" class="mdi mdi-plus-box"></i>
                              </a>

                              <a title="Add Multiple Images" href="{{ url('admin/add-images/'.$product['id']) }}">
                                  <i style="font-size: 25px;" class="mdi mdi-library-plus"></i>
                              </a>

                                 <a  title="Supprimer Product"  class="confirmDelete" href="javascript:void(0)" module="product" moduleid="{{ $product['id'] }}">
                                  <i style="font-size: 25px;" class="mdi mdi-file-excel-box"></i>
                              </a>
                          </td>
                      </tr>
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
