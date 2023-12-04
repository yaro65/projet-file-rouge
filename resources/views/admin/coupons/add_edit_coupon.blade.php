@extends('admin.layout.layout')
@section('content')
<div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-md-12 grid-margin">
              <div class="row">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                  <h4 class="font-weight-bold">Coupons</h4>
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
                            
                            
                         <form class="forms-sample" @if(empty($coupon['id'])) 
                                        action="{{url('admin/add-edit-coupon')}}"
                                @else 
                                  action="{{url('admin/add-edit-coupon/'.$coupon['id'])}}"
                                    @endif
                                  method="post" enctype="multipart/form-data" >
                                @csrf 
                                @if(empty($coupon['coupon_code']))
                                <div class="form-group">
                                <label for="coupon_option">Coupon Option</label> <br>
                                <span><input type="radio" name="coupon_option" id="AutomaticCoupon"
                                value="Automatic" checked="">&nbsp;Automatique&nbsp;&nbsp;
                                <span><input type="radio" name="coupon_option" id="ManualCoupon"
                                value="Manual">&nbsp;Manuel&nbsp;&nbsp;
                                </div>  

                                <div class="form-group" style="display: none;" id="couponField">
                                  <label for="coupon_code">Coupon Code</label>
                                  <input type="text" name="coupon_code" class="form-control" 
                                   id="coupon_code"  placeholder="Entrer le Coupon Code">
                                </div>
                                @else
                                <input type="hidden" name="coupon_option" value="{{$coupon['coupon_option']}}">
                                 <input type="hidden" name="coupon_code" value="{{$coupon['coupon_code']}}">
                                 <div class="form-group">
                                    <label for="coupon_code">Code Coupon:</label>
                                    <span>{{$coupon['coupon_code']}}</span>
                                 </div>
                                @endif

                                <div class="form-group">
                                <label for="coupon_type">Coupon type </label> <br>
                                <span><input type="radio" name="coupon_type"
                                value="Plusieurs fois" 
                                 @if(isset($coupon['coupon_type'])&&$coupon['coupon_type']=="Plusieurs fois")
                                 checked=""@endif >&nbsp;Plusieurs fois&nbsp;&nbsp;
                                
                                <span><input type="radio" name="coupon_type" 
                                value="Une seule fois" @if(isset($coupon['coupon_type'])&&$coupon['coupon_type']=="Une seule fois")
                                checked="" @endif >&nbsp;Une seule fois&nbsp;&nbsp;
                                </div>  

                                <div class="form-group">
                                <label for="amount_type">amount type </label> <br>
                                <span><input type="radio" name="amount_type"
                                value="Pourcentage" @if(isset($coupon['amount_type'])&&$coupon['amount_type']=="Pourcentage")
                                 checked="" @endif >&nbsp;Pourcentage&nbsp;(En %)&nbsp;
                                
                                <span><input type="radio" name="amount_type"
                                value="Fixed" @if(isset($coupon['amount_type'])&&$coupon['amount_type']=="Fixed")
                                checked=""  @endif>&nbsp;Fixe&nbsp;&nbsp;(En Fr.cfa)
                                </div>

                                <div class="form-group">
                              <label for="amount">Montant</label>
                                <input type="text" class="form-control" id="amount" name="amount" placeholder="Entrer le Montant"
                                 @if(isset($coupon['amount'])) value="{{$coupon['amount']}}"
                                 @else value="{{old('amount')}}" @endif>
                             </div>

                             <div class="form-group">
                              <label for="categories">Selectioné Categorie</label>
                                <select  class="form-control text-dark" name="categories[]" multiple="">
                                      @foreach($categories as $section)
                                      <optgroup label="{{$section['nom']}}">Selecte</optgroup>
                                        @foreach($section['categories'] as $category)
                                         <option value="{{$category['id']}}" @if(in_array($category['id'], $selPanier))
                                            selected="" @endif>
                                         &nbsp;&nbsp;&nbsp;--&nbsp;{{$category['category_nom']}}</option>
                                           @foreach($category['subcategories'] as $subcategory)
                                             <option value="{{$subcategory['id']}}" @if(in_array($subcategory['id'], $selPanier))
                                            selected="" @endif>&nbsp;&nbsp;
                                           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;---&nbsp;{{$subcategory['category_nom']}}</option>
                                           @endforeach
                                        @endforeach
                                      @endforeach
                              </select>
                             </div>

                             <div class="form-group">
                              <label for="marques">Selectioné la marque</label>
                                <select  class="form-control text-dark" name="marques[]"   multiple="">
                                      @foreach($marques as $marque)
                                         <option value="{{$marque['id']}}" @if(in_array($marque['id'], $selMarque))
                                            selected="" @endif  >{{$marque['nom']}}</option>
                                      @endforeach
                              </select>
                             </div>

                             <div class="form-group">
                              <label for="users">Selectioné l'utilisateur</label>
                                <select  class="form-control text-dark" name="users[]"   multiple="">
                                      @foreach($users as $user)
                                        <option value="{{$user['email']}}"  @if(in_array($user['email'], $selUser))
                                            selected="" @endif >{{$user['email']}}</option>
                                      @endforeach
                              </select>
                             </div>

                             <div class="form-group">
                              <label for="expiry_date">Date d'expiration</label>
                                <input type="date" class="form-control" id="expiry_date" name="expiry_date" placeholder="Entrer la date"
                                @if(isset($coupon['expiry_date'])) value="{{$coupon['expiry_date']}}"
                                 @else value="{{old('expiry_date')}}" @endif>
                                 
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
