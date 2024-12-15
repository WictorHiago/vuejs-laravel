<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use PhpParser\Node\Stmt\TryCatch;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return response()->json(['users' => $users]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // store
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

            return response()->json(['message' => 'Usuário criado com sucesso!', 'user' => $user], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'Usuário nao encontrado'], 404);
        }

        return response()->json(['user' => $user]);
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

            return response()->json(['message' => 'Usuário atualizado com sucesso!', 'user' => $user]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'Usuário não encontrado'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'Usuário excluído com sucesso!']);
    }
}
