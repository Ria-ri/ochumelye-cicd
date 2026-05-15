<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'phone' => 'required|string|regex:/^8[\d\-]+$/',
], [
    'phone.regex' => 'Номер телефона должен начинаться с 8 и содержать только цифры и дефисы.',
    'phone.required'=> 'Поле телефон обязательно.',
    'email.unique'  => 'Пользователь с таким email уже зарегистрирован.',
    'email.email'   => 'Введите корректный email адрес.',
    'password.min'  => 'Пароль должен содержать не менее 6 символов.',
    'password.confirmed' => 'Пароли не совпадают.',
    'name.required' => 'ФИО обязательно для заполнения.',
]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        // Очищаем телефон от дефисов (оставляем только цифры)
        $cleanPhone = preg_replace('/\D/', '', $request->phone);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $cleanPhone,
            'role' => 'user',
        ]);

        auth()->login($user);

        return redirect('/')->with('success', 'Регистрация прошла успешно!');
    }
}