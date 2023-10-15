@extends('admin.layout.layout')
@section('content')

<div class="main-panel">

        <div class="content-wrapper">
          <div class="row">
            <div class="col-md-12 grid-margin">
              <div class="row">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                  <h3 class="font-weight-bold">Detail du Vendeur</h3>
                  <h6 class="font-weight-normal mb-0"><a href="{{url('admin/admins/fournisseure')}}">Retour</a></h6>
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
                  <h4 class="card-title">Info du vendeur</h4>
                    <div class="form-group" >
                      <label>Adress email</label>
                      <input type="email" class="form-control"  value="{{$fournisseureDetail['fournisseure_profile']['email']}}" readonly="">
                    </div>

                    <div class="form-group">
                    <label>Nom</label>
                      <input type="text" class="form-control"  value="{{$fournisseureDetail['fournisseure_profile']['nom']}}" readonly="">
                    </div>

                    <div class="form-group">
                      <label>Adresse</label>
                      <input type="text" class="form-control" value="{{$fournisseureDetail['fournisseure_profile']['address']}}" readonly="">
                    </div>
                

                    <div class="form-group">
                      <label>Ville</label>
                      <input type="text" class="form-control"  value="{{$fournisseureDetail['fournisseure_profile']['ville']}}" readonly="">
                     </div>

                    <div class="form-group">
                      <label>Secteur</label>
                      <input type="text" class="form-control" value="{{$fournisseureDetail['fournisseure_profile']['secteur']}}" readonly="">
                    </div>
                    

                    <div class="form-group">
                      <label for="fournisseure_telephone">Telephone</label>
                      <input type="text" class="form-control" value="{{$fournisseureDetail['fournisseure_profile']['telephone']}}" readonly="">
                   </div>

                    <div class="form-group">
                      <label for="fournisseure_status">Status</label>
                      <input type="text" class="form-control" value="{{$fournisseureDetail['fournisseure_profile']['status']}}" readonly="">
                    </div>
                      @if(!empty($fournisseureDetail['image']))
                    <div class="form-group">
                      <label for="fournisseure_image">Photo</label>
                      <br>
                      <img  style="width: 200px;" src="{{ url('admin/images/photos/'.$fournisseureDetail['image'])}}" readonly="">
                    </div>
                    @endif
                </div>
              </div>
            </div>

            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Info du Boutique</h4>
                    <div class="form-group" >
                      <label>Email</label>
                      <input type="email" class="form-control"  value="{{$fournisseureDetail['fournisseure_boutique']['email_de_boutique']}}" readonly="">
                    </div>

                    <div class="form-group">
                    <label>Nom</label>
                      <input type="text" class="form-control"  value="{{$fournisseureDetail['fournisseure_boutique']['nom_de_boutique']}}" readonly="">
                    </div>

                    <div class="form-group">
                      <label>Adresse</label>
                      <input type="text" class="form-control" value="{{$fournisseureDetail['fournisseure_boutique']['adresse_de_boutique']}}" readonly="">
                    </div>
                

                    <div class="form-group">
                      <label>Ville</label>
                      <input type="text" class="form-control"  value="{{$fournisseureDetail['fournisseure_boutique']['ville_de_boutique']}}" readonly="">
                     </div>

                    <div class="form-group">
                      <label>Secteur</label>
                      <input type="text" class="form-control" value="{{$fournisseureDetail['fournisseure_boutique']['secteur_de_boutique']}}" readonly="">
                    </div>
                    

                    <div class="form-group">
                      <label for="fournisseure_telephone">Telephone</label>
                      <input type="text" class="form-control" value="{{$fournisseureDetail['fournisseure_boutique']['tell_de_boutique']}}" readonly="">
                   </div>

                    <div class="form-group">
                      <label for="fournisseure_status">document_de_boutique</label>
                      <input type="text" class="form-control" value="{{$fournisseureDetail['fournisseure_boutique']['document_de_boutique']}}" readonly="">
                    </div>
                      @if(!empty($fournisseureDetail['fournisseure_boutique']['photos_de_boutique']))
                    <div class="form-group">
                      <label for="fournisseure_image">Photo</label>
                      <br>
                      <img  style="width: 200px;" src="{{ url('admin/images/preuve/'.$fournisseureDetail['fournisseure_boutique']['photos_de_boutique'])}}" readonly="">
                    </div>
                    @endif
                </div>
              </div>
            </div>

            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Info Bank</h4>

                    <div class="form-group">
                    <label>Nom du titulaire</label>
                      <input type="text" class="form-control"  value="{{$fournisseureDetail['fournisseure_bank']['nom_du_titulaire_du_compte']}}" readonly="">
                    </div>

                    <div class="form-group">
                      <label>Bank</label>
                      <input type="text" class="form-control" value="{{$fournisseureDetail['fournisseure_bank']['nom_de_la_bank']}}" readonly="">
                    </div>
                

                    <div class="form-group">
                      <label>Numero Bank</label>
                      <input type="text" class="form-control"  value="{{$fournisseureDetail['fournisseure_bank']['numero_de_compte']}}" readonly="">
                     </div>

                    <div class="form-group">
                      <label>Bank IFSC CODE</label>
                      <input type="text" class="form-control" value="{{$fournisseureDetail['fournisseure_bank']['bank_ifsc_code']}}" readonly="">
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
