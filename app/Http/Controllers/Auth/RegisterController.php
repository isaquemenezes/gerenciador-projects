<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Services\UserService;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    protected UserService $userService;
    public function __construct(UserService $service)
    {
        $this->userService = $service;
    }
    public function create()
    {
        return view('auth.register');
    }

    public function store(StoreUserRequest $request)
    {

        try {

            $user = $this->userService->create(
                $request->validated()
            );

            auth()->login($user);

            Log::info('Usuário cadastrado e logado com sucesso:', [
                'user_id' => $user->id,
                'email' => $user->email
            ]);

            return redirect()->route('dashboard')
                ->with('success', 'Conta criada com sucesso!');

        } catch (\Exception $e) {
            Log::error('Erro ao cadastrar usuário:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()
                ->withInput($request->except('password'))
                ->withErrors(['general' => 'Erro ao criar conta. Tente novamente.']);
        }
    }


}
