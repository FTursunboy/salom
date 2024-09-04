<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Services\Common\Helpers\Logger\Logger;

class BaseSeeder extends Seeder
{
    protected Logger $logger;

    public function __construct()
    {
        $this->logger = new Logger("database/seeding", 'seeding');
    }
}
