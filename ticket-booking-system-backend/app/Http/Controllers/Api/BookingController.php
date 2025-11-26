<?php

namespace App\Http\Controllers\Api;

use App\Models\Event;
use App\Models\Booking;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class BookingController extends Controller
{

    public function bookticket(Request $request, $eventId)
    {
        try {
            $data = $request->validate([
                'user_id' => 'required|integer|exists:users,id',
                'seats_booked' => 'required|integer|min:1',
            ]);

            $event = Event::findOrFail($eventId);

            $bookedSeats = Booking::where('event_id', $event->id)->sum('seats_booked');
            $availableSeats = $event->total_seats - $bookedSeats;

            if ($data['seats_booked'] > $availableSeats) {
                return response()->json(['message' => 'Not enough available seats'], 400);
            }
            $data['event_id'] = $event->id;
            $data['total_amount'] = $data['seats_booked'] * ($event->price ?? 0);

            $booking = Booking::create($data);

            return response()->json(['message' => 'Event Booked Successfully', 'data' => $booking], 201);

        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Event not found'], 404);
        }
    }

    public function bookingByEvent($eventId)
    {
        $event = Event::findOrFail($eventId);
        $bookings = Booking::with('user')->where('event_id', $event->id)->get();
        return response()->json(['message' => 'Booking retrieved successfully', 'data' => $bookings], 200);
    }
    public function userBookings()
    {
        $bookings = Booking::with('event')
            ->where('user_id', auth()->id())
            ->get();
        return response()->json(['message' => 'Booking retrieved successfully', 'data' => $bookings], 200);
    }


}
