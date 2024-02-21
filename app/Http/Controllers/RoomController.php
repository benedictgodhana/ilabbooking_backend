<?php

namespace App\Http\Controllers;
use App\Models\Room;
use Validator;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::all();
        return response()->json(['rooms' => $rooms]);
    }

    public function addRoom(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'capacity' => 'required|integer',
            'description' => 'nullable|string',
        ]);

        // If validation fails, return error response
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        // Create a new room instance
        $room = new Room();
        $room->name = $request->input('name');
        $room->capacity = $request->input('capacity');
        $room->description = $request->input('description', ''); // Use default value if description is not provided

        // Save the room to the database
        $room->save();

        // Return success response with the added room data
        return response()->json(['message' => 'Room added successfully', 'room' => $room], 200);
    }
     public function update(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'capacity' => 'required|integer',
            'description' => 'nullable|string',
        ]);

        // Find the room by ID
        $room = Room::findOrFail($id);

        // Update the room with the new data
        $room->update([
            'name' => $request->name,
            'capacity' => $request->capacity,
            'description' => $request->description,
        ]);

        // Return a success response
        return response()->json(['message' => 'Room updated successfully', 'room' => $room]);
    }

    public function destroy($id)
    {
        $room = Room::findOrFail($id);

        // Delete the room
        $room->delete();

        return response()->json(['message' => 'Room deleted successfully']);
    }
}
