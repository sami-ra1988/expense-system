<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApprovalRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'request_ids' => 'required|array',
            'action'      => 'required|in:approve,reject',
            'reason'      => 'required_if:action,reject'
        ];
    }
}
