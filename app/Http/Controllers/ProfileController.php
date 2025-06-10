<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show()
    {
        return view('profile.show');
    }
    
    public function edit()
    {
        return view('profile.edit');
    }
    
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . auth()->id(),
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ]);
        
        auth()->user()->update($request->only(['name', 'email', 'phone', 'address']));
        
        return back()->with('success', 'Профиль обновлен успешно!');
    }
    
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);
        
        if (!Hash::check($request->current_password, auth()->user()->password)) {
            return back()->withErrors(['current_password' => 'Неверный текущий пароль']);
        }
        
        auth()->user()->update([
            'password' => Hash::make($request->password)
        ]);
        
        return back()->with('success', 'Пароль изменен успешно!');
    }
}
