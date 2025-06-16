<?php
namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'password' => 'required|string',
        ];
    }

    public function authenticate(): void
    {

        $user = User::where(
            'email',
            $this->input(
                'email'
                ))->first();

        if (! $user || ! Hash::check($this->input('password'), $user->password)) {
            throw ValidationException::withMessages([
                'email' => __('As credenciais estão incorretas ou o usuário está inativo.'),
            ]);
        }

        Auth::login($user, $this->boolean('remember'));
    }


}
