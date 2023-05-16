<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
   //GET ALL USERS
    public function index()
    {
        $users = User::all();
        return response()->json(['users' => $users]);
    }

    
   /* public function destroy(Request $request)
    {
        $user = $request->user();
        $user->delete();
        return response()->json(['message' => 'Votre compte a été supprimé']);
    }*/
    
    // DELETE USER ACCOUNT
    public function deleteAccount(Request $request){
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
