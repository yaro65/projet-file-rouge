<nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item">
            <a @if(Session::get('page')=="dashboard")
              style="background:#4B49AC !important ; color: #fff !important;"
            @endif class="nav-link" href="index.html">
              <i class="icon-grid menu-icon"></i>
              <span class="menu-title">Accueil</span>
            </a>
          </li>
          @if(Auth::guard('admin')->user()->type=="vendeur")
          <li class="nav-item">
            <a
            @if(Session::get('page') == "mdifier_fournisseur_profile" || Session::get('page') == "mdifier_fournisseur_boutique"
            || Session::get('page') == "mdifier_fournisseur_Bank")
              style="background: #4B49AC !important; color: #fff !important;"
                  @endif
            class="nav-link" data-toggle="collapse" href="#ui-fournisseures" aria-expanded="false" aria-controls="ui-fournisseures">
              <i class="icon-layout menu-icon"></i>
              <span class="menu-title">Vendeur</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-fournisseures">
              <ul class="nav flex-column sub-menu" style="background:#fff !important ; color: #4B49AC !important;">
              <li class="nav-item"> <a 
              @if(Session::get('page') == "mdifier_fournisseur_profile")
              style="background: #4B49AC !important; color: #fff !important;" 
               @else
                style="background: #fff !important; color: #4B49AC !important;" 
               @endif
              class="nav-link" href="{{url('mdifier_fournisseur/profile')}}">Profile</a></li>
                <li class="nav-item"> <a 
                @if(Session::get('page') == "mdifier_fournisseur_boutique")
              style="background: #4B49AC !important; color: #fff !important;" 
               @else
                style="background: #fff !important; color: #4B49AC !important;" 
               @endif
                class="nav-link" href="{{url('mdifier_fournisseur/boutique')}}">Boutique</a></li>
                <li class="nav-item"> <a 
                @if(Session::get('page') == "mdifier_fournisseur_Bank")
              style="background: #4B49AC !important; color: #fff !important;" 
               @else
                style="background: #fff !important; color: #4B49AC !important;" 
               @endif
                class="nav-link" href="{{url('mdifier_fournisseur/Bank')}}">Bank</a></li>
              </ul>
            </div>
          </li>

          <li class="nav-item">
            <a
            @if(Session::get('page') == "sections" || Session::get('page') == "produits")
            (Session::get('page') == "produits" )
              style="background: #4B49AC !important; color: #fff !important;"
                  @endif
            class="nav-link" data-toggle="collapse" href="#ui-catalogue" aria-expanded="false" aria-controls="ui-catalogue">
              <i class="icon-layout menu-icon"></i>
              <span class="menu-title">Gestion de catalogue</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-catalogue">
              <ul class="nav flex-column sub-menu" style="background: #fff; !important color: #4B49AC !important ;">
                <li class="nav-item"> <a
                @if(Session::get('page') == "produits")
              style="background: #4B49AC !important; color: #fff !important;" 
               @else
                style="background: #fff !important; color: #4B49AC !important;" 
               @endif
                class="nav-link" href="{{url('admin/products')}}">Produits</a></li>
                <li class="nav-item"> <a
                @if(Session::get('page') == "coupons")
              style="background: #4B49AC !important; color: #fff !important;" 
               @else
                style="background: #fff !important; color: #4B49AC !important;" 
               @endif
                class="nav-link" href="{{url('admin/coupons')}}">Coupons</a></li>
              </ul>
            </div>
          </li>

          <li class="nav-item">
            <a  @if(Session::get('page') == "commandes" )
              style="background: #4B49AC !important; color: #fff !important;"
                  @endif
                class="nav-link" data-toggle="collapse" href="#ui-commandes" aria-expanded="false" aria-controls="ui-commandes">
              <i class="icon-layout menu-icon"></i>
              <span class="menu-title">Gestion Commandes</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-commandes">
                
              <ul class="nav flex-column sub-menu"  style="background: #fff !important; color: #4B49AC !important;" >
                <li class="nav-item"> <a 
                @if(Session::get('page') == "commandes")
              style="background: #4B49AC !important; color: #fff !important;" 
               @else
                style="background: #fff !important; color: #4B49AC !important;" 
               @endif
                class="nav-link" href="{{url('admin/commandes')}}">Commandes</a></li>
      
              </ul>
            </div>
          </li>
          @else
          <li class="nav-item">
            <a @if(Session::get('page') == "modifier_mot_passe" || Session::get('page') == "mdifierdetail")
              style="background: #4B49AC !important; color: #fff !important;"
                  @endif

            class="nav-link" data-toggle="collapse" href="#ui-parametre" aria-expanded="false" aria-controls="ui-parametre">
              <i class="icon-layout menu-icon"></i>
              <span class="menu-title">Paramètre</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-parametre">
              <ul class="nav flex-column sub-menu" style="background: #fff; !important color: #4B49AC !important ;" >
                <li class="nav-item"> <a
                @if(Session::get('page') == "modifier_mot_passe")
              style="background: #4B49AC !important; color: #fff !important;" 
               @else
                style="background: #fff !important; color: #4B49AC !important;" 
               @endif
                class="nav-link" href="{{url('admin/paramettre/pasword')}}">Modifier password</a>
              </li>
                <li class="nav-item"> <a 
                @if(Session::get('page') == "mdifierdetail")
                  style="background: #4B49AC !important; color: #fff !important;" 
                 @else
                  style="background: #fff !important; color: #4B49AC !important;" 
                @endif 
                class="nav-link" href="{{url('admin/paramettre')}}">Modifier Details</a>
              </li>
              </ul>
            </div>
          </li>

          <li class="nav-item">
            <a
            @if(Session::get('page') == "view_admins" || Session::get('page') == "view_superadmins")
            (Session::get('page') == "view_fournisseures" || Session::get('page') == "view_all")
              style="background: #4B49AC !important; color: #fff !important;"
                  @endif
            class="nav-link" data-toggle="collapse" href="#ui-admins" aria-expanded="false" aria-controls="ui-admins">
              <i class="icon-layout menu-icon"></i>
              <span class="menu-title">Gestion Admin</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-admins">
              <ul class="nav flex-column sub-menu" style="background: #fff; !important color: #4B49AC !important ;">
                <li class="nav-item"> <a 
                @if(Session::get('page') == "view_admins")
              style="background: #4B49AC !important; color: #fff !important;" 
               @else
                style="background: #fff !important; color: #4B49AC !important;" 
               @endif
                class="nav-link" href="{{url('admin/admins/admin')}}">Admin</a></li>
                <li class="nav-item"> <a 
                @if(Session::get('page') == "view_superadmins")
              style="background: #4B49AC !important; color: #fff !important;" 
               @else
                style="background: #fff !important; color: #4B49AC !important;" 
               @endif
                class="nav-link" href="{{url('admin/admins/Superadmin')}}">Super Admin</a></li>
                <li class="nav-item"> <a
                @if(Session::get('page') == "view_fournisseures")
              style="background: #4B49AC !important; color: #fff !important;" 
               @else
                style="background: #fff !important; color: #4B49AC !important;" 
               @endif
                class="nav-link" href="{{url('admin/admins/vendeur')}}">Vendeur</a></li>
                <li class="nav-item"> <a 
                @if(Session::get('page') == "view_all")
              style="background: #4B49AC !important; color: #fff !important;" 
               @else
                style="background: #fff !important; color: #4B49AC !important;" 
               @endif
                class="nav-link" href="{{url('admin/admins')}}">Tous</a></li>
              </ul>
            </div>
          </li>

          <li class="nav-item">
            <a
            @if(Session::get('page') == "sections" || Session::get('page') == "produits"
             || Session::get('page') == "categories"  || Session::get('page') == "coupons"
             ||Session::get('page') == "marques") 
              style="background: #4B49AC !important; color: #fff !important;"
                  @endif
            class="nav-link" data-toggle="collapse" href="#ui-catalogue" aria-expanded="false" aria-controls="ui-catalogue">
              <i class="icon-layout menu-icon"></i>
              <span class="menu-title">Gestion de catalogue</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-catalogue">
              <ul class="nav flex-column sub-menu" style="background: #fff; !important color: #4B49AC !important ;">
                <li class="nav-item"> <a
                @if(Session::get('page') == "sections")
              style="background: #4B49AC !important; color: #fff !important;" 
               @else
                style="background: #fff !important; color: #4B49AC !important;" 
               @endif
                class="nav-link" href="{{url('admin/sections')}}">Sections</a>
            </li>
                <li class="nav-item"> <a
                @if(Session::get('page') == "categories")
              style="background: #4B49AC !important; color: #fff !important;" 
               @else
                style="background: #fff !important; color: #4B49AC !important;" 
               @endif
                class="nav-link" href="{{url('admin/categories')}}">Catégories</a>
            </li>

            <li class="nav-item"> <a
                @if(Session::get('page') == "marques")
              style="background: #4B49AC !important; color: #fff !important;" 
               @else
                style="background: #fff !important; color: #4B49AC !important;" 
               @endif
                class="nav-link" href="{{url('admin/marques')}}">Marques</a>
            </li>

                <li class="nav-item"> <a
                @if(Session::get('page') == "produits")
              style="background: #4B49AC !important; color: #fff !important;" 
               @else
                style="background: #fff !important; color: #4B49AC !important;" 
               @endif
                class="nav-link" href="{{url('admin/products')}}">Produits</a></li>

                <li class="nav-item"> <a
                @if(Session::get('page') == "coupons")
              style="background: #4B49AC !important; color: #fff !important;" 
               @else
                style="background: #fff !important; color: #4B49AC !important;" 
               @endif
                class="nav-link" href="{{url('admin/coupons')}}">Coupons</a></li>
              </ul>
            </div>
          </li>

          <li class="nav-item">
            <a  @if(Session::get('page') == "commandes" )
              style="background: #4B49AC !important; color: #fff !important;"
                  @endif
                class="nav-link" data-toggle="collapse" href="#ui-commandes" aria-expanded="false" aria-controls="ui-commandes">
              <i class="icon-layout menu-icon"></i>
              <span class="menu-title">Gestion Commandes</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-commandes">
                
              <ul class="nav flex-column sub-menu"  style="background: #fff !important; color: #4B49AC !important;" >
                <li class="nav-item"> <a 
                @if(Session::get('page') == "commandes")
              style="background: #4B49AC !important; color: #fff !important;" 
               @else
                style="background: #fff !important; color: #4B49AC !important;" 
               @endif
                class="nav-link" href="{{url('admin/commandes')}}">Commandes</a></li>
      
              </ul>
            </div>
          </li>

          <li class="nav-item">
            <a  @if(Session::get('page') == "users" || Session::get('page') == "subscribers")
              style="background: #4B49AC !important; color: #fff !important;"
                  @endif
                class="nav-link" data-toggle="collapse" href="#ui-utilisateurs" aria-expanded="false" aria-controls="ui-utilisateurs">
              <i class="icon-layout menu-icon"></i>
              <span class="menu-title">Gestion utilisateurs</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-utilisateurs">
                
              <ul class="nav flex-column sub-menu"  style="background: #fff !important; color: #4B49AC !important;" >
                <li class="nav-item"> <a 
                @if(Session::get('page') == "users")
              style="background: #4B49AC !important; color: #fff !important;" 
               @else
                style="background: #fff !important; color: #4B49AC !important;" 
               @endif
                class="nav-link" href="{{url('admin/users')}}">Utilisateurs</a></li>
                <li class="nav-item"> <a 
                @if(Session::get('page') == "subscribers")
              style="background: #4B49AC !important; color: #fff !important;" 
               @else
                style="background: #fff !important; color: #4B49AC !important;" 
               @endif
                class="nav-link" href="{{url('admin/subscribers')}}">Abonnés</a></li>
              </ul>
            </div>
          </li>

          <li class="nav-item">
            <a @if(Session::get('page') == "banners")
              style="background: #4B49AC !important; color: #fff !important;"
                  @endif
            class="nav-link" data-toggle="collapse" href="#ui-utilisateurs" aria-expanded="false" aria-controls="ui-utilisateurs">
              <i class="icon-layout menu-icon"></i>
              <span class="menu-title">Gestion Banners</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-utilisateurs">
              <ul class="nav flex-column sub-menu"  style="background: #fff !important; color: #4B49AC !important;">
                <li class="nav-item"> <a
                @if(Session::get('page') == "banners")
              style="background: #4B49AC !important; color: #fff !important;" 
               @else
                style="background: #fff !important; color: #4B49AC !important;" 
               @endif
                class="nav-link" href="{{url('banners')}}">Bannière de curseur</a></li>
              </ul>
            </div>
          </li>


          <li class="nav-item">
            <a @if(Session::get('page') == "shipping")
              style="background: #4B49AC !important; color: #fff !important;"
                  @endif
            class="nav-link" data-toggle="collapse" href="#ui-shipping" aria-expanded="false" aria-controls="ui-shipping">
              <i class="icon-layout menu-icon"></i>
              <span class="menu-title">Livraison</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-shipping">
              <ul class="nav flex-column sub-menu"  style="background: #fff !important; color: #4B49AC !important;">
                <li class="nav-item"> <a
                @if(Session::get('page') == "shipping")
              style="background: #4B49AC !important; color: #fff !important;" 
               @else
                style="background: #fff !important; color: #4B49AC !important;" 
               @endif
                class="nav-link" href="{{url('shipping-charges')}}">Frais</a></li>
              </ul>
            </div>
          </li>
          @endif

          <li class="nav-item">
            <a class="nav-link" href="pages/documentation/documentation.html">
              <i class="icon-paper menu-icon"></i>
              <span class="menu-title">Documentation</span>
            </a>
          </li>
        </ul>
      </nav>