@extends('layouts.app')

@section('content')
<div class="flex justify-center">
    <div class="w-8/12">
        <!-- Main header -->
        <div class="p-6 text-gray-700 ">
            <h1 class="text-4xl font-semibold mb-1">Admin Panel</h1>
            <p>Manage users, organisation details and define divisions here</p>
        </div>
        <!-- Success Messages -->
        @if (session('success'))
            <div class="bg-green-500 p-4 rounded-lg mb-3 text-white text-center">
                {{ session('success') }}
            </div>
        @endif

    </div>
</div>
@endsection
