<?php

namespace Src\Auth;

use Src\Request;
use Src\Session;

class Auth
{
    private static IdentityInterface $user;
    private static ?object $authenticatedUser = null;

    public static function init(IdentityInterface $user): void
    {
        self::$user = $user;
        $id = Session::get('id') ?? 0;
        if ($sessionUser = self::$user->findIdentity($id)) {
            self::$authenticatedUser = $sessionUser;
        }
    }

    public static function login(IdentityInterface $user): void
    {
        self::$authenticatedUser = $user;
        Session::set('id', $user->getId());
    }

    public static function attempt(array $credentials): bool
    {
        if ($user = self::$user->attemptIdentity($credentials)) {
            self::login($user);
            return true;
        }
        return false;
    }

    public static function user()
    {
        if (self::$authenticatedUser !== null) {
            return self::$authenticatedUser;
        }

        $id = Session::get('id') ?? 0;
        return self::$user->findIdentity($id);
    }

    public static function check(): bool
    {
        return (bool) self::user();
    }

    public static function logout(): bool
    {
        self::$authenticatedUser = null;
        Session::clear('id');
        return true;
    }

    public static function generateCSRF(): string
    {
        $token = md5(time());
        Session::set('csrf_token', $token);
        return $token;
    }

    public static function issueApiToken(array $credentials): ?string
    {
        if (!$user = self::$user->attemptIdentity($credentials)) {
            return null;
        }

        $token = bin2hex(random_bytes(32));
        $user->api_token = $token;
        $user->save();

        return $token;
    }

    public static function bearerTokenFromRequest(Request $request): ?string
    {
        $headers = $request->headers;
        $auth = $headers['Authorization']
            ?? $headers['authorization']
            ?? $_SERVER['HTTP_AUTHORIZATION']
            ?? '';

        if (preg_match('/Bearer\s+(\S+)/i', $auth, $matches)) {
            return $matches[1];
        }

        return null;
    }

    public static function authenticateByBearer(?string $token): bool
    {
        if (empty($token)) {
            return false;
        }

        if ($user = self::$user->findIdentityByToken($token)) {
            self::$authenticatedUser = $user;
            return true;
        }

        return false;
    }

}
