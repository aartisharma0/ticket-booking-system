<form id="booking-form">
    <input type="number" name="seats_booked" id="seats_booked" required>
    <button type="submit">Book</button>
</form>

<script>
document.getElementById('booking-form').addEventListener('submit', async (e) => {
    e.preventDefault();
    const seats = document.getElementById('seats_booked').value;
    const eventId = {{ $event->id }};

    try {
        const res = await axios.post(`/bookings/${eventId}`, {
            user_id: {{ auth()->id() }},
            seats_booked: seats
        });
        alert('Booking successful!');
        window.location.href = '/my-bookings';
    } catch (err) {
        alert('Booking failed: ' + err.response.data.message);
    }
});
</script>