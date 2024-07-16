<?php

namespace App\Http\Requests;

use App\Models\Meeting;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class UpdateMeetingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && Gate::allows('create', Meeting::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['string', 'max:255'],
            'description' => ['string'],
            'date' => ['date'],
            'time' => ['date_format:H:i'],
        ];
    }
}
