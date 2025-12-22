<?php

namespace App\Console\Commands;

use App\Models\Domain;
use App\Models\Tenant;
use Illuminate\Console\Command;

class TenancyCreate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenancy:create {database} {domains}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tenant = Tenant::create([
            'id' => $this->argument('database'),
            'database' => $this->argument('database'),
            'database_user' => 'root',
            'database_password' => '123456',
        ]);

        Domain::create([
            'domain' => $this->argument('domains'),
            'tenant_id' => $tenant->id,
        ]);
    }
}
