<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //GET ALL USERS
    public function index()
    {
        $users = User::paginate(20);
        return response()->json([
            'current_page' => $users->currentPage(),
            'users' => $users->items(),
            'totalUsers' => $users->total(),
            'usersPerPage' => $users->perPage(),
            'totalPages' => $users->lastPage(),

        ]);
    }

    // UPDATE USER
    public function update(Request $request, $id)
    {
        // Validation des données utilisateur
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
        ], [
                'email.unique' => 'Un utilisateur existe déjà avec cet email.',
                'password.confirmed' => 'Le mot de passe et la confirmation ne correspondent pas.',
            ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        try {
            // Vérifier si l'utilisateur existe
            $user=User::find($id);
        if (!$user) {
            return response(['message' => "Aucun utilisateur trouvé avec id:$id !"], 404);
        }

            // Mettre à jour les données de l'utilisateur avec les nouvelles données validées
            $user->name = $request->name;
            $user->email = $request->email;

            if ($request->has('password')) {
                $user->password = bcrypt($request->password);
            }

            // Sauvegarder les modifications
            $user->save();

            // Success message
            return response()->json(['message' => 'Utilisateur mis à jour avec succès !'], 200);
        } catch (\Exception $e) {
            // Gestion des erreurs de la base de données
            return response()->json(['error' => 'Une erreur est survenue lors de la mise à jour de l\'utilisateur.'], 500);
        }
    }



    // DELETE USER ACCOUNT
    public function deleteAccount(Request $request)
    {
        $user = $request->user();

        DB::beginTransaction();
        try {
            //Delete user and all his tokens
            $user->tokens()->delete();
            $user->delete();

            DB::commit();
            return response(['message' => 'Compte utilisateur supprimé avec succès.'], 200);

        } catch (\Exception $e) {
            DB::rollback();
            return response(['message' => 'Une erreur s\'est produite lors de la suppression du compte utilisateur.'], 500);
        }
    }


}