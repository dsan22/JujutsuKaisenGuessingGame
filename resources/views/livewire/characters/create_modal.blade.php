<?php

use Livewire\Volt\Component;
use App\Models\Ark;
use App\Models\Grade;
use App\Models\Character;

new class extends Component {
    public $modalOpen = false;

    public $arks;
    public $grades;

    public $arkId;
    public $gradeId;

    public $characterName;
    public $gender="female";
    public $isAlive=false;
    public $haveDomainExpansion=false;
    public $haveReverseCursedTechnique=false;
    public $usedBlackFlash=false;

    public function mount(){
        $this->arks = Ark::all();
        $this->grades = Grade::all();
        $this->arkId=$this->arks[0]->id;
        $this->gradeId=$this->grades[0]->id;
    }

    public function createNewCharacter(){
        $this->validate([
            'characterName' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'string', 'max:255'],
            'arkId' => ['required', 'exists:arks,id'],
            'gradeId' => ['required', 'exists:grades,id'],
            'isAlive' => ['required', 'boolean'],
            'haveDomainExpansion' => ['required', 'boolean'],
            'haveReverseCursedTechnique' => ['required', 'boolean'],
            'usedBlackFlash' => ['required', 'boolean'],
        ]);

        Character::create([
            'name' => $this->characterName,
            'gender' => $this->gender,
            'is_alive' => $this->isAlive,
            'ark_id' => $this->arkId,
            'grade_id' => $this->gradeId,
            'have_domain_expansion' => $this->haveDomainExpansion,
            'have_reverse_cursed_technique' => $this->haveReverseCursedTechnique,
            'used_black_flash' => $this->usedBlackFlash,
        ]);

        $this->dispatch('charctersChanged');
        $this->reset('characterName');
        $this->reset('gender');
        $this->reset('isAlive');
        $this->arkId=$this->arks[0]->id;
        $this->gradeId=$this->grades[0]->id;
        $this->reset('haveDomainExpansion');
        $this->reset('haveReverseCursedTechnique');
        $this->reset('usedBlackFlash');
        $this->modalOpen = false;

       
    }
    public function openModal(){
        $this->modalOpen=true;
    }
}; ?>

<div>
    <div>
        <x-button emerald icon="plus" wire:click="openModal">Create New Character</x-button>
    </div>
    <x-modal.card title="Create New Character" blur wire:model="modalOpen">
        <form wire:submit="createNewCharacter">
            <x-input label="Name" placeholder="Character name" wire:model="characterName"  />

            <x-native-select
                label="Gender"
                :options="[
                    ['name' => 'Female',  'val' => 'female'],
                    ['name' => 'Male', 'val' => 'male'],
                ]"
                option-label="name"
                option-value="val"
                wire:model="gender"
            />
            <x-native-select
                label="Ark Introduced At"
                :options="$arks"
                option-label="name"
                option-value="id"
                wire:model="arkId"
            />

            <x-native-select
                label="Grade"
                :options="$grades"
                option-label="name"
                option-value="id"
                wire:model="gradeId"
            />


            <div class="pt-2">
                <x-checkbox  md left-label="Alive"  wire:model.defer="isAlive" />
            </div>

            <div class="pt-2">
                <x-checkbox  md left-label="Have Domain Expansion" wire:model.defer="haveDomainExpansion" />
            </div>
            <div class="pt-2">
                <x-checkbox  md left-label="Have Reverse Cursed Technique" wire:model.defer="haveReverseCursedTechnique" />
            </div>
            <div class="pt-2">
                <x-checkbox  md left-label="Used Black Flash" wire:model.defer="usedBlackFlash" />
            </div>

            <div class="flex justify-end">
                <div class="flex mt-3">
                    <x-button flat label="Cancel" x-on:click="close" />
                    <x-button primary label="Save" type="submit"/>
                </div>
            </div>
        </form>
    </x-modal.card>
</div>