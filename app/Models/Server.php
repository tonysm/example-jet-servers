<?php

namespace App\Models;

use App\Jobs\Servers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Server extends Model
{
    use HasFactory;

    protected $guarded = [];

    const SIZE_OPTIONS = [
        ['label' => '1CPU, 2GB RAM', 'value' => '1CPU, 2GB RAM'],
        ['label' => '2CPUs, 4GB RAM', 'value' => '2CPUs, 4GB RAM'],
    ];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function provision(): void
    {
        $this->update([
            'status' => 'provisioning',
        ]);

        Servers\Provision::withChain([
            new Servers\Configure($this),
        ])->dispatch($this);
    }
}
