<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            Log::info('Iniciando busca de usuários');
            $users = User::all();
            Log::info('Usuários encontrados:', ['count' => $users->count()]);
            return response()->json(['users' => $users]);
        } catch (\Exception $e) {
            Log::error('Erro ao buscar usuários:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Erro ao buscar usuários: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'cpf' => 'required|unique:users,cpf|digits:11',
                'password' => 'required|min:6'
            ], [
                'name.required' => 'O campo nome é obrigatorio',
                'email.required' => 'O campo email é obrigatorio',
                'email.unique' => 'O email ja existe',
                'cpf.required' => 'O campo cpf é obrigatorio',
                'cpf.unique' => 'O cpf ja existe',
                'cpf.digits' => 'O cpf deve ter 11 digitos',
                'password.required' => 'O campo senha é obrigatorio',
                'password.min' => 'A senha deve ter no minimo 6 caracteres'
            ]);

            $user = new User();
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->cpf = $request->input('cpf');
            $user->password = bcrypt($request->input('password'));
            $user->save();

            // Recarrega o usuário para garantir que todos os campos estão atualizados
            $user = User::find($user->id);

            Log::info('Usuário criado com sucesso', ['user_id' => $user->id]);
            return response()->json(['message' => 'Usuário criado com sucesso!', 'user' => $user], 201);
        } catch (\Exception $e) {
            Log::error('Erro ao criar usuário:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Erro ao criar usuário: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $user = User::find($id);

            if (!$user) {
                return response()->json(['error' => 'Usuário nao encontrado'], 404);
            }

            return response()->json(['user' => $user]);
        } catch (\Exception $e) {
            Log::error('Erro ao buscar usuário:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Erro ao buscar usuário: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $user = User::find($id);

            if (!$user) {
                return response()->json(['error' => 'Usuário não encontrado'], 404);
            }

            $request->validate([
                'name' => 'sometimes|required|string|max:255',
                'email' => 'sometimes|required|email|unique:users,email,' . $user->id,
                'cpf' => 'sometimes|required|string|unique:users,cpf,' . $user->id,
                'password' => 'sometimes|required|string|min:6'
            ], [
                'email.unique' => 'O email ja existe',
                'email.email' => 'O email deve ser valido',
                'cpf.unique' => 'O cpf ja existe',
                'password.min' => 'A senha deve ter no minimo 6 caracteres'
            ]);

            $user->name = $request->input('name', $user->name);
            $user->email = $request->input('email', $user->email);
            $user->cpf = $request->input('cpf', $user->cpf);

            if ($request->has('password')) {
                $user->password = bcrypt($request->input('password'));
            }

            $user->save();

            Log::info('Usuário atualizado com sucesso', ['user_id' => $id]);
            return response()->json(['message' => 'Usuário atualizado com sucesso!', 'user' => $user]);
        } catch (\Exception $e) {
            Log::error('Erro ao atualizar usuário:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Erro ao atualizar usuário: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $user = User::find($id);

            if (!$user) {
                return response()->json(['error' => 'Usuário não encontrado'], 404);
            }

            $user->delete();

            Log::info('Usuário deletado com sucesso', ['user_id' => $id]);
            return response()->json(['message' => 'Usuário deletado com sucesso!']);
        } catch (\Exception $e) {
            Log::error('Erro ao deletar usuário:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Erro ao deletar usuário: ' . $e->getMessage()], 500);
        }
    }
}
