<?php

namespace RocketChat\Api;

/**
 * Listing users, creating, editing, logging in and out.
 *
 * @author Fogarasi Ferenc <ffogarasi at gmail dot com>
 * Website: http://github.com/ffogarasi/rocket-chat-api
 */
class User extends AbstractApi
{

    /**
     * Returns tokens for user
     *
     * @param bool  $username the username of the user
     * @param array $password the password of the user
     *
     * @return user's auth token and userId
     */
    public function login($username, $password)
    {
        $result = $this->post('login', ['user'=>$username, 'password'=>$password]);

        if ($this->status)
        {
            return $result->data;
        }

        return null;
    }
}
