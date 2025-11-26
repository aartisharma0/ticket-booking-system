@extends('layouts.app')

@section('content')
<h2 class="text-2xl font-semibold mb-4">Bookings for Event</h2>
<div id="admin-bookings" class="grid grid-cols-1 md:grid-cols-2 gap-6">Loading...</div>

<script>
document.addEventListener('DOMContentLoaded', async () => {
    const container = document.getElementById('admin-bookings');
    container.innerHTML = '';
    const eventId = {{ $eventId }}; // Make sure this is passed from your controller

    try {
        const res = await axios.get(`/bookings-by-event/${eventId}`);
        const bookings = res.data.data;

        if (bookings.length === 0) {
            container.innerHTML = `<div class="bg-yellow-100 text-yellow-800 p-4 rounded">No bookings for this event.</div>`;
            return;
        }

        bookings.forEach(b => {
            const div = document.createElement('div');
            div.className = 'bg-white p-4 rounded shadow mb-4';
            div.innerHTML = `
                <p><strong>User:</strong> ${b.user?.name ?? 'Deleted User'} (${b.user?.email ?? 'N/A'})</p>
                <p><strong>Seats:</strong> ${b.seats_booked}</p>
                <p><strong>Total:</strong> AED ${parseFloat(b.total_amount).toFixed(2)}</p>
                <p><strong>Booked At:</strong> ${new Date(b.created_at).toLocaleString()}</p>
            `;
            container.appendChild(div);
        });
    } catch (err) {
        container.innerHTML = `<div class="bg-red-100 text-red-800 p-4 rounded">Failed to load admin bookings.</div>`;
    }
});
</script>
@endsection