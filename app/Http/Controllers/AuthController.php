<?php

namespace App\Http\Controllers;

use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// 23|3EqyxJQPBQdVFedW4wTMXvVUuIo8N5sEwSOzGw50 -> invoice
// 24|og2oFelknKk5QNdLhmyHQ26hsSF8umPY7oyGEttT -> user
// 25|rqAUeXZnGQFRxvcd01moy7Jf5t593EuobJpNAieV -> teste

class AuthController extends Controller
{

  use HttpResponses;

  public function login(Request $request)
  {
    if (Auth::attempt($request->only('email', 'password'))) {
      return $this->response('Authorized', 200, [
        'token' => $request->user()->createToken('invoice')->plainTextToken
      ]);
    }
    return $this->response('Not Authorized', 403);
  }


  public function logout(Request $request)
  {
    $request->user()->currentAccessToken()->delete();

    return $this->response('Token Revoked', 200);
  }
}
