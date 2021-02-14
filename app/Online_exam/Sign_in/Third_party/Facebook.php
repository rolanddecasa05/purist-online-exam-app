<?php

namespace App\Online_exam\Sign_in\Third_party;

use Laravel\Socialite\Facades\Socialite;
use GuzzleHttp\Exception\ClientException;
use App\Online_exam\Sign_in\Contracts\Signin;

class Facebook implements Signin {

    public function signIn()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function redirect()
    {
        try {
            $user = Socialite::driver('facebook')->user();

            return [
                'clientId' => $user->getId(),
                'name' => $user->getName(),
                'email' => $user->getEmail(),
                'avatar' => $user->getAvatar()
            ];
        } catch (ClientException $exception) {
            $error = collect(json_decode($exception->getResponse()->getBody()->getContents(), true));

            return [
                'message' => $error['error']['message'],
                'type' => $error['error']['type'],
                'stack_trace' => $error['error']['fbtrace_id'],
                'service' => 'facebook'
            ];
        }
    }
}