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
   
    
}; ?>

<div>

    <x-input label="Guess" placeholder="Itadori" wire:model.live="search" />

    @if($options)
        <div wire:key="options">
            @foreach($options as $option)
            <p>{{$option->name}}</p>
            @endforeach
        </div>
    @endif
</div>
