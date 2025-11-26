@extends('layouts.app')

@section('content')
<h2 class="text-xl font-bold mb-4">Register</h2>
<form id="register-form" class="max-w-md mx-auto bg-white p-6 rounded shadow">
    <input type="text" id="name" placeholder="Name" required class="w-full mb-3 border px-3 py-2 rounded">
    <input type="email" id="email" placeholder="Email" required class="w-full mb-3 border px-3 py-2 rounded">
    <input type="text" id="contact_no" placeholder="Contact Number" required class="w-full mb-3 border px-3 py-2 rounded">
    <input type="password" id="password" placeholder="Password" required class="w-full mb-3 border px-3 py-2 rounded">
    <input type="password" id="password_confirmation" placeholder="Confirm Password" required class="w-full mb-3 border px-3 py-2 rounded">
    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Register</button>
</form>

<script>
document.getElementById('register-form').addEventListener('submit', async (e) => {
    e.preventDefault();
    const data = {
        name: document.getElementById('name').value,
        email: document.getElementById('email').value,
        contact_no: document.getElementById('contact_no').value,
        password: document.getElementById('password').value,
        password_confirmation: document.getElementById('password_confirmation').value
    };

    try {
        const res = await axios.post('/register', data);
        localStorage.setItem('token', res.data.token);
        axios.defaults.headers.common['Authorization'] = `Bearer ${res.data.token}`;
        alert('Registration successful!');
        window.location.href = '/';
    } catch (err) {
        alert('Registration failed: ' + (err.response?.data?.message || 'Check your inputs'));
    }
});
</script>
@endsection