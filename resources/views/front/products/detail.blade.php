@extends('front.layout.layout')
 @section('content')
 <?php use App\Models\Product; ?>
     <!-- Page Introduction Wrapper -->
     <div class="page-style-a" style="height: 70px  !important;">
        <div class="container">
            <div class="page-intro " style="margin-top: -50px !important;">
                <h2>Details</h2>
                <ul class="bread-crumb">
                    <li class="has-separator">
                        <i class="ion ion-md-home"></i>
                        <a href="{{url('/')}}">Accueil</a>
                    </li>
                    <li class="is-marked">
                        <a href="javascript:;">Details</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Page Introduction Wrapper /- -->

        <!-- Single-Product-Full-Width-Page -->
        <div class="page-detail u-s-p-t-80">
        <div class="container">
            <!-- Product-Detail -->
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <!-- Product-zoom-area -->
                    <div class="zoom-area">
                        <img id="zoom-pro" class="img-fluid" src="{{ asset('front/images/product_images/large/'.$productDetails['product_image'])}}" 
                        data-zoom-image="{{ asset('front/images/product_images/large/'.$productDetails['product_image'])}}" alt="Zoom Image">
                        <div id="gallery" class="u-s-m-t-10">
                            <a class="active" data-image="{{ asset('front/images/product_images/large/'.$productDetails['product_image'])}}"
                             data-zoom-image="{{ asset('front/images/product_images/large/'.$productDetails['product_image'])}}">
                                <img src="{{ asset('front/images/product_images/large/'.$productDetails['product_image'])}}" alt="Product">
                            </a>
                            @foreach($productDetails['images'] as $image)
                            <a data-image="{{ asset('front/images/product_images/large/'.$image['image'])}}" 
                            data-zoom-image="{{ asset('front/images/product_images/large/'.$image['image'])}}">
                                <img src="{{ asset('front/images/product_images/large/'.$image['image'])}}" alt="Product">
                            </a>
                            @endforeach
                        </div>
                    </div>
                    <!-- Product-zoom-area /- -->
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">

                @if (Session::has('success_message'))
                             <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>Success:</strong> <?php echo Session::get('success_message'); ?>
                                               <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; right: 0; top: 0;">
                                   <span aria-hidden="true">&times;</span>
                                </button>
                             </div>
                     @endif
                     
                  @if (Session::has('error_message'))
                             <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Error:</strong> <?php echo Session::get('error_message'); ?>
                                               <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; right: 0; top: 0;">
                                   <span aria-hidden="true">&times;</span>
                                </button>
                             </div>
                     @endif
                    <!-- Product-details -->
                    <div class="all-information-wrapper">

                        <div class="section-1-title-breadcrumb-rating">
                            <div class="product-title">
                                <h1>
                                    <a href="javascript:;">{{$productDetails['product_name']}}</a>
                                </h1>
                            </div>
                            <ul class="bread-crumb">
                                <li class="has-separator">
                                    <a href="{{url('/')}}">Accueil</a>
                                </li>
                                <li class="has-separator">
                                    <a href="javascript:;">{{$productDetails['section']['nom']}}</a>
                                </li>
                                <?php echo $categoryDetails['breadcrumbs']; ?>
                            </ul>
        
                        </div>
                        <div class="section-2-short-description u-s-p-y-14">
                            <h6 class="information-heading u-s-m-b-8">Description:</h6>
                            <p>{{ $productDetails['description'] }}
                            </p>
                        </div>
                        <div class="section-3-price-original-discount u-s-p-y-14">
                        <?php $getDiscountPrice = Product::getDiscountPrice($productDetails['id']); ?>
                        <span class="getAttributePrice">
                            @if($getDiscountPrice > 0)
                            <div class="price">
                                <h4>Fr.{{$getDiscountPrice}}</h4>
                            </div>
                            <div class="original-price">
                                <span>Original Price:</span>
                                <span>Fr.{{$productDetails['product_price']}}</span>
                            </div>
                            @else
                            <div class="price">
                                <h4>Fr.{{$productDetails['product_price']}}</h4>
                            </div>
                            @endif
                        </span>
                            <!-- <div class="discount-price">
                                <span>Discount:</span>
                                <span>15%</span>
                            </div>
                            <div class="total-save">
                                <span>Save:</span>
                                <span>$20</span>
                            </div> -->
                        </div>
                        <div class="section-4-sku-information u-s-p-y-14">
                            <h6 class="information-heading u-s-m-b-8">Information</h6>
                            <div class="left">
                                <span>Produit code:</span>
                                <span>{{$productDetails['product_code']}}</span>
                            </div>
                            <div class="left">
                                <span>Produit couleur:</span>
                                <span>{{$productDetails['product_color']}}</span>
                            </div>
                            <div class="availability">
                                <span>Disponibilité</span>
                                @if($totalStock>0)
                                <span>In Stock</span>
                                @else
                                <span style="color:red;">En rupture de stock</span>
                                @endif
                            </div>
                            @if($totalStock>0)
                            <div class="left">
                                <span>Seulement:</span>
                                <span>{{$totalStock}} left</span>
                            </div>
                            @endif
                        </div>
                        <form action="{{ url('panier/add')}}" class="post-form" method="post">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $productDetails['id'] }}">
                            <div class="section-5-product-variants u-s-p-y-14">
                            <div class="sizes u-s-m-b-11">
                                <span>Taille disponible</span>
                                <div class="size-variant select-box-wrapper">
                                    <select class="select-box product-size" name="size"
                                       product-id="{{$productDetails['id']}}" id="getPrice">
                                        <option value="">Choisir la taille</option>
                                        @foreach($productDetails['attributes'] as $attribute)
                                        <option value="{{$attribute['size']}}">{{$attribute['size']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            </div>
                            <div class="section-6-social-media-quantity-actions u-s-p-y-14">
                               <!-- <div class="quick-social-media-wrapper u-s-m-b-22">
                                    <span>Share:</span>
                                    <ul class="social-media-list">
                                        <li>
                                            <a href="#">
                                                <i class="fab fa-facebook-f"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="fab fa-twitter"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="fab fa-google-plus-g"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="fas fa-rss"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="fab fa-pinterest"></i>
                                            </a>
                                        </li>
                                    </ul>
                             </div> -->
                             <div class="quantity-wrapper u-s-m-b-22">
                                    <span>Quantité:</span>
                                    <div class="quantity">
                                        <input type="number" class="quantity-text-field" name="quantity"value="1" >
                                    </div>
                                </div>
                                <div>
                                    <button class="button button-outline-secondary" type="submit">Ajouter Au Panier</button>
                                    <button class="button button-outline-secondary far fa-heart u-s-m-l-6"></button>
                                    <button class="button button-outline-secondary far fa-envelope u-s-m-l-6"></button>
                                </div>
                            </div>

                        </form>
                    </div>
                    <!-- Product-details /- -->
                </div>
            </div>
            <!-- Product-Detail /- -->
            <!-- Detail-Tabs -->
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="detail-tabs-wrapper u-s-p-t-80">
                        <div class="detail-nav-wrapper u-s-m-b-30">
                            <ul class="nav single-product-nav justify-content-center">
                                <li class="nav-item">
                                    <a class="nav-link active " data-toggle="tab" href="#video">Product Vidéos</a>
                                </li>
                        
                            </ul>
                        </div>
                        <div class="tab-content">
                            <!-- Description-Tab -->
                            <div class="tab-pane fade active show" id="video">
                                <div>
                                   @if($productDetails['product_videos'])
                                   <video controls>
                                   <source src="{{ url('front/videos/product_videos/'.$productDetails['product_videos']) }}" type="video/mp4">
                                   </video>
                                   @else
                                     product videos does not exists 
                                   @endif

                                </div>
                            </div>
                          
                        </div>
                    </div>
                </div>
            </div>
            <!-- Detail-Tabs /- -->
            <!-- Different-Product-Section -->
            <div class="detail-different-product-section u-s-p-t-80">
                <!-- Similar-Products -->
                <section class="section-maker">
                    <div class="container">
                        <div class="sec-maker-header text-center">
                            <h3 class="sec-maker-h3">Produits similaire</h3>
                        </div>
                        <div class="slider-fouc">
                            <div class="products-slider owl-carousel" data-item="4">
                                @foreach($similarProducts as $product)
                                <div class="item">
                                    <div class="image-container">
                                        <a class="item-img-wrapper-link" href="{{url('product/'.$product['id'])}}">
                                        <?php $product_image_path = 'front/images/product_images/small/'.$product['product_image']; ?>
                                          @if(!empty($product['product_image']) && file_exists($product_image_path))
                                          <img class="img-fluid" src="{{ asset($product_image_path) }}" alt="Product">
                                          @else
                                          <img class="img-fluid" src="{{ asset('front/images/product_images/small/Noimage.png') }}" alt="Product">
                                          @endif
                                        </a>
                                        <div class="item-action-behaviors">
                                            <a class="item-quick-look" data-toggle="modal" href="#quick-view">Quick Look</a>
                                            <a class="item-mail" href="javascript:void(0)">Mail</a>
                                            <a class="item-addwishlist" href="javascript:void(0)">Add to Wishlist</a>
                                            <a class="item-addCart" href="javascript:void(0)">Add to Cart</a>
                                        </div>
                                    </div>
                                    <div class="item-content">
                                        <div class="what-product-is">
                                        <ul class="bread-crumb">
                                         <li class="has-separator">
                                             <a href="">{{$product['product_code']}}</a>
                                         </li>
                                         <li class="has-separator">
                                             <a href="">{{$product['product_color']}}</a>
                                         </li>
                                         <li>
                                           <a href="">{{$product['marque']['nom']}}</a>
                                         </li>
                                        </ul>
                                            <h6 class="item-title">
                                            <a href="{{url('product/'.$product['id'])}}">{{$product['product_name']}}</a>
                                            </h6>
                                            <!-- <div class="item-stars">
                                                <div class='star' title="0 out of 5 - based on 0 Reviews">
                                                    <span style='width:0'></span>
                                                </div>
                                                <span>(0)</span>
                                            </div> -->
                                        </div>
                                        <div class="price-template">
                                        <?php $getDiscountPrice = Product::getDiscountPrice($product['id']); ?>
                                           @if($getDiscountPrice > 0)
                                           <div class="price-template">
                                               <div class="item-new-price">
                                                   Fr.{{ $getDiscountPrice}}
                                               </div>
                                               <div class="item-old-price">
                                                   Fr.{{ $product['product_price']}}
                                               </div>
                                           </div>
                                           @else
                                           <div class="price-template">
                                               <div class="item-new-price">
                                                   Fr.{{ $product['product_price']}}
                                               </div>
                                           </div>
                                           @endif
                                        </div>
                                    </div>
                                    <div class="tag new">
                                        <span>NEW</span>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </section>
                <!-- Similar-Products /- -->
                <!-- Recently-View-Products  -->
                <section class="section-maker">
                    <div class="container">
                        <div class="sec-maker-header text-center">
                            <h3 class="sec-maker-h3">Produits récemment consultés</h3>
                        </div>
                        <div class="slider-fouc">
                            <div class="products-slider owl-carousel" data-item="4">
                            @foreach($recentProductsIds as $product)
                                <div class="item">
                                    <div class="image-container">
                                        <a class="item-img-wrapper-link" href="{{url('product/'.$product['id'])}}">
                                        <?php $product_image_path = 'front/images/product_images/small/'.$product['product_image']; ?>
                                          @if(!empty($product['product_image']) && file_exists($product_image_path))
                                          <img class="img-fluid" src="{{ asset($product_image_path) }}" alt="Product">
                                          @else
                                          <img class="img-fluid" src="{{ asset('front/images/product_images/small/Noimage.png') }}" alt="Product">
                                          @endif
                                        </a>
                                        <div class="item-action-behaviors">
                                            <a class="item-quick-look" data-toggle="modal" href="#quick-view">Quick Look</a>
                                            <a class="item-mail" href="javascript:void(0)">Mail</a>
                                            <a class="item-addwishlist" href="javascript:void(0)">Add to Wishlist</a>
                                            <a class="item-addCart" href="javascript:void(0)">Add to Cart</a>
                                        </div>
                                    </div>
                                    <div class="item-content">
                                        <div class="what-product-is">
                                        <ul class="bread-crumb">
                                         <li class="has-separator">
                                             <a href="">{{$product['product_code']}}</a>
                                         </li>
                                         <li class="has-separator">
                                             <a href="">{{$product['product_color']}}</a>
                                         </li>
                                         <li>
                                           <a href="">{{$product['marque']['nom']}}</a>
                                         </li>
                                        </ul>
                                            <h6 class="item-title">
                                            <a href="{{url('product/'.$product['id'])}}">{{$product['product_name']}}</a>
                                            </h6>
                                            <!-- <div class="item-stars">
                                                <div class='star' title="0 out of 5 - based on 0 Reviews">
                                                    <span style='width:0'></span>
                                                </div>
                                                <span>(0)</span>
                                            </div> -->
                                        </div>
                                        <div class="price-template">
                                        <?php $getDiscountPrice = Product::getDiscountPrice($product['id']); ?>
                                           @if($getDiscountPrice > 0)
                                           <div class="price-template">
                                               <div class="item-new-price">
                                                   Fr.{{ $getDiscountPrice}}
                                               </div>
                                               <div class="item-old-price">
                                                   Fr.{{ $product['product_price']}}
                                               </div>
                                           </div>
                                           @else
                                           <div class="price-template">
                                               <div class="item-new-price">
                                                   Fr.{{ $product['product_price']}}
                                               </div>
                                           </div>
                                           @endif
                                        </div>
                                    </div>
                                    <div class="tag new">
                                        <span>NEW</span>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </section>
                <!-- Recently-View-Products /- -->
            </div>
            <!-- Different-Product-Section /- -->
        </div>
    </div>
    <!-- Single-Product-Full-Width-Page /- -->
 @endsection