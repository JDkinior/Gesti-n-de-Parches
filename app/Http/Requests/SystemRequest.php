<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SystemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:120'],
            'owner' => ['nullable', 'string', 'max:120'],
            'current_version' => ['required', 'string', 'max:50'],
            'latest_version' => ['required', 'string', 'max:50'],
            'risk_level' => ['required', 'in:low,medium,high,critical'],
            'status' => ['required', 'in:updated,outdated,unknown'],
            'is_documented' => ['nullable', 'boolean'],
            'last_updated_at' => ['nullable', 'date'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function validatedPayload(): array
    {
        $validated = $this->validated();
        $validated['is_documented'] = $this->boolean('is_documented');

        return $validated;
    }
}
