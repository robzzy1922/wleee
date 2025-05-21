<?php

namespace App\Services\Auth;

use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class AuthServiceProxy implements IAuthService
{
    private $realAuthService;
    private $maxAttempts = 5;
    private $decayMinutes = 1;

    public function __construct(RealAuthService $realAuthService)
    {
        $this->realAuthService = $realAuthService;
    }

    public function login(array $credentials): bool
    {
        if (!$this->checkLoginThrottle($credentials['email'])) {
            throw new \Exception('Too many login attempts. Please try again later.');
        }

        $result = $this->realAuthService->login($credentials);

        if ($result) {
            $this->clearLoginAttempts($credentials['email']);
        } else {
            $this->incrementLoginAttempts($credentials['email']);
        }

        return $result;
    }

    public function logout(Request $request): void
    {
        $this->realAuthService->logout($request);
    }

    public function getCurrentUser()
    {
        return $this->realAuthService->getCurrentUser();
    }

    private function checkLoginThrottle(string $email): bool
    {
        $attempts = Cache::get($this->getLoginAttemptsCacheKey($email), 0);
        return $attempts < $this->maxAttempts;
    }

    private function incrementLoginAttempts(string $email): void
    {
        $key = $this->getLoginAttemptsCacheKey($email);
        $attempts = Cache::get($key, 0);
        Cache::put($key, $attempts + 1, now()->addMinutes($this->decayMinutes));
    }

    private function clearLoginAttempts(string $email): void
    {
        Cache::forget($this->getLoginAttemptsCacheKey($email));
    }

    private function getLoginAttemptsCacheKey(string $email): string
    {
        return 'login_attempts_' . md5($email);
    }
}
