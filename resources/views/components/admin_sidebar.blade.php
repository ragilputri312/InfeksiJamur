 <!-- ======= Sidebar ======= -->
 <aside id="sidebar" class="sidebar">

  <ul class="sidebar-nav" id="sidebar-nav">

    <li class="nav-item">
      <a class="nav-link " href="/dashboard">
        <i class="bi bi-grid"></i>
        <span>Dashboard</span>
      </a>
    </li><!-- End Dashboard Nav -->

    <li class="nav-heading">Menu</li>

    <li class="nav-item">
      <a class="nav-link collapsed" href="{{ route('gejala.index') }}">
        <i class="bi bi-activity"></i>
        <span>Gejala</span>
      </a>
    </li><!-- End Gejala Page Nav -->

    <li class="nav-item">
      <a class="nav-link collapsed" href="{{ route('penyakit.index') }}">
        <i class="bi bi-patch-question"></i>
        <span>Penyakit</span>
      </a>
    </li><!-- End Depresi Page Nav -->

    <li class="nav-item">
      <a class="nav-link collapsed" href="/dashboard/hasildiagnosa">
        <i class="bi bi-clipboard2-data"></i>
        <span>Hasil Diagnosa</span>
      </a>
    </li><!-- End Depresi Page Nav -->

    <li class="nav-heading">Pengaturan</li>

    <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-person"></i><span>Admin</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li>
          <a href="{{ route('admin.create') }}">
            <i class="bi bi-circle"></i><span>Tambah Admin</span>
          </a>
        </li>
        <li>
          <a href="{{ route('admin.list') }}">
            <i class="bi bi-circle"></i><span>Daftar Admin</span>
          </a>
        </li>
      </ul>
    </li><!-- End Forms Nav -->




    <li class="nav-item" style="nowrap">

      <a class="nav-link collapsed" href="{{ route('logout') }}"
        onclick="event.preventDefault();
                      document.getElementById('logout-form').submit();">
         <i class="bi bi-box-arrow-right"></i>{{ __('Logout') }}
     </a>
     <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
       @csrf
    </form>
    </li><!-- End F.A.Q Page Nav -->

  </ul>

</aside><!-- End Sidebar-->
