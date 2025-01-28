<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link {{ Request::is('dashboard') ? '' : 'collapsed' }}" href="/dashboard">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->

        <li class="nav-heading">Menu</li>

        <li class="nav-item">
            <a class="nav-link {{ Request::is('gejala*') ? '' : 'collapsed' }}" href="{{ route('gejala.index') }}">
                <i class="bi bi-activity"></i>
                <span>Gejala</span>
            </a>
        </li><!-- End Gejala Page Nav -->

        <li class="nav-item">
            <a class="nav-link {{ Request::is('penyakit*') ? '' : 'collapsed' }}" href="{{ route('penyakit.index') }}">
                <i class="bi bi-patch-question"></i>
                <span>Penyakit</span>
            </a>
        </li><!-- End Penyakit Page Nav -->

        <li class="nav-item">
            <a class="nav-link {{ Request::is('nilaicf*') ? '' : 'collapsed' }}" href="{{ route('nilaicf.index') }}">
                <i class="bi bi-gear"></i>
                <span>Nilai Certainty Factor</span>
            </a>
        </li><!-- End Nilai CF Page Nav -->

        <li class="nav-item">
            <a class="nav-link {{ Request::is('hasil_diagnosis*') ? '' : 'collapsed' }}" href="{{ route('diagnosis.indexAdmin') }}">
                <i class="bi bi-clipboard2-data"></i>
                <span>Hasil Diagnosa</span>
            </a>
        </li>

        <li class="nav-heading">Pengaturan</li>

        <li class="nav-item">
            <a class="nav-link {{ Request::is('admin*') ? '' : 'collapsed' }}" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-person"></i><span>Admin</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="forms-nav" class="nav-content collapse {{ Request::is('admin*') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('admin.create') }}" class="{{ Request::routeIs('admin.create') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>Tambah Admin</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.list') }}" class="{{ Request::routeIs('admin.list') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>Daftar Admin</span>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item">
    <a class="nav-link collapsed" href="{{ route('landing') }}">
        <i class="bi bi-house-door"></i>
        <span>Landing Page</span>
    </a>
</li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('logout') }}"
                onclick="event.preventDefault();
                          document.getElementById('logout-form').submit();">
                <i class="bi bi-box-arrow-right"></i>{{ __('Logout') }}
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </li><!-- End Logout Nav -->

    </ul>
</aside>
