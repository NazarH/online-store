  <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Sidebar -->
        <div class="sidebar">
            @auth
            <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="row align-items-center" >
                        <img src="/vendor/adminlte/dist/img/AdminLTELogo.png" alt="Logo" class="brand-image img-circle elevation-3 ml-2" style="opacity: .8">

                        <a href="{{route('admin.logs')}}" class="d-block font-weight-bold ml-2" target="_blank">
                            Логи
                        </a>
                    </div>
                </div>
            @endauth

            @include('admin.layouts.inc.sidebar-menu.example')
        </div>
    <!-- /.sidebar -->
  </aside>
