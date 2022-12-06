<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;


class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME;
    protected $redirectTo = '/login';


    protected function reset(Request $request)
    {

        $validator = Validator::make($request->all(), [
                    'token'    => ['required'],
                    'email'    => ['required', 'email'],
                    'password' => ['required', 'required_with:password-confirm', 'same:password-confirm'],
                    ], [], [
                        'token' => 'Token',
                        'email' => 'E-mail',
                        'password' => 'Senha',
                        'password-confirm' => 'Confirmação de Senha',
                    ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withInput()->with('errors', $validator->messages());

        } else {  

            // Here we will attempt to reset the user's password. If it is successful we
            // will update the password on an actual user model and persist it to the
            // database. Otherwise we will parse the error and return the response.
            $response = $this->broker()->reset(
                $this->credentials($request), function ($user, $password) {
                    $this->resetPassword($user, $password);
                }
            );

            // If the password was successfully reset, we will redirect the user back to
            // the application's home authenticated view. If there is an error we can
            // redirect them back to where they came from with their error message.
            return $response == Password::PASSWORD_RESET
                        ? $this->sendResetResponse($request, $response)
                        : $this->sendResetFailedResponse($request, $response);        
        }
    }


    public function setUserPassword($user, $password)
    {
        $user->senha = Hash::make($password);
        $user->reset_password = 'OK';
    }


}
