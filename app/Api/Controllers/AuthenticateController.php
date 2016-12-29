<?php
/**
 * @User:   Little (2284876299.com)
 * @Date:   2016/12/30
 * @Time:   0:09
 * @Version: 1.0
 * Desc:
 */

namespace App\Api\Controllers;

use Illuminate\Http\Request;

use Tymon\JWTAuth\Exceptions\JWTException;
use JWTAuth;

class AuthenticateController
{
    public function authenticate(Request $request)
    {
        // grab credentials from the request
        $credentials = $request->only('phone', 'password');

        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        // all good so return the token
        return response()->json(compact('token'));
    }
}