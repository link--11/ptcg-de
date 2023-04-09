@extends('layout')

@section('title', $page->title)

@section('content')

<h1>{{ $page->title }}</h1>

<div class="markdown">{!! Illuminate\Support\Str::markdown($page->content) !!}</div>

<div>Zuletzt geändert: {{ $page->updated_at }}</div>

@endsection
