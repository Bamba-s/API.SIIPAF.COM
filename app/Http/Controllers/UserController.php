<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
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
// 
    
    // Update user
    public function update(Request $request, $id)
{
    // User data validation
    $validator = Validator::make($request->all(), [
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
        // Check if user exists
        $user = User::find($id);
        if (!$user) {
            return response(['message' => "Aucun utilisateur trouvé avec l'identifiant : $id !"], 404);
        }

        // Check if the authenticated user is an admin
        $authenticatedUser = auth()->user();
        if (!$authenticatedUser->isAdmin() && $authenticatedUser->id !== $user->id) {
            return response()->json(['error' => 'Vous n\'êtes pas autorisé à effectuer cette action.'], 403);
        }

        // Update the user's data with the new validated data
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->has('password')) {
            $user->password = bcrypt($request->password);
        }

        // save modifications
        $user->save();

        // Success message
        return response()->json(['message' => 'Utilisateur mis à jour avec succès !'], 200);
    } catch (\Exception $e) {
        // Database errors management
        return response()->json(['error' => 'Une erreur est survenue lors de la mise à jour de l\'utilisateur.'], 500);
    }
}


    public function destroy($id)
    {
        try {
            
            // Check if user connected is admin
            if (!Auth::user()->isAdmin()) {
                return response()->json(['error' => 'Vous n\'êtes pas autorisé à supprimer un utilisateur.'], 403);
            }
    
            
            // Find user to delete
            $user = User::find($id);
    
            // Check if user exists
            if (!$user) {
                return response(['message' => "Aucun utilisateur trouvé avec l'ID: $id !"], 404);
            }
    
            // Delete user
            $user->delete();
    
            // Success message
            return response()->json(['message' => 'Utilisateur supprimé avec succès !'], 200);
        } catch (\Exception $e) {
            // Data base errors management
            return response()->json(['error' => 'Une erreur est survenue lors de la suppression de l\'utilisateur.'], 500);
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