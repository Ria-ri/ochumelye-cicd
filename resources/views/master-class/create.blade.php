@extends('layouts.app')
@if($errors->any())
    <div style="background:#f8d7da; color:#721c24; padding:10px; margin-bottom:20px;">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@section('content')
<div class="row row--nogutter top-line"><div class="line"></div></div>
<div class="main">
    <div class="row">
        <div class="row--small">
            <form method="POST" action="{{ route('master-class.store') }}">
                @csrf
                <h2>Добавление мастер-класса</h2>
                <div class="form-group">
                    <label>Вид творчества</label>
                    <select name="category_id" required>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id') 
                    <div style="color:red; font-size:12px;">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Название мастер-класса</label>
                    <input type="text" name="title" value="{{ old('title') }}" required>
                    @error('title') 
                    <div style="color:red; font-size:12px;">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Описание</label>
                    <textarea name="description" required>{{ old('description') }}</textarea>
                    @error('description')
                    <div style="color:red; font-size:12px;">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Дата</label>
                    <input type="date" name="date" value="{{ old('date') }}" required>
                    @error('date')
                    <div style="color:red; font-size:12px;">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Время (слот)</label>
                    <select name="time_slot" id="time_slot" required>
                        <option value="9-11" {{ old('time_slot') == '9-11' ? 'selected' : '' }}>9:00-11:00</option>
                        <option value="11-13" {{ old('time_slot') == '11-13' ? 'selected' : '' }}>11:00-13:00</option>
                        <option value="13-15" {{ old('time_slot') == '13-15' ? 'selected' : '' }}>13:00-15:00</option>
                        <option value="15-17" {{ old('time_slot') == '15-17' ? 'selected' : '' }}>15:00-17:00</option>
                    </select>
                    @error('time_slot')
                    <div style="color:red; font-size:12px;">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Количество человек</label>
                    <input type="number" name="capacity" value="{{ old('capacity') }}" required>
                    @error('capacity')
                        <div style="color:red; font-size:12px;">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Стоимость (руб.)</label>
                    <input type="number" step="100" name="cost" value="{{ old('cost') }}" required>
                    @error('cost')
                        <div style="color:red; font-size:12px;">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <button class="btn" type="submit">Отправить</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- перед скриптом добавим невидимый контейнер с данными -->
<div id="slots-data" data-occupied='@json($occupiedSlots)' style="display:none;"></div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const slotsData = document.getElementById('slots-data');
        const occupied = JSON.parse(slotsData.dataset.occupied);
        const dateInput = document.querySelector('input[name="date"]');
        const slotSelect = document.querySelector('select[name="time_slot"]');

        function updateSlotAvailability() {
            const date = dateInput.value;
            if (!date) return;
            for (let option of slotSelect.options) {
                const slotValue = option.value;
                if (occupied.includes(date + '|' + slotValue)) {
                    option.disabled = true;
                    if (option.selected) option.selected = false;
                } else {
                    option.disabled = false;
                }
            }
        }
        dateInput.addEventListener('change', updateSlotAvailability);
        updateSlotAvailability();
    });
</script>
@endsection