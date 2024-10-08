<?php
namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class PasswordController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function update(Request $request)
    {
        // $request->validate([
        //     'email' => 'required|email',
        //     'password' => 'required|min:6',
        //     'confirm_password' => 'required|same:password',
        // ]);

        // Recherche de l'utilisateur
        $user = $this->userRepository->findByEmail($request->input('email'));

        if (!$user) {
            Log::error("Utilisateur non trouvé avec l'email : " . $request->input('email'));
            Session::flash('error', 'User not found');
            return back();
        }

        // Mise à jour du mot de passe
        if ($this->userRepository->updatePassword($user, $request->input('password'))) {
            Log::info("Mot de passe modifié avec succès pour l'email : " . $user->email);
            Session::flash('success', 'Password updated successfully');
            return redirect('/login');
        } else {
            Log::error("Échec de la mise à jour du mot de passe pour l'email : " . $user->email);
            Session::flash('error', 'Failed to update password');
        }

        return back();
    }
}
