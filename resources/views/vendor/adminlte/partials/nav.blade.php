<!-- User Menu -->
<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
        <i class="nav-icon fas fa-user"></i>
        <span class="brand-text font-weight-light">{{ Auth::user()->name }}</span>
    </a>
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <a href="#" class="dropdown-item">
            <i class="fas fa-user mr-2"></i> {{ Auth::user()->role }}
        </a>
        <a href="{{ route('profile') }}" class="dropdown-item">
            <i class="fas fa-cogs mr-2"></i> Configuración
        </a>
        <div class="dropdown-divider"></div>
        <a href="{{ route('logout') }}" class="dropdown-item dropdown-footer">
            <i class="fas fa-sign-out-alt mr-2"></i> Salir
        </a>
    </div>
</li>