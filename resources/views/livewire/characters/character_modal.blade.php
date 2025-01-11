<?php

use Livewire\Volt\Component;
use App\Models\Arc;
use App\Models\Grade;
use App\Models\Character;

new class extends Component {

    protected $listeners = ['openCharacterModal' => 'openModal'];

    public $modalOpen = false;

    public $arcs;
    public $grades;

    public $characterId = null;
    public $characterName;
    public $gender = "female";
    public $isAlive = false;
    public $haveDomainExpansion = false;
    public $haveReverseCursedTechnique = false;
    public $usedBlackFlash = false;
    public $arcId;
    public $gradeId;

    public function mount() {
        $this->arcs = Arc::orderBy('order')->get();
        $this->grades = Grade::all();
        $this->resetForm();
    }

    public function resetForm() {
        $this->characterId = null;
        $this->characterName = '';
        $this->gender = 'female';
        $this->isAlive = false;
        $this->haveDomainExpansion = false;
        $this->haveReverseCursedTechnique = false;
        $this->usedBlackFlash = false;
        $this->arcId = $this->arcs[0]->id;
        $this->gradeId = $this->grades[0]->id;
    }

    public function openModal($characterId = null) {
        if ($characterId) {
            $character = Character::findOrFail($characterId);
            $this->characterId = $character->id;
            $this->characterName = $character->name;
            $this->gender = $character->gender;
            $this->isAlive = $character->is_alive;
            $this->arcId = $character->arc_id;
            $this->gradeId = $character->grade_id;
            $this->haveDomainExpansion = $character->have_domain_expansion;
            $this->haveReverseCursedTechnique = $character->have_reverse_cursed_technique;
            $this->usedBlackFlash = $character->used_black_flash;
        } else {
            $this->resetForm();
        }

        $this->modalOpen = true;
    }

    public function saveCharacter() {
        $this->validate([
            'characterName' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'string', 'max:255'],
            'arcId' => ['required', 'exists:arcs,id'],
            'gradeId' => ['required', 'exists:grades,id'],
            'isAlive' => ['required', 'boolean'],
            'haveDomainExpansion' => ['required', 'boolean'],
            'haveReverseCursedTechnique' => ['required', 'boolean'],
            'usedBlackFlash' => ['required', 'boolean'],
        ]);

        if ($this->characterId) {
            // Update existing character
            $character = Character::findOrFail($this->characterId);
            $character->update([
                'name' => $this->characterName,
                'gender' => $this->gender,
                'is_alive' => $this->isAlive,
                'arc_id' => $this->arcId,
                'grade_id' => $this->gradeId,
                'have_domain_expansion' => $this->haveDomainExpansion,
                'have_reverse_cursed_technique' => $this->haveReverseCursedTechnique,
                'used_black_flash' => $this->usedBlackFlash,
            ]);
        } else {
            // Create new character
            Character::create([
                'name' => $this->characterName,
                'gender' => $this->gender,
                'is_alive' => $this->isAlive,
                'arc_id' => $this->arcId,
                'grade_id' => $this->gradeId,
                'have_domain_expansion' => $this->haveDomainExpansion,
                'have_reverse_cursed_technique' => $this->haveReverseCursedTechnique,
                'used_black_flash' => $this->usedBlackFlash,
            ]);
        }

        $this->dispatch('charactersChanged');
        $this->resetForm();
        $this->modalOpen = false;
    }
};
?>

<div>
    <x-modal.card title="{{ $characterId ? 'Update Character' : 'Create New Character' }}" blur wire:model="modalOpen">
        <form wire:submit.prevent="saveCharacter">
            <x-input label="Name" placeholder="Character name" wire:model="characterName" />

            <x-native-select
                label="Gender"
                :options="[ ['name' => 'Female',  'val' => 'female'], ['name' => 'Male', 'val' => 'male'] ]"
                option-label="name"
                option-value="val"
                wire:model="gender"
            />
            <x-native-select
                label="Arc Introduced At"
                :options="$arcs"
                option-label="name"
                option-value="id"
                wire:model="arcId"
            />
            <x-native-select
                label="Grade"
                :options="$grades"
                option-label="name"
                option-value="id"
                wire:model="gradeId"
            />

            <div class="pt-2">
                <x-checkbox md left-label="Alive" wire:model.defer="isAlive" />
            </div>
            <div class="pt-2">
                <x-checkbox md left-label="Have Domain Expansion" wire:model.defer="haveDomainExpansion" />
            </div>
            <div class="pt-2">
                <x-checkbox md left-label="Have Reverse Cursed Technique" wire:model.defer="haveReverseCursedTechnique" />
            </div>
            <div class="pt-2">
                <x-checkbox md left-label="Used Black Flash" wire:model.defer="usedBlackFlash" />
            </div>

            <div class="flex justify-end">
                <x-button flat label="Cancel" x-on:click="close" />
                <x-button primary label="Save" type="submit" />
            </div>
        </form>
    </x-modal.card>
</div>