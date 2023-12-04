@extends('admin.layout.layout')
@section('content')
<div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-md-12 grid-margin">
              <div class="row">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                  <h4 class="font-weight-bold">Produits</h4>
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
                  <h4 class="card-title">{{$title}}</h4>
                          @if($errors->any())
                         <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                @foreach($errors->all() as $error)
                                   <li>{{ $error }}</li>
                                   @endforeach
                                   <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; right: 0; top: 0;">
                                   <span aria-hidden="true">&times;</span>
                                </button>
                             </div>
                             @endif
                         <form class="forms-sample" @if(empty($product['id'])) 
                                        action="{{url('admin/add-edit-product')}}"
                                @else 
                                  action="{{url('admin/add-edit-product/'.$product['id'])}}"
                                    @endif
                                  method="post" enctype="multipart/form-data" >
                                @csrf   
                             <div class="form-group">
                              <label for="category_id">Selectioné Categorie</label>
                                <select  class="form-control" id="category_id" name="category_id"  style="color: #000;" >
                                  <option value="">Selecte</option>
                                      @foreach($categories as $section)
                                      <optgroup label="{{$section['nom']}}">Selecte</optgroup>
                                        @foreach($section['categories'] as $category)
                                         <option value="{{$category['id']}}" @if(!empty($product['category_id']==
                                         $category['id']) ) selected="" @endif>
                                         &nbsp;&nbsp;&nbsp;--&nbsp;{{$category['category_nom']}}</option>
                                           @foreach($category['subcategories'] as $subcategory)
                                             <option value="{{$subcategory['id']}}" @if(!empty($product['category_id']==
                                             $subcategory['id']) ) selected="" @endif>&nbsp;&nbsp;
                                           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;---&nbsp;{{$subcategory['category_nom']}}</option>
                                           @endforeach
                                        @endforeach
                                      @endforeach
                              </select>
                             </div>

                             <div class="form-group">
                              <label for="marque_id">Selectioné la marque</label>
                                <select  class="form-control" id="marque_id" name="marque_id"  style="color: #000;" >
                                  <option value="">Selecte</option>
                                      @foreach($marques as $marque)
                                        <option value="{{$marque['id']}}" 
                                        @if(!empty($product['marque_id']==$marque['id']) ) selected="" @endif>{{$marque['nom']}}</option>
                                      @endforeach

                              </select>
                             </div>
               
                                

                            <div class="form-group">
                              <label for="product_name">Nom du produit</label>
                                <input type="text" class="form-control" id="product_name" name="product_name" placeholder="Entrer le nom du produit"
                                @if(!empty($product['product_name']) ) value="{{$product['product_name']}}" @else value="{{old('product_name')}}" @endif>
                             </div>

                             <div class="form-group">
                              <label for="product_code">Code du produit</label>
                                <input type="text" class="form-control" id="product_code" name="product_code"  placeholder="Entrer le Code du produit"
                                @if(!empty($product['product_code']) ) value="{{$product['product_code']}}" @else value="{{old('product_code')}}" @endif>
                             </div>

                             <div class="form-group">
                              <label for="product_color">Couleur du produit</label>
                                <input type="text" class="form-control" id="product_color" name="product_color" color="product_color" placeholder="Entrer la Couleur du produit"
                                @if(!empty($product['product_color']) ) value="{{$product['product_color']}}" @else value="{{old('product_color')}}" @endif>
                             </div>

                             <div class="form-group">
                              <label for="product_price'">Prix du produit</label>
                                <input type="text" class="form-control" id="product_price" name="product_price"  placeholder="Entrer le Prix du produit"
                                @if(!empty($product['product_price']) ) value="{{$product['product_price']}}" @else value="{{old('product_price')}}" @endif>
                             </div>

                             
                             <div class="form-group">
                              <label for="product_discount">Réduction sur le produit</label>
                                <input type="text" class="form-control" id="product_discount" name="product_discount"  placeholder="Entrer la Réduction sur le produit"
                                @if(!empty($product['product_discount']) ) value="{{$product['product_discount']}}" @else value="{{old('product_discount')}}" @endif>
                             </div>

                             <div class="form-group">
                              <label for="product_weight">poids du produit</label>
                                <input type="text" class="form-control" id="product_weight"  name="product_weight"  placeholder="Entrer le poids du produit"
                                @if(!empty($product['product_weight']) ) value="{{$product['product_weight']}}" @else value="{{old('product_weight')}}" @endif>
                             </div>

                             <div class="form-group">
                              <label for="group_code">code de groupe</label>
                                <input type="text" class="form-control" id="group_code"  name="group_code"  placeholder="Entrer le code de groupe"
                                @if(!empty($product['group_code']) ) value="{{$product['group_code']}}" @else value="{{old('group_code')}}" @endif>
                             </div>

                             <div class="form-group">
                                <label for="admin_image">Product image (Recommended SIze: 1000x1000)</label>
                                <input type="file" class="form-control" id="product_image" name="product_image" placeholder="">
                             @if(!empty($product['product_image']))
                             <a target="blank" href="{{ url('front/images/product_images/large/'.$product['product_image'])}}">Voir photo</a>&nbsp;|&nbsp;
                             <a class="confirmDelete" href="javascript:void(0)" module="product-image" moduleid="{{ $product['id'] }}">
                                  Supprimer l'image
                              </a>
                             @endif
                             </div>

                             <div class="form-group">
                                <label for="admin_image">Product videos (Recommended SIze: less them 2MB)</label>
                                <input type="file" class="form-control" id="product_videos" name="product_videos" placeholder="">
                             @if(!empty($product['product_videos']))
                             <a target="blank" href="{{ url('front/videos/product_videos/'.$product['product_videos'])}}">Suivre Videos</a>&nbsp;|&nbsp;
                             <a class="confirmDelete" href="javascript:void(0)" module="product-videos" moduleid="{{ $product['id'] }}">
                                  Supprimer la videos
                              </a>
                             @endif
                             </div>

                             <div class="form-group">
                                 <label for="product_discount">Description</label><br>
                                 <textarea name="description" id="description" class="form-control" rows="3">{{$product['description']}}</textarea>
                             </div>

                             <div class="form-group">
                                   <label for="is_featurred">Est en vedette</label>
                                    <input type="checkbox" name="is_featurred" id="is_featurred" value="Yes"
                                   @if(!empty($product['is_featurred']) && $product['is_featurred']=="Yes" ) checked="" @endif >                                                               
                              </div>

                              <div class="form-group">
                                   <label for="is_bestseller">meilleure vente</label>
                                    <input type="checkbox" name="is_bestseller" id="is_bestseller" value="Yes"
                                   @if(!empty($product['is_bestseller']) && $product['is_bestseller']=="Yes" ) checked="" @endif >                                                               
                              </div>

                           <button type="submit" class="btn btn-primary mr-2">Submit</button>
                           <button type="reset" class="btn btn-light">Cancel</button>
                        </form>
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
