@extends('admin.layout.layout')
@section('content')
<div class="main-panel">

        <div class="content-wrapper">
          <div class="row">
            <div class="col-md-12 grid-margin">
              <div class="row">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                  <h3 class="font-weight-bold">Paramètre</h3>
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
                  <h4 class="card-title">Modifier les details de l'admin</h4>

                         @if (session('success'))
                             <div class="alert alert-success">
                                <button type="button" class="Close" data-dismiss="alert" aria-label="Close">
                                   <span aria-hidden="true">&times;</span>
                                </button>
                              {{ session('success') }}
                             </div>
                           @endif
                           @if (session('error'))
                             <div class="alert alert-success">
                              {{ session('error') }}
                             </div>
                           @endif
                  <form class="forms-sample" action="{{url('admin/paramettre')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group" >
                      <label>Admin nom d'utilisateur/Email</label>
                      <input type="email" class="form-control"  value="{{Auth::guard('admin')->user()->email}}" readonly="">
                    </div>
                    <div class="form-group">
                      <label >Admin type</label>
                      <input type="text" class="form-control"  value="{{Auth::guard('admin')->user()->type}}" >
                    </div>

                    <div class="form-group">
                      <label for="admin_name">Nom</label>
                      @error('admin_name')
                             <div class="text text-danger">
                             {{$message}}
                           </div>
                      @enderror
                      <input type="text" class="form-control" id="admin_name" name="admin_name" placeholder=""
                      value="{{Auth::guard('admin')->user()->nom}}" >
                      <div id="check_password"></div>
                    <div class="form-group">
                      <label for="admin_mobile">Mobile</label>
                      @error('admin_mobile')
                             <div class="text text-danger">
                             {{$message}}
                           </div>
                      @enderror
                      <input type="text" class="form-control" id="admin_mobile" name="admin_mobile" placeholder=""
                      value="{{Auth::guard('admin')->user()->telephone}}" maxlentgh="10"
                      minlentgh="10">
                    </div>

                    <div class="form-group">
                      <label for="admin_image">Admin photo</label>
                      <input type="file" class="form-control" id="admin_image" name="admin_image" placeholder="">
                          @if(!empty(Auth::guard('admin')->user()))
                           <a target="_blank" href="{{ url('admin/images/photos/' . Auth::guard('admin')->user()->image) }}">Voir l'image</a>
                           <input type="hidden" name="current_admin_image" value="{{ Auth::guard('admin')->user()->image }}">
                       @endif
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
<!-- 
@if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                  @foreach ($errors->all() as $error)
                                      <li>{{ $error }}</li>
                                  @endforeach
                               <button type="button" class="Close" data-dismiss="alert" aria-label="Close">
                                   <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                      @endif -->