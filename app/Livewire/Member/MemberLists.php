<?php

namespace App\Livewire\Member;

use App\Models\User;
use Livewire\Component;

class MemberLists extends Component
{
    public function render()
    {
        return view('livewire.member.member-lists',
        [
            'monks' => User::whereStatus('พระ')->whereActive('1')->orderBy('doo', 'ASC')->paginate(),
            'upss' => User::whereStatus('อุบาสก')->whereActive('1')->orderBy('dob', 'DESC')->paginate(),
            'upks' => User::whereStatus('อุบาสิกา')->whereActive('1')->orderBy('dob', 'DESC')->paginate(),
        ]);
    }
}
