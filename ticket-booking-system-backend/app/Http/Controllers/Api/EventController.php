<?php

namespace App\Http\Controllers\Api;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class EventController extends Controller
{
    public function __construct()
    {

    }
    public function index()
    {
        $events = Event::with('bookings')->get();

        return response()->json($events,200);
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'title' => 'required|string|max:255',
                'date' => 'required|date',
                'time' => ['required', 'regex:/^([01]?\d|2[0-3]):[0-5]\d$/'],
                'location' => 'required|string|max:255',
                'description' => 'nullable|string',
                'total_seats' => 'required|integer',
                'image_file' => 'nullable|image|max:5120',
                'price' => 'sometimes|required|numeric|min:0',
            ]);

            if ($request->hasFile('image_file') && $request->file('image_file')->isValid()) {
                $path = $request->file('image_file')->store('events', 'public');
                $data['image_path'] = Storage::url($path);
            }

            $event = Event::create($data);

            return response()->json(['message' => 'Event created successfully', 'data' => $event], 201);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function show($id)
    {
        $event = Event::with('bookings')->findOrFail($id);

        return response()->json(['message' => 'Event retrieved successfully', 'data' => $event], 200);
    }

    public function update(Request $request, $id)
    {

        try {
            $event = Event::findOrFail($id);
            $data = $request->validate([
                'title' => 'sometimes|required|string|max:255',
                'date' => 'sometimes|required|date',
                'time' => ['sometimes', 'required', 'regex:/^([01]?\d|2[0-3]):[0-5]\d$/'],
                'location' => 'sometimes|required|string|max:255',
                'description' => 'nullable|string',
                'total_seats' => 'sometimes|required|integer',
                'image_file' => 'nullable|image|max:5120',
                'image_path' => 'nullable|url',
                'price' => 'sometimes|required|numeric|min:0',
            ]);

            if ($request->hasFile('image_file') && $request->file('image_file')->isValid()) {
                $path = $request->file('image_file')->store('events', 'public');
                $data['image_path'] = Storage::url($path);

                if ($event->image_path) {
                    Storage::delete(str_replace('/storage/', '', $event->image_path));
                }
            }

            $event->update($data);

            return response()->json(['message' => 'Event Updated successfully', 'data' => $event], 200);

        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }
    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();

        return response()->json(['message' => 'Event deleted successfully']);
    }


}
