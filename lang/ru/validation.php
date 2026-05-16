<?php

return [
    'required' => 'Поле :attribute обязательно для заполнения.',
    'email' => 'Поле :attribute должно быть корректным email адресом.',
    'unique' => 'Такой :attribute уже существует.',
    'min' => [
        'numeric' => 'Значение поля :attribute должно быть не меньше :min.',
        'string' => 'Поле :attribute должно содержать не менее :min символов.',
    ],
    'max' => [
        'numeric' => 'Значение поля :attribute не может быть больше :max.',
        'string' => 'Поле :attribute не может содержать более :max символов.',
    ],
    'in' => 'Выбранное значение для :attribute некорректно.',
    'exists' => 'Выбранное :attribute не существует.',
    'after_or_equal' => 'Дата :attribute должна быть сегодня или позже.',
    'required_with' => 'Поле :attribute обязательно при заполнении :values.',
    'attributes' => [
        'name' => 'ФИО',
        'email' => 'Email',
        'password' => 'пароль',
        'phone' => 'телефон',
        'title' => 'название мастер-класса',
        'description' => 'описание',
        'date' => 'дата',
        'time_slot' => 'время',
        'capacity' => 'количество человек',
        'cost' => 'стоимость',
        'category_id' => 'вид творчества',
    ],
];
