<?php
use App\Models\Section;
$sections = Section::sections();
            //  echo "<pre>"; print_r($sections); die;
$totalPanierItems = totalPanierItems();
?>
<header>
        <!-- Top-Header -->
       <div class="full-layer-outer-header ">
            <div class="container clearfix">
                <nav>
                    <ul class="primary-nav g-nav">
                        <li>
                            <a href="tel:+111222333">
                                <i class="fas fa-phone u-c-brand u-s-m-r-9"></i>
                                Telephone:+226 57-53-14-41</a>
                        </li>
                        <li>
                            <a href="mailto:info@sitemakers.in">
                                <i class="fas fa-envelope u-c-brand u-s-m-r-9"></i>
                                E-mail: yaronazirou16@gmail.com
                            </a>
                        </li>
                    </ul>
                </nav>
                <nav>
                    <ul class="secondary-nav g-nav">
                        <li>
                            <a>@if(Auth::check()) Mon compte @else Connexion/Inscription @endif
                                <i class="fas fa-chevron-down u-s-m-l-9"></i>
                            </a>
                            <ul class="g-dropdown" style="width:200px">
                                <li>
                                    <a href="{{url('/panier')}}">
                                        <i class="fas fa-cog u-s-m-r-9"></i>
                                        Mon Panier</a>
                                </li>
                                <li>
                                    <a href="checkout.html">
                                        <i class="far fa-check-circle u-s-m-r-9"></i>
                                        Vérifier</a>
                                </li>
                                @if(Auth::check())
                                <li>
                                    <a href="{{url('user/account')}}">
                                        <i class="fas fa-sign-in-alt u-s-m-r-9"></i>
                                        Mon Compte</a>
                                </li>
                                <li>
                                    <a href="{{url('user/commandes')}}">
                                        <i class="fas fa-sign-in-alt u-s-m-r-9"></i>
                                        Mes Commandes</a>
                                </li>
                                <li>
                                    <a href="{{url('/user/deconnexion')}}">
                                        <i class="fas fa-sign-in-alt u-s-m-r-9"></i>
                                        Deconnexion</a>
                                </li>
                                @else
                                <li>
                                    <a href="{{url('/user/login-register')}}">
                                        <i class="fas fa-sign-in-alt u-s-m-r-9"></i>
                                        Connexion Client</a>
                                </li>
                                <li>
                                    <a href="{{url('/vendeur/login-register')}}">
                                        <i class="fas fa-sign-in-alt u-s-m-r-9"></i>
                                         Connexion Vendeur </a>
                                </li>
                                @endif

                            </ul>
                        </li>
                        <li>
                            <a>Fr. Cfa
                                <i class="fas fa-chevron-down u-s-m-l-9"></i>
                            </a>
                           
                        </li>
                        <li>
                            <a>Fr
                                <i class="fas fa-chevron-down u-s-m-l-9"></i>
                            </a>
                            
                    </ul>
                </nav>
            </div>
       </div>
        <!-- Top-Header /- -->
        <!-- Mid-Header -->
          <div class="mb-5">
            <div class="container">
                <div class="row clearfix align-items-center">
                    <div class="col-lg-3 col-md-9 col-sm-6">
                        <div class="brand-logo text-lg-center">
                            <a href="index.html">
                            <img src="{{ asset('front/images/main-logo/Logo.png')}}" alt="Stack Developers" class="app-brand-logo" width="280" height="170">
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-6 u-d-none-lg">
                        <form class="form-searchbox">
                            <label class="sr-only" for="search-landscape">Rechercher</label>
                            <input id="search-landscape" type="text" class="text-field" placeholder="Rechercher">
                            <div class="select-box-position">
                                <div class="select-box-wrapper select-hide">
                                    <label class="sr-only" for="select-category">Choisissez une catégorie pour la recherche</label>
                                    <select class="select-box" id="select-category">
                                        <option selected="selected" value="">
                                            Tous
                                        </option>
                                        @foreach($sections as $section)
                                        <option value="">{{ $section['nom'] }}</option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>
                            <button id="btn-search" type="submit" class="button button-primary fas fa-search"></button>
                        </form>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6">
                        <nav>
                            <ul class="mid-nav g-nav">
                                <li class="u-d-none-lg">
                                    <a href="index.html">
                                        <i class="ion ion-md-home u-c-brand"></i>
                                    </a>
                                </li>
                                <li class="u-d-none-lg">
                                    <a href="wishlist.html">
                                        <i class="far fa-heart"></i>
                                    </a>
                                </li>
                                <li>
                                    <a id="mini-cart-trigger">
                                        <i class="ion ion-md-basket"></i>
                                        <span class="item-counter totalPanierItems">{{$totalPanierItems}}</span>
                                        <span class="item-price"></span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
          </div>
        <!-- Mid-Header /- -->
        <!-- Responsive-Buttons -->
         <div class="fixed-responsive-container">
            <div class="fixed-responsive-wrapper">
                <button type="button" class="button fas fa-search" id="responsive-search"></button>
            </div>
            <div class="fixed-responsive-wrapper">
                <a href="wishlist.html">
                    <i class="far fa-heart"></i>
                    <span class="fixed-item-counter">4</span>
                </a>
            </div>
         </div>
        <!-- Responsive-Buttons /- -->
        <!-- Mini Cart -->
        <div id="appendHeaderPanierItems">
        @include('front.layout.header_panier_items')
        </div>
        <!-- Mini Cart /- -->
        <!-- Bottom-Header -->
         <div class="full-layer-bottom-header">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-3">
                        <div class="v-menu v-close">
                            <span class="v-title">
                                <i class="ion ion-md-menu"></i>
                                Categories
                                <i class="fas fa-angle-down"></i>
                            </span>
                            <nav>
                                <div class="v-wrapper">
                                    <ul class="v-list animated fadeIn">
                                      @foreach($sections as $section)
                                      @if(count($section['categories'])>0)
                                        <li class="js-backdrop">
                                            <a href="javascript:;">
                                                <i class="ion-ios-add-circle"></i>
                                               {{ $section['nom'] }}
                                                <i class="ion ion-ios-arrow-forward"></i>
                                            </a>
                                            <button class="v-button ion ion-md-add"></button>
                                            <div class="v-drop-right" style="width: 700px;">
                                                <div class="row">
                                                 @foreach($section['categories'] as $category)
                                                    <div class="col-lg-4">
                                                        <ul class="v-level-2">
                                                            <li>
                                                                <a href="{{ url($category['url']) }}">{{$category['category_nom']}}</a>
                                                                <ul>
                                                                   @foreach($category['subcategories'] as $subcategory)

                                                                    <li>
                                                                        <a href="{{ url($subcategory['url']) }}">{{$subcategory['category_nom']}}</a>
                                                                    </li>
                                                                    @endforeach
                                                                </ul>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </li>
                                        @endif
                                       @endforeach
                                        <li>
                                            <a class="v-more">
                                                <i class="ion ion-md-add"></i>
                                                <span>View More</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </nav>
                        </div>
                    </div>
                    <div class="col-lg-9">
                        <ul class="bottom-nav g-nav u-d-none-lg">
                            <li>
                                <a href="listing-without-filters.html">Arrivages récents
                                    <span class="superscript-label-new">Nouveautés</span>
                                </a>
                            </li>
                            <li>
                                <a href="listing-without-filters.html">Meilleure vente
                                    <span class="superscript-label-hot">Top 10</span>
                                </a>
                            </li>
                            <li>
                                <a href="listing-without-filters.html">En vedette
                                </a>
                            </li>
                            <li>
                                <a href="listing-without-filters.html">En promotion
                                    <span class="superscript-label-discount">-30%</span>
                                </a>
                            </li>
                            <li class="mega-position">
                                <a>Plus
                                    <i class="fas fa-chevron-down u-s-m-l-9"></i>
                                </a>
                                <div class="mega-menu mega-3-colm">
                                    <ul>
                                        <li class="menu-title">TPLATFORME</li>
                                        <li>
                                            <a href="about.html" class="u-c-brand">À Propos de Nous</a>
                                        </li>
                                        <li>
                                            <a href="contact.html">Contactez-nous</a>
                                        </li>
                                        <li>
                                            <a href="faq.html">FAQ</a>
                                        </li>
                                    </ul>
                                    <ul>
                                        <li class="menu-title">COLLECTION</li>
                                        <li>
                                            <a href="cart.html">Matières premières </a>
                                        </li>
                                        <li>
                                            <a href="checkout.html">Agricoles </a>
                                        </li>
                                        <li>
                                            <a href="account.html">Artisanaux</a>
                                        </li>
                                    </ul>
                                    <ul>
                                        <li class="menu-title">COMPTE</li>
                                        <li>
                                            <a href="shop-v1-root-category.html">My Account</a>
                                        </li>
                                        <li>
                                            <a href="shop-v1-root-category.html">Mon Compte</a>
                                        </li>
                                        <li>
                                            <a href="listing.html">Mes Commandes</a>
                                        </li>
                                        
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
         </div>
        <!-- Bottom-Header /- -->
</header>
    <!-- Header /- -->