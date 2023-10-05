<?php

namespace App\Http\Controllers\Web;

use App\Repository\AuthRepository;
use App\Http\Controllers\Controller;
use App\Transformers\UserTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    /**
     * Controller constructor.
     *
     * @param  \App\Repository\AuthRepository  $auth
     */
    public function __construct(AuthRepository $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Get a JWT via given credentials.
     *
     * @param  Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $token = $this->auth->authenticateByUsernameAndPassword(
            (string) $request->input('username'),
            (string) $request->input('password')
        );

        return response()->json($token, Response::HTTP_OK);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(): JsonResponse
    {
        $user = app('auth')->user();
        $user = fractal($user, new UserTransformer())->toArray();
        return response()->json($user, Response::HTTP_OK);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(): JsonResponse
    {
        $token = $this->auth->refreshAuthenticationToken();

        return response()->json($token, Response::HTTP_OK);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(): JsonResponse
    {
        $this->auth->invalidateAuthenticationToken();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * Log the user out (Invalidate the token).
     * @param  Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function forgot_password(Request $request): JsonResponse
    {
        return $this->auth->forgotPassword($request->all());
    }

    /**
     * Log the user out (Invalidate the token).
     * @param  Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verify_device(Request $request): JsonResponse
    {
        return $this->auth->verifyDevice($request->all());
    }

    /**
     * Log the user out (Invalidate the token).
     * @param  Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function validate_otp(Request $request): JsonResponse
    {
        return $this->auth->validateOtp($request->all());
    }

    public function reset_password(Request $request): JsonResponse {
        $user = $this->auth->resetPassword($request->all());

        return response()->json($user, Response::HTTP_OK);
    }

    public function change_password(Request $request): JsonResponse {
        $user = $this->auth->changePassword($request->all());

        return response()->json($user, Response::HTTP_OK);
    }

    public function reset_otp(): JsonResponse {
        return $this->auth->resetOtp();
    }

    public function roles(Request $request): JsonResponse {
        $roles = $this->auth->roles($request->all());
        return response()->json(["data" => $roles], Response::HTTP_OK);
    }
}
