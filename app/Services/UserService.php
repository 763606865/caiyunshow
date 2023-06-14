<?php

namespace App\Services;

use App\Models\User;

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
        $user->UserUniqueMobile($data['mobile']);
        // 用户名查重
        $user = $this->UserNameUniqueMobile();
        // 邮箱查重
        $user = $this->EmailUniqueMobile();
        // 微信查重
        $user = $this->UserUniqueWechat($data);

        if (!$user) {
            User::query()->create($data);
        } else {
            $user->forceFill($data);
            $user->save();
        }
    }

    protected function UserUniqueWechat(array $data = [])
    {
        if (isset($data['wechat_open_id']) && $data['wechat_open_id'])
        {
            return user::query()->where('wechat_open_id', $data['wechat_open_id'])->first();
        }

        if (isset($data['wechat_union_id']) && $data['wechat_union_id'])
        {
            return user::query()->where('wechat_union_id', $data['wechat_union_id'])->first();
        }

        return null;
    }

    protected function UserUniqueMobile(array $data = [])
    {
        if (isset($data['mobile']) && $data['mobile'])
        {
            return user::query()->where('mobile', $data['mobile'])->first();
        }

        return null;
    }

    protected function EmailUniqueMobile()
    {

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
