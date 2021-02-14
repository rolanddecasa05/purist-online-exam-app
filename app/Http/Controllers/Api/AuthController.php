<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailSigninNotification;
use App\Online_exam\Sign_in\Contracts\Signin;



class AuthController extends Controller
{
    /**
     * Login user via internal api.
     */
    public function login(Request $request)
    {
       $request->validate([
            'email' => 'required',
            'password' => 'required'
       ]);

       $user = User::where('email', $request->get('email'))->first();

       if(! $user || ! Hash::check($request->get('password'), $user->password))
       {
            return response()->json(['error' => 'Credentials are invalid.'], 404);
       }

       // To Check token details just dump $token.
        $token = $user->createToken($request->header('User-Agent'));

        return response()->json(['token' => $token->plainTextToken], 200);
    }

    /**
     * Login user via 3rd party app.
     */
    public function thirdPartyLogin(Request $request, Signin $fb)
    {
        return $fb->signIn();
        // create a interface one for the one or more concrete class
        // bind it in appserviceprovider.
        // let the app service provider choose based on the request key. e.g service: fb or github, google .. etc

    }


    public function thirdPartyCallback(Request $request, Signin $fb)
    {
        $data = $fb->redirect();

        if(collect($data)->has('email'))
        {
            $user = User::where('email', $data['email'])->first();
            
            if(! $user)
            {
                $password = Str::random(9);
                // create here..
                $user = User::create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => Hash::make($password)
                ]);

                // send mail here ..

                Mail::to($data['email'])->send(new EmailSigninNotification(collect($user)->put('password', $password)));
                //new EmailSigninNotification(collect($user)->put('password', $password));
            }

            // Issue token..
            $token = $user->createToken($request->header('User-Agent'));

            return response()->json(['token' => $token->plainTextToken], 200);
        }
        
        return response()->json($data, 400);
    }
}
