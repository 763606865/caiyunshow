<?php

namespace App\Libs\Jwt;

use Illuminate\Auth\GuardHelpers;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Contracts\Auth\SupportsBasicAuth;
use Illuminate\Http\Request;

class JwtGuard implements StatefulGuard, SupportsBasicAuth
{
    use GuardHelpers;

    protected string $header = 'X-Wechat-Authorization';

    /**
     * The user we last attempted to retrieve.
     *
     * @var \Illuminate\Contracts\Auth\Authenticatable
     */
    protected Authenticatable $lastAttempted;

    /**
     * Indicates if the logout method has been called.
     *
     * @var bool
     */
    protected bool $loggedOut = false;

    /**
     * The request instance.
     *
     * @var Request
     */
    protected Request $request;

    public function __construct(\Illuminate\Contracts\Auth\UserProvider|null $provider, Request $request)
    {
        $this->provider = $provider;
        $this->request = $request;
    }

    public function guest()
    {
        // TODO: Implement guest() method.
    }

    public function user()
    {
        if ($this->loggedOut) {
            return;
        }

        if (! is_null($this->user)) {
            return $this->user;
        }

        $token = $this->request->header($this->header);

        if (! $token) {
            return;
        }

        $builder = new TokenBuilder();

        $id = $builder->parse($token);

        if (! is_null($id) && $this->user = $this->provider->retrieveById($id)) {
            // TODO: 登录后操作
        }

        return $this->user;
    }

    public function id()
    {
        // TODO: Implement id() method.
    }

    public function validate(array $credentials = [])
    {
        $this->lastAttempted = $user = $this->provider->retrieveByCredentials($credentials);
    }

    public function hasUser()
    {
        // TODO: Implement hasUser() method.
    }

    public function setUser(Authenticatable $user)
    {
        // TODO: Implement setUser() method.
    }

    public function attempt(array $credentials = [], $remember = false)
    {
        // TODO: Implement attempt() method.
    }

    public function once(array $credentials = [])
    {
        // TODO: Implement once() method.
    }

    public function loginUsingId($id, $remember = false)
    {
        // TODO: Implement loginUsingId() method.
    }

    public function onceUsingId($id)
    {
        // TODO: Implement onceUsingId() method.
    }

    public function viaRemember()
    {
        // TODO: Implement viaRemember() method.
    }

    public function logout()
    {
        // TODO: Implement logout() method.
    }

    public function basic($field = 'email', $extraConditions = [])
    {
        // TODO: Implement basic() method.
    }

    public function onceBasic($field = 'email', $extraConditions = [])
    {
        // TODO: Implement onceBasic() method.
    }

    public function login(Authenticatable $user, $remember = false)
    {
        $token = (new TokenBuilder())->generate($user->getAuthIdentifier());

        $this->setUser($user);

        return $token;
    }
}
