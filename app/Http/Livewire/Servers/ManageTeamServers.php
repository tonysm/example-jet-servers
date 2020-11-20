<?php

namespace App\Http\Livewire\Servers;

use App\Models\Server;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Component;

class ManageTeamServers extends Component
{
    public $state = [
        'name' => '',
        'server_size' => '',
    ];

    public ?Server $serverToDelete = null;
    public $confirmingDeleteServer = false;

    public function mount()
    {
        $this->generateName();
    }

    protected function rules(): array
    {
        return [
            'state.name' => 'required|string|min:1|max:100',
            'state.server_size' => [
                'required',
                Rule::in(array_column(Server::SIZE_OPTIONS, 'value')),
            ],
        ];
    }

    public function generateName()
    {
        // Fake haiku generator.
        $this->state['name'] = 'randomly-generated-'. Str::random(6);
    }

    protected $validationAttributes = [
        'state.name' => 'Server Name',
        'state.server_size' => 'Server Size',
    ];

    public function confirmDeleteServer(Server $server)
    {
        $this->serverToDelete = $server;
        $this->confirmingDeleteServer = true;
    }

    public function deleteServer()
    {
        if ($this->serverToDelete) {
            $this->serverToDelete->delete();
            $this->serverToDelete = null;
        }

        $this->confirmingDeleteServer = false;
    }

    public function createServer()
    {
        $this->validate();

        tap($this->team->servers()->create($this->state))->provision();

        $this->reset();
    }

    public function getTeamProperty()
    {
        return auth()->user()->currentTeam;
    }

    public function render()
    {
        return view('livewire.servers.manage-team-servers', [
            'options' => Server::SIZE_OPTIONS,
            'servers' => $this->team->servers,
        ]);
    }
}
