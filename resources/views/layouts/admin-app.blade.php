<!--
=========================================================
* Paper Dashboard 2 - v2.0.1
=========================================================

* Product Page: https://www.creative-tim.com/product/paper-dashboard-2
* Copyright 2020 Creative Tim (https://www.creative-tim.com)

Coded by www.creative-tim.com

 =========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    Dashboard Admin
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
  <!-- CSS Files -->
  <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="../assets/css/paper-dashboard.css?v=2.0.1" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="../assets/demo/demo.css" rel="stylesheet" />
</head>

<body class="">
  <div class="wrapper ">
    <div class="sidebar" data-color="white" data-active-color="danger">
      <div class="logo">
        <a href="https://www.creative-tim.com" class="simple-text logo-mini">
          <div class="logo-image-small">
            <img src="../assets/img/logo-small.png">
          </div>
          <!-- <p>CT</p> -->
        </a>
        <a href="/" class="simple-text logo-normal">
          CREATIVE TEAM
          <!-- <div class="logo-image-big">
            <img src="../assets/img/logo-big.png">
          </div> -->
        </a>
      </div>
      <div class="sidebar-wrapper">
          <!--MENU UTAMA-->
        <ul class="nav">
          <!--li class="active"-->
          <li>
            <a href="/admin">
              <i class="nc-icon nc-bank"></i>
              <p>Dashboard</p>
            </a>
          </li>
          <li>
            <a href="/listproducts">
              <i class="nc-icon nc-app"></i>
              <p>Products</p>
            </a>
          </li>
          <li>
            <a href="/deleted/product">
              <i class="nc-icon nc-tile-56"></i>
              <p>Deleted Product</p>
            </a>
          </li>
          <!--li class="active"-->
          <li>
            <a href="/kategori">
              <i class="nc-icon nc-box-2"></i>
              <p>Categories</p>
            </a>
          </li>
          <li>
            <a href="/deleted/category">
              <i class="nc-icon nc-tile-56"></i>
              <p>Deleted Categories</p>
            </a>
          </li>
          <li>
            <a href="/courier">
              <i class="nc-icon nc-delivery-fast"></i>
              <p>Courier</p>
            </a>
          </li>
          <li>
            <a href="/deleted/courier">
              <i class="nc-icon nc-tile-56"></i>
              <p>Deleted Courier</p>
            </a>
          </li>
          <li>
            <a href="/adminlist">
              <i class="nc-icon nc-circle-10"></i>
              <p>Admin Profile</p>
            </a>
          </li>
          <li>
            <a href="/userlist">
              <i class="nc-icon nc-single-02"></i>
              <p>User Profile</p>
            </a>
          </li>
          <li>
            <a href="/discount">
              <i class="nc-icon nc-tag-content"></i>
              <p>Discount</p>
            </a>
          </li>
          <li>
            <a href="/deleted/discount">
              <i class="nc-icon nc-tile-56"></i>
              <p>Deleted Discount</p>
            </a>
          </li>
          <li>
            <a href="/reviews">
              <i class="nc-icon nc-bullet-list-67"></i>
              <p>Review</p>
            </a>
          </li>
        </ul>
      </div>
    </div>
    <div class="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-absolute fixed-top navbar-transparent">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <div class="navbar-toggle">
              <button type="button" class="navbar-toggler">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
              </button>
            </div>
            <a class="navbar-brand" href="javascript:;">Dashboard</a>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end" id="navigation">
              <li class="nav-item btn-rotate dropdown mr-5">
                    <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fa fa-bell">
                          <div class="dropdown-menu py-3 px-2">
                              @if ($notif->count()==0)
                              <p>Tidak Ada Notif</p>
                              @endif
                              @foreach($notif as $item)
                              @php
                              $data=json_decode($item->data,true);
                              @endphp
                              <div style="cursor:pointer;" onclick="readNotif({{$item->id}})" data-notif="{{$item->id}}"class="card mb-1 p-3">{{$data['message']}}</div>
                              @endforeach
                              </div>
                              <form id="bacaNotif" action="/admin/notifikasi/baca" method="post">
                              @csrf
                              <input type="hidden" id="notif_id" name="id_notif">
                              </form>
                      </i>
                  </a>
              </li>
            <form>
              <div class="input-group no-border">
                <input type="text" value="" class="form-control" placeholder="Search...">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <i class="nc-icon nc-zoom-split"></i>
                  </div>
                </div>
              </div>
            </form>
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link btn-magnify" href="/statistic">
                  <i class="nc-icon nc-layout-11"></i>
                  <p>
                    <span class="d-lg-none d-md-block">Stats</span>
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link btn-rotate" href="javascript:;">
                    <li class="nav-item dropdown mr-4">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                          {{ Auth::user()->name }}
                        </a>

                          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('admin.logout') }}"
                              onclick="event.preventDefault();
                              document.getElementById('admin-logout-form').submit();">
                              {{ __('Logout') }}
                            </a>
                              
                            <form id="admin-logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                              @csrf
                            </form>
                          </div>
                  </li>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </nav>
      <!-- End Navbar -->

      <!-- CONTENT-->
      <div class="content">
        @yield('content')
      </div>

      <!--END CONTENT/FOOTER-->
      <footer class="footer footer-black  footer-white ">
        <div class="container-fluid">
          <div class="row">
            <nav class="footer-nav">
              <ul>
                <li><a href="https://www.creative-tim.com" target="_blank">Kelompok 18</a></li>
                <li><a href="https://www.creative-tim.com/blog" target="_blank">Blog</a></li>
                <li><a href="https://www.creative-tim.com/license" target="_blank">Licenses</a></li>
              </ul>
            </nav>
            <div class="credits ml-auto">
              <span class="copyright">
                © <script>
                  document.write(new Date().getFullYear())
                </script>, made with <i class="fa fa-heart heart"></i> by Kelompok 18
              </span>
            </div>
          </div>
        </div>
      </footer>
    </div>
  </div>
  <!--   Core JS Files   -->
  <script src="../assets/js/core/jquery.min.js"></script>
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <!--  Google Maps Plugin    -->
  <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
  <!-- Chart JS -->
  <script src="../assets/js/plugins/chartjs.min.js"></script>
  <!--  Notifications Plugin    -->
  <script src="../assets/js/plugins/bootstrap-notify.js"></script>
  <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../assets/js/paper-dashboard.min.js?v=2.0.1" type="text/javascript"></script><!-- Paper Dashboard DEMO methods, don't include it in your project! -->
  <script src="../assets/demo/demo.js"></script>
  <script>
    $(document).ready(function() {
      // Javascript method's body can be found in assets/assets-for-demo/js/demo.js
      demo.initChartsPages();
    });
  </script>

  <script>
    function readNotif(id){
        $('#notif_id').val(id);
        $('#bacaNotif').submit();
    }
  </script>
</body>

</html>
