<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
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
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        $login = $this->input('login');
        $password = $this->input('password');
        $remember = $this->boolean('remember');

        // Cek apakah login berupa angka (NISN) atau email
        if (is_numeric($login)) {
            // Login sebagai siswa pakai NISN
            $user = \App\Models\User::whereHas('siswa', function ($q) use ($login) {
                $q->where('nisn', $login);
            })->first();
            if ($user && \Illuminate\Support\Facades\Hash::check($password, $user->password)) {
                \Illuminate\Support\Facades\Auth::login($user, $remember);
            } else {
                \Illuminate\Support\Facades\RateLimiter::hit($this->throttleKey());
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'login' => trans('auth.failed'),
                ]);
            }
        } else {
            // Login sebagai admin/petugas pakai email
            if (!\Illuminate\Support\Facades\Auth::attempt(['email' => $login, 'password' => $password], $remember)) {
                \Illuminate\Support\Facades\RateLimiter::hit($this->throttleKey());
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'login' => trans('auth.failed'),
                ]);
            }
        }

        \Illuminate\Support\Facades\RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'login' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return \Illuminate\Support\Str::transliterate(\Illuminate\Support\Str::lower($this->string('login')) . '|' . $this->ip());
    }
}
