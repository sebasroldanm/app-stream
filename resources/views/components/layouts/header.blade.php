<header class="bg-dark text-white p-3 sticky-top">
    <h1 class="text-center">Bienvenido a Mi Sitio</h1>
    <nav class="text-center">
        <a href="/" class="text-white mx-2">Inicio</a>
        <a href="/about" class="text-white mx-2">Acerca de</a>
        <a href="/contact" class="text-white mx-2">Contacto</a>
        @guest('customer')
            <a href="/login" class="text-white mx-2">Login</a>
        @endguest
        @auth('customer')
            @livewire('customer-logout')
        @endauth
    </nav>
</header>
