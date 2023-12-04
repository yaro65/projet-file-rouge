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
          @if($slug=="profile")
          <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Modifier Le Profile</h4>

                         @if (Session::has('error_message'))
                         <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error:</strong> {{ Session::get('error_message')}}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; right: 0; top: 0;">
                               <span aria-hidden="true">&times;</span>
                            </button>
                         </div>
                         @endif
                          @if (session('success'))
                             <div class="alert alert-success">
                             <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; right: 0; top: 0;">
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
                  <form class="forms-sample" action="{{url('mdifier_fournisseur/profile')}}" method="post" enctype="multipart/form-data">
                       @csrf
                    <div class="form-group" >
                      <label>Fournisseure nom d'utilisateur/Email</label>
                      <input type="email" class="form-control"  value="{{Auth::guard('admin')->user()->email}}" readonly="">
                    </div>

                    <div class="form-group">
                      <label for="fournisseure_nom">Nom</label>
                      @error('fournisseure_nom')
                             <div class="text text-danger">
                             {{$message}}
                           </div>
                      @enderror
                      <input type="text" class="form-control" id="fournisseure_nom" name="fournisseure_nom" placeholder=""
                      value="{{Auth::guard('admin')->user()->nom}}" >
                      <div id="check_password"></div>
                    <div class="form-group">


                    <div class="form-group">
                      <label for="fournisseure_address">Adresse</label>
                      @error('fournisseure_address')
                             <div class="text text-danger">
                             {{$message}}
                           </div>
                      @enderror
                      <input type="text" class="form-control" id="fournisseure_address" name="fournisseure_address" placeholder=""
                      value="{{$vendeurDetails['address']}}" >
                      <div id="check_password"></div>
                    <div class="form-group">

                    <div class="form-group">
                      <label for="fournisseure_ville">Ville</label>
                      @error('fournisseure_ville')
                             <div class="text text-danger">
                             {{$message}}
                           </div>
                      @enderror
                      <input type="text" class="form-control" id="fournisseure_ville" name="fournisseure_ville" placeholder=""
                      value="{{$vendeurDetails['ville']}}" >
                      <div id="check_password"></div>
                    <div class="form-group">

                    <div class="form-group">
                      <label for="fournisseure_secteur">Secteur</label>
                      <!-- @error('fournisseure_nom')
                             <div class="text text-danger">
                             {{$message}}
                           </div>
                      @enderror -->
                      <input type="text" class="form-control" id="fournisseure_secteur" name="fournisseure_secteur" placeholder=""
                      value="{{$vendeurDetails['secteur']}}" >
                      <div id="check_password"></div>
                    <div class="form-group">

                    <div class="form-group">
                      <label for="fournisseure_telephone">Telephone</label>
                      @error('fournisseure_telephone')
                             <div class="text text-danger">
                             {{$message}}
                           </div>
                      @enderror
                      <input type="text" class="form-control" id="fournisseure_telephone" name="fournisseure_telephone" placeholder=""
                      value="{{$vendeurDetails['telephone']}}" >
                   
                   
                      <div class="form-group">
                      <label for="fournisseure_email">Email</label>
                      @error('fournisseure_email')
                             <div class="text text-danger">
                             {{$message}}
                           </div>
                      @enderror
                      <input type="text" class="form-control" id="fournisseure_email" name="fournisseure_email" placeholder=""
                      value="{{$vendeurDetails['email']}}" >
                    </div>

                    <div class="form-group">
                      <label for="fournisseure_status">Status</label>
                      @error('fournisseure_nom')
                             <div class="text text-danger">
                             {{$message}}
                           </div>
                      @enderror
                      <input type="text" class="form-control" id="fournisseure_status" name="fournisseure_status" placeholder=""
                      value="{{$vendeurDetails['status']}}" >
                      <div id="check_password"></div>
                    <div class="form-group">

                    <div class="form-group">
                      <label for="fournisseure_image">Admin photo</label>
                      <input type="file" class="form-control" id="fournisseure_image" name="fournisseure_image" placeholder="">
                          @if(!empty(Auth::guard('admin')->user()))
                           <a target="_blank" href="{{ url('admin/images/photos/' . Auth::guard('admin')->user()->image) }}">Voir l'image</a>
                           <input type="hidden" name="current_fournisseure_image" value="{{ Auth::guard('admin')->user()->image }}">
                       @endif
                    </div>


                    <button type="submit" class="btn btn-primary mr-2 mt-3">Submit</button>
                    <button class="btn btn-light">Cancel</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        @elseif($slug=="boutique")
          <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Modifier Les information de ma boutique</h4>
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
                  <form class="forms-sample" action="{{url('mdifier_fournisseur/boutique')}}" method="post" enctype="multipart/form-data">
                         @csrf
                    <div class="form-group" >
                      <label>Fournisseure nom d'utilisateur/Email</label>
                      <input type="email" class="form-control"  value="{{Auth::guard('admin')->user()->email}}" readonly="">
                    </div>

                    <div class="form-group">
                      <label for="boutique_nom">Nom</label>
                      <input type="text" class="form-control" id="nom_de_boutique" name="nom_de_boutique" placeholder=""
                       @if(isset($vendeurDetails['nom_de_boutique']))
                      value="{{$vendeurDetails['nom_de_boutique']}}" @endif >
                    <div class="form-group">


                    <div class="form-group">
                      <label for="boutique_address">Adresse</label>
                      <input type="text" class="form-control" id="adresse_de_boutique" name="adresse_de_boutique" placeholder=""
                      @if(isset($vendeurDetails['adresse_de_boutique']))
                      value="{{$vendeurDetails['adresse_de_boutique']}}" @endif >
                    <div class="form-group">

                    <div class="form-group">
                      <label for="boutique_ville">Ville</label>
                      <input type="text" class="form-control" id="ville_de_boutique" name="ville_de_boutique" placeholder=""
                      @if(isset($vendeurDetails['ville_de_boutique']))
                      value="{{$vendeurDetails['ville_de_boutique']}}" @endif >
                    <div class="form-group">

                    <div class="form-group">
                      <label for="boutique_secteur">Secteur</label>
                      <input type="text" class="form-control" id="secteur_de_boutique" name="secteur_de_boutique" placeholder=""
                      @if(isset($vendeurDetails['secteur_de_boutique']))
                      value="{{$vendeurDetails['secteur_de_boutique']}}" @endif>
                      <div id="check_password"></div>
                    <div class="form-group">

                    <div class="form-group">
                      <label for="boutique_telephone">Telephone</label>
                      <input type="text" class="form-control" id="tell_de_boutique" name="tell_de_boutique" placeholder=""
                      @if(isset($vendeurDetails['tell_de_boutique']))
                      value="{{$vendeurDetails['tell_de_boutique']}}" @endif>
                      </div>
                    
                      <div class="form-group">
                      <label for="email_de_boutique">Email</label>
                      <input type="text" class="form-control" id="email_de_boutique" name="email_de_boutique" placeholder=""
                      @if(isset($vendeurDetails['email_de_boutique']))
                      value="{{$vendeurDetails['email_de_boutique']}}" @endif>
                    </div>

                    <div class="form-group">
                      <label for="document_de_boutique">Document</label>
                      <select class="form-control" name="document_de_boutique" id="document_de_boutique">
                        <option value="passport"  
                        @if(isset($vendeurDetails['document_de_boutique']) && $vendeurDetails['document_de_boutique']=="passport"))
                        selected="" @endif >Passport</option>
                        <option value="cartedidentite" 
                        @if(isset($vendeurDetails['document_de_boutique']) && $vendeurDetails['document_de_boutique']=="cartedidentite"))
                        selected="" @endif >Carte d'identité</option>
                        <option value="permie"
                        @if(isset($vendeurDetails['document_de_boutique']) && $vendeurDetails['document_de_boutique']=="permie"))
                        selected="" @endif >Permie</option>
                        <option value="cartedelecteur" 
                        @if(isset($vendeurDetails['document_de_boutique']) && $vendeurDetails['document_de_boutique']=="cartedelecteur"))
                        selected="" @endif >Carte d'électeur</option>
                      </select>
                      </div>

                      <div class="form-group">
                      <label for="photos_de_boutique">Boutique photo</label>
                      <input type="file" class="form-control" id="photos_de_boutique" name="photos_de_boutique" placeholder="">
                          @if(!empty(Auth::guard('admin')->user()))
                          <a target="_blank" href="{{ url('admin/images/preuve/' . $vendeurDetails['photos_de_boutique']) }}">Voir l'image</a>
                           <input type="hidden" name="current_photos_de_boutique" id="current_photos_de_boutique" value="{{$vendeurDetails['photos_de_boutique']}}">
                          @endif
                    </div>
                    <button type="submit" class="btn btn-primary mr-2 mt-3">Submit</button>
                    <button type="reset" class="btn btn-light">Cancel</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
          @elseif($slug=="Bank")
          <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Modifier Ma bank</h4>
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
                  <form class="forms-sample" action="{{url('mdifier_fournisseur/Bank')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group" >
                      <label>Fournisseure nom d'utilisateur/Email</label>
                      <input type="email" class="form-control"  value="{{Auth::guard('admin')->user()->email}}" readonly="">
                    </div>

                    <div class="form-group">
                      <label for="nom_du_titulaire_du_compte">Nom du titulaire du compte</label>
                      @error('fournisseure_nom')
                             <div class="text text-danger">
                             {{$message}}
                           </div>
                      @enderror
                      <input type="text" class="form-control" id="nom_du_titulaire_du_compte" name="nom_du_titulaire_du_compte" placeholder=""
                      @if(isset($vendeurDetails['nom_du_titulaire_du_compte']))
                      value="{{$vendeurDetails['nom_du_titulaire_du_compte']}}" @endif >
                      <div id="check_password"></div>
                    <div class="form-group">


                    <div class="form-group">
                      <label for="nom_de_la_bank">Nom de la bank</label>
                      @error('fournisseure_address')
                             <div class="text text-danger">
                             {{$message}}
                           </div>
                      @enderror
                      <input type="text" class="form-control" id="nom_de_la_bank" name="nom_de_la_bank" placeholder=""
                      @if(isset($vendeurDetails['nom_de_la_bank']))
                      value="{{$vendeurDetails['nom_de_la_bank']}}" @endif>
                      <div id="check_password"></div>
                    <div class="form-group">

                    <div class="form-group">
                      <label for="numero_de_compte">Numero de compte</label>
                      @error('fournisseure_ville')
                             <div class="text text-danger">
                             {{$message}}
                           </div>
                      @enderror
                      <input type="text" class="form-control" id="numero_de_compte" name="numero_de_compte" placeholder=""
                      @if(isset($vendeurDetails['numero_de_compte']))
                      value="{{$vendeurDetails['numero_de_compte']}}" @endif>
                      <div id="check_password"></div>
                    <div class="form-group">

                    <div class="form-group">
                      <label for="bank_ifsc_code">Bank ifsc code</label>
                      <input type="text" class="form-control" id="bank_ifsc_code" name="bank_ifsc_code" placeholder=""
                      @if(isset($vendeurDetails['bank_ifsc_code']))
                      value="{{$vendeurDetails['bank_ifsc_code']}}" @endif>
                    <div class="form-group">

                    <button type="submit" class="btn btn-primary mr-2 mt-3">Submit</button>
                    <button class="btn btn-light">Cancel</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        @endif
     </div>
 </div>
 <!-- content-wrapper ends -->
<!-- partial:partials/_footer.html -->
 @include('admin.layout.footer')
 <!-- partial -->
</div>
@endsection
