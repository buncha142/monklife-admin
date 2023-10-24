<?php

namespace App\Livewire\User;

use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;
use Masmerise\Toaster\Toaster;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class UserEdit extends Component
{
    use WithFileUploads;

    public $photo;
    public $status;
    public $name;
    public $surname;
    public $nickname;
    public $dob;
    public $doo;
    public $email;
    public $phone;
    public $line_id;
    public $avatar;
    public $current_password;

    public $dataId;


    public function rules()
    {
        return [
            'status' => 'required',
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'nickname' => 'required|string|max:255',
            'dob' => 'nullable|date',
            'doo' => 'nullable|date',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|numeric|digits:10',
            'line_id' => 'nullable|max:255',

        ];
    }

    protected $messages = [
        'status.required' => 'กรุณาเลือกข้อมูล',
        'name.required' => 'กรุณาป้อนข้อมูล',
        'name.string' => 'กรุณาป้อนข้อมูลเป็นตัวอักษรเท่านั้น',
        'name.max:255' => 'กรุณาป้อนข้อมูลเป็นตัวอักษรมากเกินไป',
        'surname.required' => 'กรุณาป้อนข้อมูล',
        'surname.string' => 'กรุณาป้อนข้อมูลเป็นตัวอักษรเท่านั้น',
        'surname.max:255' => 'กรุณาป้อนข้อมูลเป็นตัวอักษรมากเกินไป',
        'nickname.required' => 'กรุณาป้อนข้อมูล',
        'nickname.string' => 'กรุณาป้อนข้อมูลเป็นตัวอักษรเท่านั้น',
        'nickname.max:255' => 'กรุณาป้อนข้อมูลเป็นตัวอักษรมากเกินไป',
        'email.required' => 'กรุณาป้อน Email',
        'email.email' => 'กรุณาป้อนข้อมูลอยู่ในรูปแบบ Email',
        'email.max:255' => 'คุณป้อนข้อมูลมากเกินไป',
        'phone.numeric' => 'กรุณาป้อนเฉพาะตัวเลข',
        'phone.digits:10' => 'คุณป้อนเกิน 10 ตัว กรุณาป้อนใหม่',
        'line_id.max:255' => 'คุณป้อนข้อมูลมากเกินไป',
    ];

    public function render()
    {
        return view('livewire.user.user-edit');
    }

    public function mount()
    {
        $user = User::findOrFail(Auth::user()->id);
        $this->status = $user->status;
        $this->name = $user->name;
        $this->surname = $user->surname;
        $this->nickname = $user->nickname;
        $this->dob = $user->dob ? Carbon::parse($user->dob)->format('Y-m-d') : '';
        $this->doo = $user->doo ? Carbon::parse($user->doo)->format('Y-m-d') : '';
        $this->email = $user->email;
        $this->phone = $user->phone;
        $this->line_id = $user->line_id;
        $this->avatar = $user->avatar;
        $this->dataId = Auth::user()->id;
    }

    public function save()
    {
        $this->validate($this->rules(), $this->messages);

        if ($this->photo) {
            $this->avatar = $this->photo->store('image/profile');
            Storage::put('public/image/profile', $this->photo);
        }

        User::updateOrCreate([
            'id' => $this->dataId
        ], [
            'status' => $this->status,
            'name' => $this->name,
            'surname' => $this->surname,
            'nickname' => $this->nickname,
            'dob' => $this->dob ? $this->dob : null,
            'doo' => $this->doo ? $this->doo : null,
            'email' => $this->email,
            'phone' => $this->phone ? $this->phone : null,
            'line_id' => $this->line_id ? $this->line_id : null,
            'avatar' => $this->avatar,
        ]);

        Toaster::warning('แก้ไขเรียบร้อย !');

    }
}
