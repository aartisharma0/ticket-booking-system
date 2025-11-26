@extends('layouts.app')

@section('content')
<h2 class="text-2xl font-semibold mb-4">Available Events</h2>
<div id="event-list" class="grid grid-cols-1 md:grid-cols-2 gap-6"></div>

<script>
document.addEventListener('DOMContentLoaded', async () => {
    const res = await axios.get('/events');
    const events = res.data;
    const container = document.getElementById('event-list');

    events.forEach(event => {
        const card = document.createElement('div');
        card.className = 'bg-white p-4 rounded shadow';
        card.innerHTML = `
            <h3 class="text-xl font-bold">${event.title}</h3>
            <p>${event.description}</p>
            <p><strong>Date:</strong> ${event.date} at ${event.time}</p>
            <p><strong>Location:</strong> ${event.location}</p>
            <p><strong>Price:</strong> AED ${event.price}</p>
            <a href="/book/${event.id}" class="mt-2 inline-block bg-blue-500 text-white px-4 py-2 rounded">Book Now</a>
        `;
        container.appendChild(card);
    });
});
</script>
@endsection