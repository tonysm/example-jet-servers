<?php

namespace App\Http\Livewire\Servers;

use App\Models\Server;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Create extends Component
{
    public $state = [
        'name' => '',
        'server_size' => '',
    ];

    public function updatingStateName($name)
    {
        $this->state['name'] = strtolower(str_replace(' ', '-', trim($name)));
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

    protected $validationAttributes = [
        'state.name' => 'Server Name',
        'state.server_size' => 'Server Size',
    ];

    public function createServer()
    {
        $this->validate();

        auth()->user()->currentTeam->servers()->create($this->state);

        $this->reset();
    }

    public function render()
    {
        return view('livewire.servers.create', [
            'options' => Server::SIZE_OPTIONS,
        ]);
    }
}
