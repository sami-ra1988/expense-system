<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ExpenseRequestResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'category' => $this->category ? ['id' => $this->category->id, 'title' => $this->category->title] : null,
            'description' => $this->description,
            'amount' => $this->amount,
            'iban' => $this->iban,
            'status' => $this->status,
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'national_code' => $this->user->national_code
            ],
            'files' => $this->media->map(fn($m) => [
                'url'  => url($m->getPath()),
                'name' => $m->file_name
            ]),
            'rejection_reason' => $this->rejection_reason,
            'created_at' => $this->created_at,
        ];
    }
}
