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
       $users = User::paginate(20);
       return response()->json([
           'users' => $users->items(),
           'totalUsers' => $users->total(),
           'usersPerPage' => $users->perPage(),
           'totalPages' => $users->lastPage(),
           'page' => $users->currentPage()
       ]);
   }
   
    
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
