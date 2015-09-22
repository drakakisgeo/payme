<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Lollypop\Services\Clef;

class ClefController extends Controller
{

    /**
     * @var Clef
     */
    private $clef;
    /**
     * @var User
     */
    private $user;

    public function __construct(Clef $clef){
        $this->clef = $clef;
    }

    public function handshake(Request $request){
        $this->clef->makeHandShake($request);

        // Get (or create) User in the DB
        $user = User::createOrGetClefuser($this->clef->getUserInfo());

        // Auth User
        Auth::loginUsingId($user->id);

        return redirect('/myaccount')->with('msg','Welcome to your dashbord '.$user->name);

    }

    public function logout(Request $request){

        $this->clef->logout($request->get('logout_token'));
    }

}
