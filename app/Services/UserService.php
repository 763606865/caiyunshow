<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserService extends Service
{
    public function find(mixed $where)
    {
        $query = User::query();
        switch (gettype($where)) {
            case 'integer':
                $query->where('id', $where);
                break;
            case 'array':
                $query->where($where);
                break;
            default:
        }
        return $query->first();
    }

    public function store(array $data = [])
    {
        /** -- 排重 -- **/
        $user = new User();
        // 手机查重
        if($this->UserUniqueMobile($data)) {
            $user = User::query()->where('mobile', $data['mobile'])->first();
        }
        // 用户名查重
        if($this->UserUniqueUserName($data)) {
            $user = User::query()->where('username', $data['username'])->first();
        }
        // 邮箱查重
        if($this->EmailUniqueMobile($data)) {
            $user = User::query()->where('email', $data['email'])->first();
        }
        // 微信查重
        if($this->UserUniqueWechat($data)) {
            $user = User::query()->where('wechat_open_id', $data['wechat_open_id'])->first();
        }

        $user->forceFill($data);
        $user->save();
        return $user;
    }

    public function sync(User $user, array $data = [])
    {
        $first = $user;
        if ($this->UserUniqueWechat($data)) {
            $first = User::query()->where('wechat_open_id', $data['wechat_open_id'])->firstOrFail();
        }

        if ($this->UserUniqueUserName($data)) {
            $first = User::query()->where('username', $data['username'])->firstOrFail();
        }

        if ($this->EmailUniqueMobile($data)) {
            $first = User::query()->where('email', $data['email'])->firstOrFail();
        }

        if ($this->UserUniqueMobile($data)) {
            $first = User::query()->where('mobile', $data['mobile'])->firstOrFail();
        }
        $this->syncData($user, $first, $data);
    }

    protected function UserUniqueWechat(array $data = []): bool
    {
        if (isset($data['wechat_open_id']) && $data['wechat_open_id'])
        {
            return User::query()->where('wechat_open_id', $data['wechat_open_id'])->limit(1)->count() > 0;
        }

        return false;
    }

    protected function UserUniqueUserName(array $data = []): bool
    {
        if (isset($data['username']) && $data['username'])
        {
            return User::query()->where('username', $data['username'])->limit(1)->count() > 0;
        }

        return false;
    }

    protected function UserUniqueMobile(array $data = []): bool
    {
        if (isset($data['mobile']) && $data['mobile'])
        {
            return User::query()->where('mobile', $data['mobile'])->limit(1)->count() > 0;
        }

        return false;
    }

    protected function EmailUniqueMobile(array $data = []): bool
    {
        if (isset($data['email']) && $data['email'])
        {
            return User::query()->where('email', $data['email'])->limit(1)->count() > 0;
        }

        return false;
    }

    private function syncData($user, $first, $data)
    {
        if ($first->id === $user->id) {
            $user->forceFill($data);
            $user->save();
        } else {
            DB::transaction(static function () use($user, $first, $data) {
                $user->forceFill($data);
                $user->setVisible(['username', 'name', 'mobile', 'email', 'wechat_open_id', 'wechat_union_id', 'password', 'avatar']);
                $first->forceFill($user->toArray());
                $first->save();
                $user->delete();
            });
        }
    }

    public function generateUserName(string $platform = '', array $options = []): string
    {
        switch ($platform) {
            case 'wechat':
                $username = 'wx_'.($options['open_id'] ?? generation_random_string(8));
                break;
            case 'mobile':
                $username = 'm_'.(isset($options['mobile']) ? substr($options['mobile'], 3) : generation_random_string(8));
                break;
            case 'email':
                $username = 'e_'.(isset($options['email']) ? strrpos($options['email'], '@') : generation_random_string(8));
                break;
            default:
                $username = generation_random_string(8);
        }
        return $username;
    }
}
