<?php

namespace App\Online_exam\Sign_in\Contracts;

interface Signin {
    public function signIn();
    public function redirect();
}