<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\User\{
    UpdateUserRequest,
    StoreUserRequest

};

use App\Models\User;
use Illuminate\Support\Facades\Auth;



class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $usuario = Auth::user();
        return view('usuario.perfil', compact('usuario'));
    }


    public function edit($id)
    {
        $usuario = User::findOrFail($id);
        return view('admin.users.edit', compact('usuario'));
    }

    public function update(UpdateUserRequest $request)
    {

        try {
            $user = auth()->user();

            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'tipo' => $request->tipo,
            ]);


            return redirect()
                ->route('usuario.perfil')
                ->with('success', 'Perfil----- atualizado com sucesso!');

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao atualizar o perfil.'
            ], 500);
        }
    }




}
