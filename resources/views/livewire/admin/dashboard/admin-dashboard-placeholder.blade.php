@extends('layout.app')

@section('title', 'Loading Dashboard...')

@section('content')
    <div class="div p-6">
        <div class="animate-pulse">
            <div class="h-8 bg-gray-200 rounded w-1/4 mb-6"></div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="h-32 bg-gray-200 rounded-lg"></div>
                <div class="h-32 bg-gray-200 rounded-lg"></div>
                <div class="h-32 bg-gray-200 rounded-lg"></div>
                <div class="h-32 bg-gray-200 rounded-lg"></div>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <div class="h-80 bg-gray-200 rounded-lg"></div>
                <div class="h-80 bg-gray-200 rounded-lg"></div>
            </div>
        </div>
    </div>
@endsection
