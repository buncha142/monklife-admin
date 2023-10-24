<?php

namespace App\Livewire\User;

use App\Models\User;
use Livewire\Component;
use Masmerise\Toaster\Toaster;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserEditPassword extends Component
{

    public $photo;
    public $name;
    public $surname;
    public $email;
    public $avatar;
    public $password;
    public $password_confirmation;
    public $dataId;

    public function rules()
    {
            return [
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ];
    }
    public function render()
    {
        return view('livewire.user.user-edit-password');
    }
    public function mount()
    {
        $user = User::findOrFail(Auth::user()->id);
        $this->name = $user->name;
        $this->surname = $user->surname;
        $this->email = $user->email;
        $this->avatar = $user->avatar;
        $this->dataId = Auth::user()->id;
    }

    public function save()
    {
        $this->validate($this->rules());

        User::updateOrCreate([
            'id' => $this->dataId
        ],[
            'password' => Hash::make($this->password),
        ]);

        Toaster::warning('แก้ไขเรียบร้อย !');

    }
}
