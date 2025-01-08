<?php

use Livewire\Volt\Component;
use App\Models\Grade;

new class extends Component {

    protected $listeners = ['openGradeModal' => 'openModal'];

    public $modalOpen = false;


    public $gradeId = null;
    public $gradeName;

    public function mount() {
        $this->resetForm();
    }

    public function resetForm() {
        $this->gradeId = null;
        $this->gradeName = '';
    }

    public function openModal($gradeId = null) {
        if ($gradeId) {
            $grade=Grade::findOrFail($gradeId);
            $this->gradeId = $grade->id;
            $this->gradeName = $grade->name;
        } else {
            $this->resetForm();
        }

        $this->modalOpen = true;
    }

    public function saveGrade() {
        $this->validate([
            'gradeName' => ['required', 'string', 'max:255'],
        ]);

        if ($this->gradeId) {
            // Update existing grade
            $grade = Grade::findOrFail($this->gradeId);
            $grade->update([
                'name' => $this->gradeName,
            ]);
        } else {
            // Create new arc
            Grade::create([
                'name' => $this->gradeName,
            ]);
        }

        $this->dispatch('gradesChanged');
        $this->resetForm();
        $this->modalOpen = false;
    }
};
?>

<div>
    <x-modal.card title="{{ $gradeId ? 'Update Grade' : 'Create New Grade' }}" blur wire:model="modalOpen">
        <form wire:submit.prevent="saveGrade">
            <x-input label="Name" placeholder="Grade name" wire:model="gradeName" />
           
            <div class="flex justify-end">
                <x-button flat label="Cancel" x-on:click="close" />
                <x-button primary label="Save" type="submit" />
            </div>
        </form>
    </x-modal.card>
</div>