<?php

namespace App\Console\Commands;

use App\Core\Contracts\AttachRolesInterface;
use App\Data\Role\StoreRoleActionData;
use App\Logics\Roles\RoleActionStoreLogic;
use Illuminate\Console\Command;

class AttachRolesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'authxolote:actions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Asocia los roles definidos en el archivo de configuración';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $roles = config('actions', []);

        if (empty($roles)) {
            $this->error('No se encontraron roles en el archivo de configuración.');

            return 1;
        }
        $result = $this->attach($roles);

        if (! $result) {
            $this->error('Ocurrió un error al asociar los roles.');

            return 1;
        }

        $this->info('Roles asociados correctamente.');

        return 0;

    }

    public function attach($roles): bool
    {
        $logic = new RoleActionStoreLogic;
        $data = new StoreRoleActionData($roles);

        $response = $logic->run($data);

        return $response->getStatusCode() === 201;
    }
}
