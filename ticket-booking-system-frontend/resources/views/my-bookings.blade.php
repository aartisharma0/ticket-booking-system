@extends('layouts.app')

@section('content')
<h2 class="text-2xl font-semibold mb-4">My Bookings</h2>
<div id="booking-list" class="grid grid-cols-1 md:grid-cols-2 gap-6">Loading...</div>

<script>
document.addEventListener('DOMContentLoaded', async () => {
    const container = document.getElementById('booking-list');
    container.innerHTML = '';

    try {
        const res = await axios.get('/user-bookings');
        const bookings = res.data.data;

        if (bookings.length === 0) {
            container.innerHTML = `<div class="bg-yellow-100 text-yellow-800 p-4 rounded">No bookings found.</div>`;
            return;
        }

        bookings.forEach(b => {
            const div = document.createElement('div');
            div.className = 'bg-white p-4 rounded shadow mb-4';
            div.innerHTML = `
                <h3 class="text-lg font-bold">${b.event?.title ?? 'Event Deleted'}</h3>
                <p><strong>Seats:</strong> ${b.seats_booked}</p>
                <p><strong>Total:</strong> AED ${parseFloat(b.total_amount).toFixed(2)}</p>
                <p><strong>Date:</strong> ${b.event?.date ?? 'N/A'} at ${b.event?.time ?? 'N/A'}</p>
                <p class="text-sm text-gray-500">Booked on ${new Date(b.created_at).toLocaleString()}</p>
            `;
            container.appendChild(div);
        });
    } catch (err) {
        container.innerHTML = `<div class="bg-red-100 text-red-800 p-4 rounded">Failed to load bookings.</div>`;
    }
});
</script>
@endsection