<h1>Client Dashboard</h1>

<form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit">Cerrar sesión</button>
</form>