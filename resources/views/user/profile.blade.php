@extends('layouts.app')

@section('content')
    <h2>Edit your information here</h2>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form>
        <p><strong>Gender:</strong> {{ $profile->gender }}</p>
        <p><strong>Age:</strong> {{ $profile->age }}</p>
        <p><strong>Weight:</strong> {{ $profile->weight }} lb</p>
        <p><strong>Height:</strong> {{ $profile->height_ft }} ft</p>
        <p><strong>Activity Level:</strong> {{ $profile->activity_level }}</p>

        <a href="{{ route('personal') }}">
            <button type="button">Edit Profile</button>
        </a>
    </form>
@endsection
