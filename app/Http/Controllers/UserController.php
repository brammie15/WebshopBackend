<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;


class UserController extends Controller
{
    private $salt;
    public function __construct()
    {
        $this->salt="userloginregister";
    }
    public function login(Request $request): string {
        if ($request->has('username') && $request->has('password')) {
            $user = User::where("username", "=", $request->input('username'))
                ->where("password", "=", sha1($this->salt.$request->input('password')))
                ->first();
            if ($user) {
//                #fkP0JepXBe5PJwccHDWTOJYdI3r86jhSAXrgGoDc6r9yklA4dTmnb1Cbpspq
                $token= $this->str_random(60);
                $user->api_token=$token;
                $user->save();
                $welkomTeskt = "Welkom " . $user->username . "!<br>";
                return $welkomTeskt.$user->api_token;
            } else {
                return "Verkeerde gebruikersnaam of wachtwoord";
            }
        } else {
            return "Niet alle velden zijn ingevuld";
        }
    }
    public function register(Request $request): string {
        if ($request->has('username') && $request->has('password') && $request->has('email')) {
            $user = new User;
            $user->username=$request->input('username');
            $user->password=sha1($this->salt.$request->input('password'));
            $user->email=$request->input('email');
            $user->api_token= $this->str_random(60);
            if($user->save()){
                return "Gebruiker is geregistreerd!";
            } else {
                return "Gebruiker is niet geregistreerd!";
            }
        } else {
            return "Niet alle velden zijn ingevuld";
        }
    }
    public function info(){
        return Auth::user();
    }

    function str_random(int $int): string
    {
        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < $int; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }
}
