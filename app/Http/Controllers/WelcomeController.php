<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class WelcomeController extends Controller
{

    public function index()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        } else {
            return redirect()->route('login');
        }
    }

    public function casLogin()
    {
        if (cas()->isAuthenticated()) {
            $username = cas()->getCurrentUser();
            $user = User::where('username', $username)->first();

            if (!is_null($user)) {
                $credentials = [
                    'email' => $user->email,
                    'password' => $user->email,
                    'active' => 1,
                ];

                if (Auth::attempt($credentials)) {
                    return redirect()->route('dashboard');
                } else {
                    cas()->logout();
                    Auth::logout();

                    return redirect()->route('login');
                }
            } else {
                return redirect()->route('login')->with('alert', $this->getAlert('RECORD_NOT_FOUND'));
            }
        }
    }
}
