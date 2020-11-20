<?php

namespace App\Models;

use App\Jobs\Servers\Configure;
use App\Jobs\Servers\Provision;
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

        Provision::withChain([
            new Configure($this),
        ])->dispatch($this);
    }
}
