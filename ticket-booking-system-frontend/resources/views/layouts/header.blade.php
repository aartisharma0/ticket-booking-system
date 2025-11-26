<header class="bg-white shadow">
    <div class="container mx-auto px-4 py-4 flex justify-between items-center">
        <h1 class="text-xl font-bold">🎟️ Ticket Booking</h1>
        <nav>
            <a href="{{ route('home') }}" class="mx-2">Home</a>
            @auth
                <a href="{{ route('my.bookings') }}" class="mx-2">My Bookings</a>
                @if (auth()->user()->is_admin)
                    <a href="{{ route('admin.bookings') }}" class="mx-2">Admin Panel</a>
                @endif
                <button id="logout-btn" class="mx-2 text-red-500">Logout</button>
            @else
                <a href="{{ route('login') }}" class="mx-2">Login</a>
                <a href="{{ route('register') }}" class="mx-2">Register</a>
            @endauth
        </nav>
    </div>
</header>
<script>
document.getElementById('logout-btn')?.addEventListener('click', async () => {
    try {
        await axios.post('/logout', {}, {
            headers: {
                Authorization: `Bearer ${localStorage.getItem('token')}`
            }
        });
    } catch (err) {
        console.warn('Logout error:', err.response?.data?.message || 'Unknown error');
    } finally {
        localStorage.removeItem('token');
        window.location.href = '/login';
    }
});
</script>
