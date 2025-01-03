<?php

use Livewire\Volt\Component;
use App\Models\Character;

new class extends Component {
    protected $listeners = [
        'charctersChanged' => 'refreshCharacters'
    ];

    public $characters;
    public function mount() {
        $this->characters = Character::all();
    }
    public function refreshCharacters() {
        $this->characters = Character::all();
    }
}; ?>

<div>
    <table class="w-full divide-y divide-gray-200 m-2">
        <thead class="uppercase bg-gray-300 text-gray-800">
            <tr>
                <th>Name</th>
                <th>Gender</th>
                <th>Alive</th>
                <th>Ark Introduced At</th>
                <th>Grade</th>
                <th>Have Domain Expansion</th>
                <th>Have Reverse Curse Technique</th>
                <th>Used Black Flash</th>
            </tr>
           
        </thead>
        <tbody>
            @foreach ($characters as $character)
                <tr>
                    <td>{{$character->name}}</td>
                    <td>{{$character->gender}}</td>
                    <td>{{$character->is_alive}}</td>
                    <td>{{$character->ark->name}} </td>
                    <td>{{$character->grade->name}}</td>
                    <td>{{$character->have_domain_expansion }}</td>
                    <td>{{$character->have_reverse_cursed_technique }}</td>
                    <td>{{$character->used_black_flash }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
