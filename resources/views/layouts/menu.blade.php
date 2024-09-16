@can('admin')
<!-- Este bloque de menú solo es visible para administradores -->
<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="fa fa-cog"></i>
        <p>Editar</p>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="/users" class="nav-link">
                    <i class="fa fa-user"></i>
                    <p>Usuarios</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="/tecnicos" class="nav-link">
                    <i class="fa fa-address-card"></i>
                    <p>Técnicos</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="/editarconsultas" class="nav-link">
                    <i class="fa fa-cogs"></i>
                    <p>Editar consultas</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fa fa-exclamation-circle"></i>
                    <p>Notificaciones</p>
                </a>
            </li>
        </ul>
    </a>
</li>
@endcan