<?php

namespace App\Core\Traits;

use App\Core\Abstract\Model;
use App\Core\Session;

trait Authenticatable
{
    public static function attempt(string $email, string $password, $remember = false)
    {
        $user = static::find(['email' => $email]);

        if (!$user) {
            return false;
        }

        if (password_verify($password, $user->password)) {
            self::login($user, $remember);

            return $user;
        }

        return false;
    }

    public static function login(Model $user, bool $remember)
    {
        // Generate a new session ID
        $sessionId = bin2hex(random_bytes(32));

        // Store the session ID in the session cookie
        if ($remember) {
            $expires = time() + (60 * 60 * 24 * 30); // 30 days
            setcookie('session_id', $sessionId, $expires, '/', '', true, httponly: true);
        } else {
            setcookie('session_id', $sessionId, 0, '/', '', true, httponly: true);
        }

        // Store the session ID in the database and associate it with the user ID
        // DB::table('sessions')->insert([
        //     'session_id' => $sessionId,
        //     'user_id' => $user->id,
        //     'expires_at' => $expires, // optional expiration time
        // ]);

        Session::set('user_id', $user->id);
    }
}
