<?php

namespace App\Repositories;

use App\Models\Users;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserRepository
{
    /**
     * Trouver un utilisateur par email.
     *
     * @param string $email
     * @return User|null
     */
    public function findByEmail(string $email)
    {
        Log::info('Searching for user with email: ' . $email);
        return Users::where('email', $email)->first();
    }

    /**
     * Mettre à jour le mot de passe de l'utilisateur.
     *
     * @param User $user
     * @param string $password
     * @return bool
     */
    public function updatePassword(Users $user, string $password)
    {
        Log::info('Updating password for user: ' . $user->email);
        
        $user->password = Hash::make($password);
        return $user->save();
    }
}
