<?php

namespace App\Jobs\Servers;

use App\Models\Server;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class Provision implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    use Batchable;

    public Server $server;

    public function __construct(Server $server)
    {
        $this->server = $server;
    }

    public function handle()
    {
        sleep(5);

        $this->server->update([
            'status' => 'configuring',
        ]);
    }
}
