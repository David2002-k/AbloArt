<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // Informations de la table users
            'name' => ['required', 'string', 'max:255'],

            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],

            // Informations de la table admins
            'biographie' => ['nullable', 'string'],

            'telephone' => [
                'nullable',
                'string',
                'max:30',
            ],

            'adresse' => [
                'nullable',
                'string',
                'max:500',
            ],

            // Changement de mot de passe optionnel
            'current_password' => ['nullable', 'required_with:password', 'current_password'],

            'password' => ['nullable', 'required_with:current_password', Password::defaults(), 'confirmed'],

            'password_confirmation' => ['nullable', 'required_with:password'],

            // Photo de profil
            'photo' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            // CV
            'cv' => [
                'nullable',
                'file',
                'mimes:pdf,doc,docx',
                'max:5120',
            ],
        ];
    }
}
