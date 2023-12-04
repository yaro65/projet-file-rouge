@extends('front.layout.layout')
 @section('content')
  <!-- Page Introduction Wrapper -->
  <div class="page-style-a">
        <div class="container">
            <div class="page-intro">
                <h2>Shop</h2>
                <ul class="bread-crumb">
                    <li class="has-separator">
                        <i class="ion ion-md-home"></i>
                        <a href="{{url('/')}}">Accueil</a>
                    </li>
                    <li class="is-marked">
                        <a href="listing.html">Magasin</a>
                    </li>
                </ul>
            </div>
        </div>
  </div>
  <!-- Page Introduction Wrapper /- -->
  <!-- Shop-Page -->
 <div class="page-shop u-s-p-t-80">
        <div class="container">
            <!-- Shop-Intro -->
            <div class="shop-intro">
                <ul class="bread-crumb">
                    <li class="has-separator">
                        <a href="{{url('/')}}">Accueil</a>
                    </li>
                     <?php echo $categoryDetails['breadcrumbs']; ?>
                </ul>
            </div>
            <!-- Shop-Intro /- -->
            <div class="row">
                <!-- Shop-Left-Side-Bar-Wrapper -->
               @include('front.products.filters')
                <!-- Shop-Left-Side-Bar-Wrapper /- -->
                <!-- Shop-Right-Wrapper -->
                <div class="col-lg-9 col-md-9 col-sm-12">
                    <!-- Page-Bar -->
                    <div class="page-bar clearfix">
                        <!-- <div class="shop-settings">
                            <a id="list-anchor" class="active">
                                <i class="fas fa-th-list"></i>
                            </a>
                            <a id="grid-anchor" class="active">
                                <i class="fas fa-th"></i>
                            </a>
                        </div> -->
                        <!-- Toolbar Sorter 1  -->
                        <form id="sortProducts" name="sortProducts">
                            <input type="hidden" name="url" id="url" value="{{$url}}">
                           <div class="toolbar-sorter">
                            <div class="select-box-wrapper">
                                <label class="sr-only" for="sort-by">Trier par</label>
                                <select name="sort" id="sort" class="select-box" >
                                    <!-- <option selected="selected" value="">Sort By: Best Selling</option> -->
                                    <option selected value="">Selecte</option>
                                    <option value="product_latest" @if(isset($_GET['sort']) && $_GET['sort']=="product_latest") selected="" @endif 
                                    >Trier par: Dernier</option>
                                    <option value="price_lowest" @if(isset($_GET['sort']) && $_GET['sort']=="price_lowest") selected="" @endif
                                    >Trier par: Prix le plus bas</option>
                                    <option value="price_highest"  @if(isset($_GET['sort']) && $_GET['sort']=="price_highest") selected="" @endif
                                    >Trier par: Prix le plus élevé</option>
                                    <option value="name_a_z"  @if(isset($_GET['sort']) && $_GET['sort']=="name_a_z") selected="" @endif
                                    >Trier par: A - Z </option>
                                    <option value="name_z_a"  @if(isset($_GET['sort']) && $_GET['sort']=="name_z_a") selected="" @endif
                                    >Trier par: Z - A</option>
                                    <!-- <option value="">Sort By: Best Rating</option> -->
                                </select>
                            </div>
                           </div> 
                        </form>

                        <!-- //end Toolbar Sorter 1  -->
                        <!-- Toolbar Sorter 2  -->
                        <!-- <div class="toolbar-sorter-2">
                            <div class="select-box-wrapper">
                                <label class="sr-only" for="show-records">Show Records Per Page</label>
                                <select class="select-box" id="show-records">
                                    <option selected="selected" value="">Show: 8</option>
                                    <option value="">Show: 16</option>
                                    <option value="">Show: 28</option>
                                </select>
                            </div>
                        </div> -->
                        <div class="toolbar-sorter-2">
                            <div class="select-box-wrapper">
                                <label class="sr-only" for="show-records">Afficher les enregistrements par page</label>
                                <select class="select-box" id="show-records">
                                    <option selected="selected" value="">Afficher: {{
                                       count($categoryProducts) }}</option>
                                    <option value="">Afficher: Tous</option>
                                </select>
                            </div>
                        </div>
                        <!-- //end Toolbar Sorter 2  -->
                    </div>
                    <!-- Page-Bar /- -->
                    <!-- Row-of-Product-Container -->
             <div class="filter_products">
               @include('front.products.ajax_product_listing')
             </div>

             @if(isset($_GET['sort']))
            <div>{{$categoryProducts->appends(['sort'=>$_GET['sort']])->links()}}</div>
             @else
             <div>{{$categoryProducts->links()}}</div>
             @endif
              <div>&nbsp;</div>
              <div> {{ $categoryDetails['categoryDetails']['description']}}</div>
                    <!-- Row-of-Product-Container /- -->
                </div>
                <!-- Shop-Right-Wrapper /- -->


                <!-- Shop-Pagination -->
                <?php
                // <div class="pagination-area">
                //     <div class="pagination-number">
                //         <ul>
                //             <li style="display: none">
                //                 <a href="shop-v1-root-category.html" title="Previous">
                //                     <i class="fa fa-angle-left"></i>
                //                 </a>
                //             </li>
                //             <li class="active">
                //                 <a href="shop-v1-root-category.html">1</a>
                //             </li>
                //             <li>
                //                 <a href="shop-v1-root-category.html">2</a>
                //             </li>
                //             <li>
                //                 <a href="shop-v1-root-category.html">3</a>
                //             </li>
                //             <li>
                //                 <a href="shop-v1-root-category.html">...</a>
                //             </li>
                //             <li>
                //                 <a href="shop-v1-root-category.html">10</a>
                //             </li>
                //             <li>
                //                 <a href="shop-v1-root-category.html" title="Next">
                //                     <i class="fa fa-angle-right"></i>
                //                 </a>
                //             </li>
                //         </ul>
                //     </div>
                // </div>
                ?>
                <!-- Shop-Pagination /- -->
            </div>
        </div>
 </div>
  <!-- Shop-Page /- -->
 @endsection