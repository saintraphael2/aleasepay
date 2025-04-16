<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Profil;
use App\Models\Users;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        Schema::defaultStringLength(191);

        View::composer('*', function ($view) {
            $user = Auth::user();

            if ($user) {
                $profilEntitie = Profil::find($user->profil);
                $profil = $profilEntitie ? $profilEntitie->libelle : null;
            } else {
                $profil = null;
            }

            $view->with('profil', $profil);
            $view->with('initiateur', 'INITIATEUR');
            $view->with('validateur', 'VALIDATEUR');
            $view->with('autonome', 'AUTONOME');
        });
    }
}
