<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Resources\AppointmentResource;
use App\Models\Appointment;
use App\Models\User;
use Carbon\Carbon;
use Inertia\Inertia;

class AppointmentController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Eager load creator & invitees to avoid N+1 queries.
        $appointments = Appointment::with(['creator', 'invitees'])
            ->where('creator_id', $user->id)
            ->orWhereHas('invitees', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->orderBy('start', 'asc')
            ->paginate(10);

        return Inertia::render('Appointments/Index', [
            'appointments' => AppointmentResource::collection($appointments),
        ]);
    }

    public function create()
    {
        // In a real app, this should be paginated or an async search.
        // For testing, we send all other users.
        $users = User::where('id', '!=', auth()->id())->get(['id', 'name', 'username', 'preferred_timezone']);

        return Inertia::render('Appointments/Create', [
            'users' => $users,
        ]);
    }

    public function store(StoreAppointmentRequest $request)
    {
        $appointment = Appointment::create([
            'title' => $request->title,
            'creator_id' => auth()->id(),
            'start' => Carbon::parse($request->start)->utc(),
            'end' => Carbon::parse($request->end)->utc(),
        ]);

        if ($request->has('invitees')) {
            $appointment->invitees()->sync($request->invitees);
        }

        return redirect()->route('appointments.index')
            ->with('success', 'Jadwal berhasil dibuat!');
    }
}
