@extends('admin.layout.layout')
@section('content')
<div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">clients</h4>
                  <!-- <p class="card-description">
                    Add class <code>.table-bordered</code>
                  </p> --> 
                  @if (Session::has('success_message'))
                             <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>Success:</strong> {{ Session::get('success_message')}}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; right: 0; top: 0;">
                                   <span aria-hidden="true">&times;</span>
                                </button>
                             </div>
                     @endif


                  <div class="table-responsive pt-3">
                    <table id="sections" class="table table-bordered">
                      <thead>
                        <tr>
                          <th>
                            ID
                          </th>
                          <th>
                               Nom
                          </th>
                          <th>
                               Adresse
                          </th>
                          <th>
                               Ville
                          </th>
                          <th>
                               Pays
                          </th>
                          <th>
                               Telephone
                          </th>
                          <th>
                               Email
                          </th>
                          <th>
                            Status
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                      @foreach($users as $user)
                      <tr>
                          <td>
                              {{ $user['id'] }}
                          </td>
                          <td>
                              {{ $user['name'] }}
                          </td>
                          <td>
                              {{ $user['address'] }}
                          </td>
                          <td>
                              {{ $user['ville'] }}
                          </td>
                          <td>
                              {{ $user['pays']}}
                          </td>
                          <td>
                              {{ $user['telephone']}}
                          </td>
                          <td>
                              {{ $user['email']}}
                          </td>
                          <td>
                              @if($user['status'] == 1)
                                  <a class="updateUserStatus" id="user-{{ $user['id'] }}" user_id="{{ $user['id'] }}" href="javascript:void(0)">
                                      <i style="font-size: 25px;" class="mdi mdi-bookmark-check" status="Active"></i>
                                  </a>
                              @else
                                  <a class="updateUserStatus" id="user-{{ $user['id'] }}" user_id="{{ $user['id'] }}" href="javascript:void(0)">
                                      <i style="font-size: 25px;" class="mdi mdi-bookmark-outline" status="Inactive"></i>
                                  </a>
                              @endif
                      </tr>
                        @endforeach

                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:../../partials/_footer.html -->
        <footer class="footer">
          <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2021.  Premium <a href="https://www.bootstrapdash.com/" target="_blank">Bootstrap section template</a> from BootstrapDash. All rights reserved.</span>
            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with <i class="ti-heart text-danger ml-1"></i></span>
          </div>
        </footer>
        <!-- partial -->
</div>

 @endsection
