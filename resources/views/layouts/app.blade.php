<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title>Ujian Online</title>
  <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
  <link rel="icon" href="/assets/img/kaiadmin/favicon.ico" type="image/x-icon" />
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.3/css/jquery.dataTables.min.css">

  <!-- Fonts and icons -->
  <script src="/assets/js/plugin/webfont/webfont.min.js"></script>
  <script>
    WebFont.load({
      google: { families: ["Public Sans:300,400,500,600,700"] },
      custom: {
        families: ["Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"],
        urls: ["/assets/css/fonts.min.css"],
      },
      active: function () {
        sessionStorage.fonts = true;
      },
    });
  </script>

  <!-- CSS Files -->
  <link rel="stylesheet" href="/assets/css/bootstrap.min.css" />
  <link rel="stylesheet" href="/assets/css/plugins.min.css" />
  <link rel="stylesheet" href="/assets/css/kaiadmin.min.css" />
  <!-- CSS for demo purpose -->
  <link rel="stylesheet" href="/assets/css/demo.css" />
</head>

<body>
  <div class="wrapper">

    <!-- Sidebar -->
     @include ('layouts.sidebar')
    <!-- End Sidebar -->

    <!-- Main Panel -->
    <div class="main-panel">
      <!-- Main Header -->
      @include ('layouts.header')
      <!-- End Main Header -->

      <!-- Content -->
      <div class="container">
        <div class="page-inner">
            @yield('page-header')
          
           @yield('content')
          
        </div>
      </div>
      <!-- End Content -->

      <!-- Footer -->
      @include ('layouts.footer')
      <!-- End Footer -->

    </div>
    <!-- End Main Panel -->

  </div>

  <!-- Core JS Files -->
  <script src="/assets/js/core/jquery.min.js"></script>
  <script src="/assets/js/core/bootstrap.bundle.min.js"></script>
  <script src="/assets/js/kaiadmin.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function () {
        $('#table').DataTable(); // Ganti #example dengan ID tabel Anda
    });
</script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
        const navItems = document.querySelectorAll('.nav-item > a');

        navItems.forEach(item => {
            item.addEventListener('click', function() {
                // Hapus kelas 'active' dari semua nav-item
                navItems.forEach(nav => nav.parentElement.classList.remove('active'));
                
                // Tambahkan kelas 'active' pada nav-item yang diklik
                this.parentElement.classList.add('active');
            });
        });
    });
</script>
</body>
</html>
