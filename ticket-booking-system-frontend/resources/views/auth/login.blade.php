@extends('layouts.app')

@section('content')
<h2 class="text-xl font-bold mb-4">Login</h2>
<form id="login-form" class="max-w-md mx-auto bg-white p-6 rounded shadow">
    <input type="email" id="email" placeholder="Email" required class="w-full mb-3 border px-3 py-2 rounded">
    <input type="password" id="password" placeholder="Password" required class="w-full mb-3 border px-3 py-2 rounded">
    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Login</button>
</form>

<script>
document.getElementById('login-form').addEventListener('submit', async (e) => {
    e.preventDefault();
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;

    try {
        const res = await axios.post('/login', { email, password });
        localStorage.setItem('token', res.data.token);
        axios.defaults.headers.common['Authorization'] = `Bearer ${res.data.token}`;
        alert('Login successful!');
        window.location.href = '/';
    } catch (err) {
        alert('Login failed: ' + (err.response?.data?.message || 'Invalid credentials'));
    }
});
</script>
@endsection