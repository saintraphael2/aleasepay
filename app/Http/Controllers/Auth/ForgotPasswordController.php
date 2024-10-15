<?php 

  

namespace App\Http\Controllers\Auth; 

  

use App\Http\Controllers\Controller;

use Illuminate\Http\Request; 

use DB; 

use Carbon\Carbon; 

use App\Models\User; 

use Mail; 

use Hash;

use Illuminate\Support\Str;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Log;
  

class ForgotPasswordController extends Controller{

      /**
       * Write code on Method
       *
       * @return response()
       */
      public function showForgetPasswordForm(){
         return view('auth.passwords.forgetPassword');
      }

      public function showLinkRequestForm(){
         return view('auth.forgetPasswordLink');
      }

      
      public function showErrorpage() {
         return view('auth.errorPage');
      }

      /**
       * Write code on Method
       *
       * @return response()
       */
      public function submitForgetPasswordForm(Request $request) {
          $request->validate([
              'email' => 'required|email|exists:users',]);
          $token = Str::random(64);
          DB::table('password_reset_tokens')->where(['email'=> $request->email])->delete();
          DB::table('password_reset_tokens')->insert([
              'email' => $request->email, 
              'token' => $token, 
              'created_at' => Carbon::now()
            ]);

          Mail::send('auth.passwords.forgetPwd', ['token' => $token], function($message) use($request){
              $message->to($request->email);
              $message->subject('Reset Password');
          });
          return back()->with('message', 'Nous avons envoyé par e-mail votre lien de réinitialisation de mot de passe!');
      }

      /**
       * Write code on Method
       *
       * @return response()
       */
      public function showResetPasswordForm($token) { 
        #return view('auth.forgetPasswordLink', ['token' => $token]);

        $resetPassword = DB::table('password_reset_tokens')->where('token', $token)->first();
        if ($resetPassword) {
            // Si le token existe, afficher le formulaire de réinitialisation
            return view('auth.forgetPasswordLink', ['token' => $token]);
        } else {
            // Si le token n'existe pas, rediriger vers une page d'erreur
            return redirect()->route('errorpage')->with('error', 'Le lien est expiré!');
        }
      }

  

      /**
       * Write code on Method
       *
       * @return response()
       */
      public function submitResetPasswordForm(Request $request){
          $request->validate([
              'email' => 'required|email|exists:users',
              'password' => 'required|string|min:6|confirmed',
              'password_confirmation' => 'required'
          ]);
          $updatePassword = DB::table('password_reset_tokens')
                              ->where([
                                'email' => $request->email, 
                                'token' => $request->token
                              ])
                              ->first();
          if(!$updatePassword){
              return back()->withInput()->with('error', 'Invalid token!');
          }
          $user = User::where('email', $request->email)
                      ->update(['password' => Hash::make($request->password)]);
          DB::table('password_reset_tokens')->where(['email'=> $request->email])->delete();
          return redirect('/login')->with('message', 'Votre mot de passe a été modifié avec succès!');
      }

}