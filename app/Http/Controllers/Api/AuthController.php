<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        $user = User::where('email', $request->email)->first();

        if($user->role=="client"){
            if (! $user || ! Hash::check($request->password, $user->password)) {
                return response()->json(['message' => 'Identifiants invalides'], 401);
            }

            if($user->status==0){
                Auth::logout();
                return response()->json(['message' => 'Désolé, vous votre compte est bloqué. Contactez admin.']);
            }

            // Supprimer les anciens tokens si nécessaire
            $user->tokens()->delete();

            // Créer un nouveau token
            $token = $user->createToken('api-token')->plainTextToken;

            return response()->json([
                'message' => 'Connexion réussie',
                'user' => $user,
                'token' => $token
            ]);
        }else{
            Auth::logout();
            return response()->json(['message' => 'Désolé, vous êtes admin. Login échoué.']);
        }
    }


    public function deconnexion(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Déconnexion réussie']);
    }

    public function add_user(Request $request){
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|string|email|max:40|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'sexe' => 'required|string|in:homme,femme,autre',
            'contact' => 'required|string|max:20',
            'adresse' => 'required|string|max:255',
            'photo_profil' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Gestion de la photo de profil
        $photoPath = null;
        if ($request->hasFile('photo_profil')) {
            $photoPath = $request->file('photo_profil')->store('profils', 'public');
        }

        $user = User::create([
            'nom' => strtoupper($request->nom),
            'prenom' => $request->prenom,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => '1',
            'role' => "client",
            'sexe' => $request->sexe,
            'contact' => $request->contact,
            'adresse' => $request->adresse,
            'photo_profil' => $photoPath, // chemin vers le fichier
        ]);

        $token = $user->createToken('api_token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'Inscription réussie.',
            'token' => $token,
            'user' => $user
        ]);
    }

    public function update_client(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);

            // Validation
            $validator = Validator::make($request->all(), [
                'nom' => 'required|string|max:255',
                'prenom' => 'required|string|max:255',
                'sexe' => '|string|in:homme,femme,autre',
                'contact' => 'required|string|max:20',
                'adresse' => 'required|string|max:255',
                'photo_profil' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Échec de la validation.',
                    'errors' => $validator->errors(),
                ], 422);
            }

            // Mise à jour des champs (sauf image)
            $user->fill($request->except('photo_profil'));

            // Traitement de la nouvelle photo
            if ($request->hasFile('photo_profil')) {
                $oldPhoto = $user->photo_profil;

                $photoPath = $request->file('photo_profil')->store('profils', 'public');
                $user->photo_profil = $photoPath;

                // Supprimer l'ancienne image si elle existe
                if ($oldPhoto && Storage::disk('public')->exists($oldPhoto)) {
                    Storage::disk('public')->delete($oldPhoto);
                }
            }

            $user->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Utilisateur mis à jour avec succès.',
                'user' => $user
            ], 200);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Utilisateur non trouvé.'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Une erreur est survenue lors de la mise à jour.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
