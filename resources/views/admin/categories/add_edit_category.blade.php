@extends('admin.layout.layout')
@section('content')
<div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-md-12 grid-margin">
              <div class="row">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                  <h4 class="font-weight-bold">Categories</h4>
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
                                 <button type="button" class="Close" data-dismiss="alert" aria-label="Close">
                                   <span aria-hidden="true">&times;</span>
                                </button>
                             </div>
                             @endif
                         <form class="forms-sample" @if(empty($category['id'])) 
                                        action="{{url('admin/add-edit-category')}}"
                                @else 
                                  action="{{url('admin/add-edit-category/'.$category['id'])}}"
                                    @endif
                                  method="post" enctype="multipart/form-data" >
                                @csrf        
                            <div class="form-group">
                              <label for="category_nom">Nom de la categorie</label>
                                <input type="text" class="form-control" id="category_nom" name="category_nom" placeholder="Entrer le nom de la categorie"
                                @if(!empty($category['category_nom'])) value="{{$category['category_nom']}}" @else value="{{old('category_nom')}}" @endif>
                             </div>

                             <div class="form-group">
                              <label for="section_id">Selectioné la section</label>
                                <select  class="form-control" id="section_id" name="section_id"
                                style="color: #000;"
                                >
                                  <option value="">Selecte</option>
                                  @foreach($getSections as $section)
                                  <option value="{{ $section['id'] }}" @if(!empty($category['section_id'])
                                  && $category['section_id']==$section['id']) selected=""
                                  @endif
                                  >{{ $section['nom'] }}</option>
                                  @endforeach
                              </select>
                             </div>
                             <div id="appendCategoriesLevel">
                                 @include('admin.categories.append_categories_level')
                             </div>

                             <div class="form-group">
                                <label for="admin_image">Catégorie image</label>
                                <input type="file" class="form-control" id="category_image" name="category_image" placeholder="">
                             </div>
                             @if(!empty($category['category_image']))
                             <a target="blank" href="{{ url('front/images/category_images/'.$category['category_image'])}}">Voir photo</a>&nbsp;|&nbsp;

                             <a class="confirmDelete" href="javascript:void(0)" module="category-image" moduleid="{{ $category['id'] }}">
                                  Supprimer l'image
                              </a>
                             @endif

                             <div class="form-group">
                                 <label for="category_remise">Catégorie remise</label>
                                 <input type="text" class="form-control" id="category_remise" name="category_remise" placeholder="Categorie remise"
                                @if(!empty($category['category_remise'])) value="{{$category['category_remise']}}" @else value="{{old('category_remise')}}" @endif>
                             </div>

                             <div class="form-group">
                                 <label for="description">Description </label><br>
                                 <textarea class="form-control" name="description" id="description" cols="60" rows="3"></textarea>
                             </div>

                             <div class="form-group">
                              <label for="url">Categorie URL</label>
                                <input type="text" class="form-control" id="url" name="url" placeholder="Entrer le URL"
                                @if(!empty($category['url'])) value="{{$category['url']}}" @else value="{{old('url')}}" @endif>
                             </div>


                             <div class="form-group">
                              <label for="grand_titre">Grand titre</label>
                                <input type="text" class="form-control" id="grand_titre" name="grand_titre" placeholder="Entrer le Grand titre"
                                @if(!empty($category['grand_titre'])) value="{{$category['grand_titre']}}" @else value="{{old('grand_titre')}}" @endif>
                             </div>

                             <div class="form-group">
                              <label for="grand_description">Grand description</label>
                                <input type="text" class="form-control" id="grand_description" name="grand_description" placeholder="Entrer le Grand description"
                                @if(!empty($category['grand_description'])) value="{{$category['grand_titre']}}" @else value="{{old('grand_description')}}" @endif>
                             </div>

                             <div class="form-group">
                              <label for="grand_mots_cle">Mots clé</label>
                                <input type="text" class="form-control" id="grand_mots_cle" name="grand_mots_cle" placeholder="Entrer le Mots clé"
                                @if(!empty($category['grand_mots_cle'])) value="{{$category['grand_mots_cle']}}" @else value="{{old('grand_mots_cle')}}" @endif>
                             </div>

                           <button type="submit" class="btn btn-primary mr-2">Submit</button>
                           <button type="reset" class="btn btn-light">Cancel</button>
                        </form>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- partial:partials/_footer.html -->
        @include('admin.layout.footer')
        <!-- partial -->
 </div>
@endsection