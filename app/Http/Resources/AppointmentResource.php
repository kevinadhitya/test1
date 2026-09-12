<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'start' => $this->start->toISOString(), // Always send UTC ISO string to frontend
            'end' => $this->end->toISOString(),
            'creator' => [
                'id' => $this->creator->id,
                'name' => $this->creator->name,
                'username' => $this->creator->username,
            ],
            'invitees' => $this->invitees->map(function ($invitee) {
                return [
                    'id' => $invitee->id,
                    'name' => $invitee->name,
                    'username' => $invitee->username,
                ];
            }),
        ];
    }
}
