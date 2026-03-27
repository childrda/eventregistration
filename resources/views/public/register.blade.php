@extends('layouts.public')
@section('content')
<section class="container-wide py-16">
    <div class="mx-auto max-w-3xl glass-panel p-8 md:p-10">
    <h1 class="section-title">Registration</h1>
    <p class="mt-2 text-slate-300">{{ $settings->registration_message }}</p>
    <form method="POST" action="{{ route('public.register.store') }}" class="mt-8 grid gap-4">
        @csrf
        <input name="district_name" value="{{ old('district_name') }}" placeholder="District Name" class="input-dark" required />
        <div class="grid gap-4 md:grid-cols-2">
            <input name="first_name" value="{{ old('first_name') }}" placeholder="First Name" class="input-dark" required />
            <input name="last_name" value="{{ old('last_name') }}" placeholder="Last Name" class="input-dark" required />
        </div>
        <input name="email" type="email" value="{{ old('email') }}" placeholder="Email Address" class="input-dark" required />
        <input name="title_role" value="{{ old('title_role') }}" placeholder="Title / Role" class="input-dark" required />
        <input name="total_rooms_reserved" type="number" min="0" value="{{ old('total_rooms_reserved') }}" placeholder="Total Rooms Reserved" class="input-dark" />
        <select name="tshirt_size_id" class="input-dark"><option value="">Select T-Shirt Size</option>@foreach($tshirtSizes as $size)<option value="{{ $size->id }}" @selected(old('tshirt_size_id')==$size->id)>{{ $size->name }}</option>@endforeach</select>
        <textarea name="food_allergies" placeholder="Do you have any food allergies?" class="input-dark">{{ old('food_allergies') }}</textarea>
        <select name="lunch_option_id" class="input-dark"><option value="">Please select a lunch</option>@foreach($lunchOptions as $option)<option value="{{ $option->id }}" @selected(old('lunch_option_id')==$option->id)>{{ $option->name }}</option>@endforeach</select>
        <button class="btn-primary">Submit Registration</button>
        @if($errors->any())<div class="rounded-lg border border-rose-500/40 bg-rose-500/20 p-3 text-sm text-rose-100">{{ $errors->first() }}</div>@endif
    </form>
    </div>
</section>
@endsection

