<?php

namespace App\egal\auth;

use Exception;

final class Session
{

    private ?UserServiceToken $userServiceToken = null;

    public static function isAuthEnabled(): bool
    {
        return config('auth.enabled');
    }

    public static function getUserServiceToken(): UserServiceToken
    {
        self::isUserServiceTokenExistsOrFail();

        return self::getSingleton()->userServiceToken;
    }

    public static function isUserServiceTokenExistsOrFail(): bool
    {
        if (!self::isUserServiceTokenExists()) {
            throw new CurrentSessionException('The current Session does not contain UST!');
        }

        return true;
    }

    public static function getAuthStatus(): string
    {
        return self::isUserServiceTokenExists()
            ? StatusAccess::LOGGED
            : StatusAccess::GUEST;
    }

    public static function isUserServiceTokenExists(): bool
    {
        return self::getSingleton()->userServiceToken !== null;
    }

    public static function setUserServiceToken(UserServiceToken $userServiceToken): void
    {
        $userServiceToken->isAliveOrFail();
        self::getSingleton()->userServiceToken = $userServiceToken;
//        event(new UserServiceTokenDetectedEvent());
    }

    public static function unsetUserServiceToken(): void
    {
        self::getSingleton()->userServiceToken = null;
    }

    private static function getSingleton(): Session
    {
        return app(self::class);
    }

    private static function setToken(string $encodedToken): void
    {
        try {
            $decodedToken = Token::decode($encodedToken, config('app.service_key'));
        } catch (Exception $exception) {
            throw new UnableDecodeTokenException();
        }

        self::setUserServiceToken(UserServiceToken::fromArray($decodedToken));
    }

}
