<?php

namespace App\Services\Auth;

use Illuminate\Http\Request;

interface IAuthService
{
    public function login(array $credentials): bool;
    public function logout(Request $request): void;
    public function getCurrentUser();
}