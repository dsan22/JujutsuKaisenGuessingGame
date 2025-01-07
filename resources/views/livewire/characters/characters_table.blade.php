<?php

use Livewire\Volt\Component;
use App\Models\Character;

new class extends Component {
    protected $listeners = [
        'charactersChanged' => 'refreshCharacters'
    ];

    public $characters;
    public function mount() {
        $this->characters = Character::all();
    }
    public function refreshCharacters() {
        $this->characters = Character::all();
    }
    public function deleteCharacter(Character $character) {
        $character->delete();
        $this->refreshCharacters();
    }
    
    public function createCharacter() {
        $this->dispatch('openCharacterModal');
    }
    public function editCharacter(Character $character) {
        $this->dispatch('openCharacterModal', $character->id);
    }
}; ?>

<div>
    <x-button primary label="Add Character" wire:click="createCharacter" />
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
                <th>Action</th>
            </tr>
           
        </thead>
        <tbody>
            @foreach ($characters as $character)
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
                    <td>
                        <div class="flex justify-between gap-4">
                            <x-button primary label="Edit" wire:click="editCharacter({{$character->id}})" />
                            <x-button negative label="Delete" wire:click="deleteCharacter({{$character->id}})" />
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <livewire:characters.character_modal/>
</div>
