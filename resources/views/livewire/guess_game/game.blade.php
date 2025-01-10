<?php

use App\Models\Character;
use App\Models\Grade;
use Livewire\Volt\Component;

new class extends Component {
    public $search='';
    public $answer;
    public $characters;
    public $guesses;
    public $selectedCharacter;

    public $options;

    public function mount() {
        $this->characters = Character::all();
        $this->guesses = [];
        $this->answer = $this->characters->random();
    }
    public function updatedSearch($value)
    {
        if(!$value) {
            $this->options = null;
            return;
        }
        $this->options = Character::where('name', 'like', "%$value%")
            ->limit(10)    
            ->get();
    }
    public function selectCharacter($id) {
        $character = Character::find($id);
        $this->guesses[] = $character;
        $this->search = '';
        $this->options = null;
    }
   
    
}; ?>

<div>

    <x-input label="Guess" placeholder="Itadori" wire:model.live="search" />

    @if($options)
        <div wire:key="options">
            @foreach($options as $option)
            <p wire:key="options-{{$option->id}}" wire:click="selectCharacter({{$option->id}})">{{$option->name}}</p>
            @endforeach
        </div>
    @endif

    @if($guesses)
    <table class="w-full divide-y divide-gray-200 m-2">
        <thead class="text-sm uppercase bg-gray-300 text-gray-800">
            <tr>
                <th>Name</th>
                <th>Gender</th>
                <th>Alive</th>
                <th>Arc Introduced At</th>
                <th>Grade</th>
                <th>Domain Expansion</th>
                <th>Reverse Curse Technique</th>
                <th>Black Flash</th>
            </tr>
           
        </thead>
        <tbody>
            @foreach ($guesses as $character)
                <tr class="text-center">
                    <td>{{$character->name}}</td>
                    <td class="capitalize">{{$character->gender}}</td>
                    <td>
                        @if($character->is_alive)
                        <x-badge rounded positive label="Alive" />
                        @else
                        <x-badge rounded negative label="Dead" />
                        @endif
                    </td>
                    <td>{{$character->arc->name}} </td>
                    <td>{{$character->grade->name}}</td>
                    <td>@if($character->have_domain_expansion) 
                            <x-badge rounded positive label="Have" />
                         @else 
                            <x-badge rounded negative label="Doesn't have" /> 
                         @endif
                    </td>
                    <td>
                        @if($character->have_reverse_cursed_technique) 
                            <x-badge rounded positive label="Have" /> 
                        @else 
                            <x-badge rounded negative label="Doesn't have" /> 
                        @endif
                    </td>
                    <td>
                        @if($character->used_black_flash) 
                            <x-badge rounded positive label="Used" /> 
                        @else 
                            <x-badge rounded negative label="Didn't used" /> 
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>
