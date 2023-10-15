<nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item">
            <a @if(Session::get('page')=="dashboard")
              style="background:#4B49AC !important ; color: #fff !important;"
            @endif class="nav-link" href="index.html">
              <i class="icon-grid menu-icon"></i>
              <span class="menu-title">Dashboard</span>
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
                class="nav-link" href="{{url('admin/admins/vendeur')}}">Fournisseure</a></li>
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
          @endif
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#form-elements" aria-expanded="false" aria-controls="form-elements">
              <i class="icon-columns menu-icon"></i>
              <span class="menu-title">Form elements</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="form-elements">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"><a class="nav-link" href="pages/forms/basic_elements.html">Basic Elements</a></li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#charts" aria-expanded="false" aria-controls="charts">
              <i class="icon-bar-graph menu-icon"></i>
              <span class="menu-title">Charts</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="charts">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="pages/charts/chartjs.html">ChartJs</a></li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#tables" aria-expanded="false" aria-controls="tables">
              <i class="icon-grid-2 menu-icon"></i>
              <span class="menu-title">Tables</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="tables">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="pages/tables/basic-table.html">Basic table</a></li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#icons" aria-expanded="false" aria-controls="icons">
              <i class="icon-contract menu-icon"></i>
              <span class="menu-title">Icons</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="icons">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="pages/icons/mdi.html">Mdi icons</a></li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
              <i class="icon-head menu-icon"></i>
              <span class="menu-title">User Pages</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="auth">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="pages/samples/login.html"> Login </a></li>
                <li class="nav-item"> <a class="nav-link" href="pages/samples/register.html"> Register </a></li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#error" aria-expanded="false" aria-controls="error">
              <i class="icon-ban menu-icon"></i>
              <span class="menu-title">Error pages</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="error">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="pages/samples/error-404.html"> 404 </a></li>
                <li class="nav-item"> <a class="nav-link" href="pages/samples/error-500.html"> 500 </a></li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="pages/documentation/documentation.html">
              <i class="icon-paper menu-icon"></i>
              <span class="menu-title">Documentation</span>
            </a>
          </li>
        </ul>
      </nav>