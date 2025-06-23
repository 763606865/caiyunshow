<?php

namespace Database\Seeders;

use App\Models\Platform;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlatformSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => '小米',
                'code' => 'mi',
                'host' => 'mi.com',
                'login' => [
                    'sms' => [
                        'name' => '短信登录',
                        'url' => 'https://account.xiaomi.com/pass/phoneInfo',
                        'fields' => [
                            'user' => 'mobile',
                            'ticket' => 'ticket',
                        ],
                        'extra' => [
                            'sid' => 'mi_eshop',
                            'policyName' => 'miaccount',
                        ]
                    ],
                ]
            ],
            [
                'name' => '喵特',
                'code' => 'nyato',
                'host' => 'nyato.com',
                'login' => [
                    'password' => [
                        'name' => '密码登录',
                        'url' => 'https://www.nyato.com/index.php?app=public&mod=Passport&act=doLogin',
                        'fields' => [
                            'login_email' => 'username',
                            'login_password' => 'password',
                            'ticket' => 'ticket',
                        ],
                        'extra' => [
                            'refer_url' => 'https://www.nyato.com/help/service_detail/2',
                            'randstr' => '@Pnf',
                            'login_remember' => 1
                        ]
                    ],
                ]
            ],
        ];
        DB::transaction(function () use ($data) {
            foreach ($data as $item) {
                Platform::query()->updateOrCreate([
                    'code' => $item['code']
                ], $item);
            }
        });
    }
}
