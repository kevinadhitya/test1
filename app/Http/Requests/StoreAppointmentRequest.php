<?php

namespace App\Http\Requests;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class StoreAppointmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'start' => 'required|date',
            'end' => 'required|date|after:start',
            'invitees' => 'nullable|array',
            'invitees.*' => 'exists:users,id',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($validator->errors()->any()) {
                return;
            }

            // Convert to UTC first
            $startUtc = Carbon::parse($this->start)->utc();
            $endUtc = Carbon::parse($this->end)->utc();

            // Collect participants
            $userIds = $this->invitees ?? [];
            $userIds[] = $this->user()->id; // Creator is always a participant

            // Get unique participants
            $participants = User::whereIn('id', array_unique($userIds))->get();

            foreach ($participants as $user) {
                $tz = $user->preferred_timezone ?? 'UTC';

                // Convert UTC back to participant's local time
                $localStart = $startUtc->copy()->timezone($tz);
                $localEnd = $endUtc->copy()->timezone($tz);

                // 1. Check Same Day Constraint
                if ($localStart->toDateString() !== $localEnd->toDateString()) {
                    $validator->errors()->add('start', "Jadwal melintasi hari untuk user {$user->name} ({$tz}). Jadwal harus selesai di hari yang sama.");

                    return; // Fail fast
                }

                // 2. Check Working Hours (08:00 - 17:00) Constraint
                $startLimit = $localStart->copy()->setTime(8, 0, 0);
                $endLimit = $localStart->copy()->setTime(17, 0, 0);

                if ($localStart->lt($startLimit) || $localEnd->gt($endLimit)) {
                    $validator->errors()->add(
                        'start',
                        "Waktu berada di luar jam kerja (08:00-17:00) untuk {$user->name} pada zona waktu lokal mereka ({$tz})."
                    );

                    return; // Fail fast
                }
            }
        });
    }
}
