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
                  <h4 class="card-title">Modifier le mot de passe</h4>

                         @if (session('success'))
                             <div class="alert alert-success">
                              {{ session('success') }}
                             </div>
                           @endif
                           @if (session('error'))
                             <div class="alert alert-success">
                              {{ session('error') }}
                             </div>
                           @endif
                  <form class="forms-sample" action="{{url('admin/paramettre/pasword')}}" method="post">
                    @csrf
                    <div class="form-group" >
                      <label>Admin nom d'utilisateur/Email</label>
                      <input type="email" class="form-control"  value="{{$adminDetails['email']}}">
                    </div>
                    <div class="form-group">
                      <label >Admin type</label>
                      <input type="text" class="form-control" value="{{$adminDetails['type']}}">
                    </div>
                    <div class="form-group">
                      <label for="current_Password">Actuel mode passe</label>
                      <input type="password" class="form-control" id="current_password" name="current_Password" placeholder="Entrer mode passe">
                      <div id="check_password"></div>
                    <div class="form-group">
                      <label for="new_password">Nouveau mot de passe</label>
                      <input type="password" class="form-control" id="new_password" name="new_password" placeholder="Le Mot de Passe">
                    </div>
                    <div class="form-group">
                      <label for="confirm_password">Confirmer le mot de passe</label>
                      <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Comfimer Mot de Passe">
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