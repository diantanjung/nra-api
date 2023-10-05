<?php

namespace App\Repository;

use App\Exceptions\UnauthorizedException;
use App\Models\OtpToken;
use App\Models\UserProfile;
use App\Transformers\TokenTransformer;
use App\Transformers\UserTransformer;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use App\Models\User;
use App\Transformers\UserProfileTransformer;
use Illuminate\Support\Facades\Hash;
use App\Jobs\WhatsappNotification;
use App\Models\Role;

class AuthRepository
{
    /**
     * Authenticate a user by emailand password
     *
     * @param  string  $email
     * @param  string  $password
     * @return array
     */
    public function authenticateByEmailAndPassword(string $email, string $password): array
    {
        if (!$token = app('auth')->attempt(compact('email', 'password'))) {
            throw new UnauthorizedException();
        }

        return fractal($token, new TokenTransformer())->toArray();
    }

    /**
     * Authenticate a user by username and password
     *
     * @param  string  $username
     * @param  string  $password
     * @return array
     */
    public function authenticateByUsernameAndPassword(string $username, string $password): array
    {
        if (!$token = app('auth')->attempt(compact('username', 'password'))) {
            throw new UnauthorizedException();
        }

        return fractal($token, new TokenTransformer())->toArray();
    }

    /**
     * Get the current authenticated user.
     *
     * @return array
     */
    public function getAuthenticatedUser(): array
    {
        $user = app('auth')->user();
        return fractal($user->profile, new UserProfileTransformer())->toArray();
    }

    /**
     * Refresh current authentication token.
     *
     * @return array
     */
    public function refreshAuthenticationToken(): array
    {
        $token = app('auth')->refresh();

        return fractal($token, new TokenTransformer())->toArray();
    }

    /**
     * Invalidate current authentication token.
     *
     * @return bool
     */
    public function invalidateAuthenticationToken(): bool
    {
        return (bool) app('auth')->logout();
    }


    private function generateOtp($user_id)
    {
        $otp_code = mt_rand(100000, 999999);
        $token = Str::random(60);
        $data = [
            'user_id'    => $user_id,
            'ip_address' => request()->ip(),
            'otp_code'   => $otp_code,
            'token'      => $token,
            'expired_at' => Carbon::now()->addMinutes(3)
        ];
        $otp_token = OtpToken::create($data);
        return $otp_token;
    }
    /**
     * Store a new area.
     *
     * @param  array  $attrs
     * @return \Illuminate\Http\JsonResponse
     *
     */
    public function forgotPassword(array $attrs): JsonResponse
    {
        $profile = UserProfile::where('phone_number', $attrs['phone_number'])->first();
        if ($profile) {
            $otp = $this->generateOtp($profile->user->id);

            dispatch(new WhatsappNotification([
                'phone' => $profile->phone_number,
                'message' => "Berikut kode OTP anda : $otp->otp_code"
            ]));

            return responseSuccess([
                'otp' => $otp->otp_code,
                'token' => $otp->token
            ]);
        }
        return responseError("Data tidak ada", 404);
    }

    public function verifyDevice(array $attrs): JsonResponse
    {
        $user = User::find($attrs['user_id']);
        if ($user) {
            // CHECK IF DEVICE ALREADY VERIFIED
            $is_validated = OtpToken::where('ip_address', request()->ip())
                ->where('user_id', $attrs['user_id'])
                ->where('is_validated', 1)
                ->first();

            if ($is_validated) {
                return response()->json(fractal($user, new UserTransformer())->toArray(), Response::HTTP_OK);
            }

            $otp = $this->generateOtp($attrs['user_id']);
            dispatch(new WhatsappNotification([
                'phone' => $user->profile->phone_number,
                'message' => "Berikut kode OTP anda : *$otp->otp_code*\n(Berlaku selama 5 menit)"
            ]));

            return responseSuccess([
                'otp' => $otp->otp_code,
                'token' => $otp->token
            ]);
        }

        return responseError("Data tidak ada", 404);
    }


    public function validateOtp(array $attrs): JsonResponse
    {
        $otp_token = OtpToken::where('token', $attrs['token'])
            ->where('otp_code', $attrs['otp_code'])
            ->whereDate('expired_at', '>=', Carbon::now()->toDateString())
            ->whereTime('expired_at', '>=', Carbon::now()->toTimeString())
            ->where('is_validated', 0)
            ->where('signed_at', null)
            ->first();
        if ($otp_token) {
            $otp_token->update([
                'signed_at' => Carbon::now()->toDateTimeString(),
                'is_validated' => 1,
            ]);

            $user = $otp_token->user;
            $user_profile = $otp_token->user->profile;
            $user_profile->update(['is_validated' => 1]);

            return response()->json(fractal($user, new UserTransformer())->toArray(), Response::HTTP_OK);
        }

        return responseError("OTP tidak ada atau tidak cocok!", 404);
    }

    public function resetPassword(array $attrs): array
    {
        $user = User::findOrFail($attrs['user_id']);
        $user->update(['password' => $attrs['password']]);
        return fractal($user, new UserTransformer())->toArray();
    }

    public function changePassword(array $attrs): array
    {
        $user = app('auth')->user();
        if (Hash::check($attrs['old_password'], $user->password)) {
            $user->update(['password' => $attrs['password']]);
            return fractal($user, new UserTransformer())->toArray();
        }
        return [];
    }

    public function resetOtp(): JsonResponse
    {
        $user = app('auth')->user();
        $user->profile->update(['is_validated' => 0]);
        $otp_tokens = OtpToken::where('user_id', $user->id)->get();
        foreach ($otp_tokens as $otp_token) {
            $otp_token->delete();
        }

        return responseSuccess(['is_validated' => false]);
    }

    public function roles(array $attrs): array
    {
        $roles = Role::select(['id', 'name'])->get();
        return $roles->toArray();
    }
}
