@extends('layouts.admin')
@section('content')
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>
<body>
<x-guest-layout>
<h1><center><b>REGISTER</b></center></h1>
            @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
            @endif
            @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
    <form method="POST" action="{{ route('t_registration') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>
        <div class="mt-4">
            <x-input-label for="u_num" :value="__('University Number')" />
            <x-text-input id="u_num" class="block mt-1 w-full" type="text" name="u_num" :value="old('u_num')" required autofocus autocomplete="u_num" />
            <x-input-error :messages="$errors->get('u_num')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>

</br>
<hr>
</br>
<h5><center><b>Registered TA's</b></center></h5>
</br>
@if($datata->isEmpty())
                <p>Registration for TA has not been done</p>
            @else
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <th style="width: 40%;">University Number</th>
                        <th style="width: 40%;">Username</th>
                        
                    </tr>
                    @foreach($datata as $tadata)  
                        <tr>
                            <td>{{ $tadata->u_num}}</td>
                            <td>{{ $tadata->email }}</td>                 
                            <td><a href="{{ url('ta_registration/'.$tadata->id) }}" onclick="return confirm('Are you sure you want to delete this credentials?');"><button>Delete</button></a></td>
                        </tr>
                    @endforeach
                </table>
            @endif
    </x-guest-layout>
</body>
@endsection