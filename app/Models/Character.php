<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    use HasFactory;

    public function ark(){
        return $this->belongsTo(Ark::class);
    }

    public function grade(){
        return $this->belongsTo(Grade::class);
    }

    protected $guarded = ['id'];
    protected $casts=[
        'is_alive' => 'boolean',
        'have_domain_expansion' => 'boolean',
        'have_reverse_cursed_technique' => 'boolean',
        'used_black_flash' => 'boolean',
    ];
}
