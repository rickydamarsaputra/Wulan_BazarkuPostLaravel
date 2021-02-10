<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Bazarku | @yield('title')</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css" integrity="sha512-P5MgMn1jBN01asBgU0z60Qk4QxiXo86+wlFahKrsQf37c9cro517WzVSPPV1tDKzhku2iJ2FVgL67wG03SGnNA==" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="{{asset('/assets/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('/assets/css/select2.min.css')}}">
  <link rel="stylesheet" href="{{asset('/assets/css/daterangepicker.css')}}">
  <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.css"> -->

  <!-- Template CSS -->
  <link rel="stylesheet" href="{{asset('/assets/css/style.css')}}">
  <link rel="stylesheet" href="{{asset('/assets/css/components.css')}}">

  <!-- Default Style -->
  <style>
    .main-sidebar .sidebar-menu li ul.dropdown-menu li a {
      color: #868e96;
      height: 35px;
      padding-left: 30px !important;
      font-weight: 400;
    }

    table {
      width: -webkit-fill-available !important;
    }

    table th.text-center.sorting,
    table td {
      font-size: 12px;
    }
  </style>

  <!-- Laravel Styles Stack -->
  @stack('styles')
</head>

<body>
  <div id="app">
    <div class="main-wrapper">
      <div class="navbar-bg"></div>
      <x-navbar />
      <x-sidebar />

      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-body">
            @yield('content')
          </div>
        </section>
      </div>
      <footer class="main-footer">
        <div class="footer-left">
          Copyright {{date('Y')}} Bazarku &middot; App by Rowcell.ID
        </div>
        <!-- <div class="footer-right">
          2.3.0
        </div> -->
      </footer>
    </div>
  </div>

  @include('sweetalert::alert')
  <!-- General JS Scripts -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js" integrity="sha512-XKa9Hemdy1Ui3KSGgJdgMyYlUg1gM+QhL6cnlyTe2qzMCYm4nAZ1PsVerQzTTXzonUR+dmswHqgJPuwCq1MaAg==" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
  <script src="{{asset('/assets/js/stisla.js')}}"></script>
  <!-- <script src="{{asset('/assets/js/jquery-3.5.1.min.js')}}"></script> -->

  <!-- JS Libraies -->
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.js"></script>
  <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.7.3/dist/alpine.min.js" defer></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
  <script src="{{asset('/assets/js/dataTables.bootstrap4.min.js')}}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js" integrity="sha512-bZS47S7sPOxkjU/4Bt0zrhEtWx0y0CRkhEp8IckzK+ltifIIE9EMIMTuT/mEzoIMewUINruDBIR/jJnbguonqQ==" crossorigin="anonymous"></script>
  <script src="{{asset('/assets/js/select2.full.min.js')}}"></script>
  <script src="{{asset('/assets/js/daterangepicker.js')}}"></script>
  <!-- <script src="{{asset('/assets/js/jquery.dataTables.min.js')}}"></script> -->

  <!-- Template JS File -->
  <script src="{{asset('/assets/js/scripts.js')}}"></script>
  <script src="{{asset('/assets/js/custom.js')}}"></script>

  <!-- Page Specific JS File -->
  <script src="{{asset('/assets/js/page/modules-datatables.js')}}"></script>
  <!-- <script src="{{asset('/assets/js/page/forms-advanced-forms.js')}}"></script> -->

  <!-- Default Scripts -->
  <script>
    $(document).ready(() => {
      $("select").select2();
      $(".daterange-cus").daterangepicker({
        locale: {
          format: 'YYYY-MM-DD'
        },
        drops: 'down',
        opens: 'right'
      });

      $(".bazarku__delete__master__item").ready((event) => {
        $(event).on("submit", (e) => {
          const formClass = e.target.getAttribute("class");

          if (formClass) {
            e.preventDefault();
            Swal.fire({
              title: 'Apakah kamu yakin?',
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
              if (result.isConfirmed) {
                e.target.submit();
              }
            });
          }

        });
      });

    });
  </script>

  <!-- Laravel Scripts Stack-->
  @stack('scripts')
</body>

</html>