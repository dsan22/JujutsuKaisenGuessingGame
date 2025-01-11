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
                    <td class="capitalize">
                        @if($character->gender==$answer->gender)
                            <x-badge rounded positive :label="$character->gender" />
                        @else
                            <x-badge rounded negative :label="$character->gender" />
                        @endif
                    </td>
                    <td>
                        @if($character->is_alive==$answer->is_alive)
                            @if ($character->is_alive)
                                <x-badge rounded positive label="Alive" />
                            @else
                                <x-badge rounded positive label="Dead" />
                            @endif
                        @else
                            @if ($character->is_alive)
                                <x-badge rounded negative label="Alive" />
                            @else
                                <x-badge rounded negative label="Dead" />
                            @endif
                        @endif
                    </td>
                    <td>
                        @if($character->arc->name==$answer->arc->name)
                            <x-badge rounded positive :label="$character->arc->name" />
                        @else
                            @if ($character->arc->order<$answer->arc->order)
                                <x-badge icon="arrow-up" rounded amber :label="$character->arc->name" />
                            @else
                                <x-badge icon="arrow-down" rounded amber :label="$character->arc->name" />
                            @endif
                           
                        @endif
                    </td>
                    <td>
                        @if($character->arc->name==$answer->arc->name)
                                <x-badge rounded positive :label="$character->grade->name" />
                            @else
                                <x-badge rounded negative :label="$character->grade->name" />
                            @endif
                        </td>
                    <td>
                        @if($character->have_domain_expansion==$answer->have_domain_expansion)
                            @if ($character->have_domain_expansion)
                                <x-badge rounded positive label="Have" />
                            @else
                                <x-badge rounded positive label="Doesen't have" />
                            @endif
                        @else
                            @if ($character->have_domain_expansion)
                                <x-badge rounded negative label="Have" />
                            @else
                                <x-badge rounded negative label="Doesen't have" />
                            @endif
                        @endif
                    </td>
                    <td>
                        @if($character->have_cursed_technique==$answer->have_cursed_technique)
                            @if ($character->have_cursed_technique)
                                <x-badge rounded positive label="Have" />
                            @else
                                <x-badge rounded positive label="Doesen't have" />
                            @endif
                        @else
                            @if ($character->have_cursed_technique)
                                <x-badge rounded negative label="Have" />
                            @else
                                <x-badge rounded negative label="Doesen't have" />
                            @endif
                        @endif
                    </td>
                    <td>
                    @if($character->used_black_flash==$answer->used_black_flash)
                            @if ($character->used_black_flash)
                                <x-badge rounded positive label="Used" />
                            @else
                                <x-badge rounded positive label="Didn't use" />
                            @endif
                        @else
                            @if ($character->used_black_flash)
                                <x-badge rounded negative label="Used" />
                            @else
                                <x-badge rounded negative label="Didn't use" />
                            @endif
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>
