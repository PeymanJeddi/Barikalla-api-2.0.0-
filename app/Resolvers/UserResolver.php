<?php
namespace App\Resolvers;

class UserResolver implements \OwenIt\Auditing\Contracts\UserResolver
{
    /**
     * {@inheritdoc}
     */
    public static function resolve()
    {
        return auth()->check() ? auth()->user() : null;
    }
}