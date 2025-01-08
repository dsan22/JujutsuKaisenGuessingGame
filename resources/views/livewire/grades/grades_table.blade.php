<?php

use App\Models\Grade;
use Livewire\Volt\Component;

new class extends Component {
    protected $listeners = [
        'gradesChanged' => 'refreshGrades'
    ];

    public $grades;
    public function mount() {
        $this->refreshGrades();
    }
    public function refreshGrades() {
        $this->grades = Grade::all();
    }
    public function deleteGrade(Grade $grade) {
        $grade->delete();
        $this->refreshGrades();
    }
    
    public function createGrade() {
        $this->dispatch('openGradeModal');
    }
    public function editArc(Grade $grade) {
        $this->dispatch('openGradeModal', $grade->id);
    }
}; ?>

<div>
    <x-button primary label="Add Grade" wire:click="createGrade" />
    <table class="w-full divide-y divide-gray-200 m-2">
        <thead class="text-sm uppercase bg-gray-300 text-gray-800">
            <tr>
                <th>Grade Name</th>
                <th>Action</th>
            </tr>
           
        </thead>
        <tbody>
            @foreach ($grades as $grade)
                <tr class="text-center">
                    <td>{{$grade->name}}</td>
                    <td>
                        <div class="flex justify-center gap-4">
                            <x-button primary label="Edit" wire:click="editGrade({{$grade->id}})" />
                            <x-button negative label="Delete" wire:click="deleteGrade({{$grade->id}})" />
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <livewire:grades.grades_modal/>
</div>
