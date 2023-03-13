@extends('layouts.app')

@section('title', 'Crea nuovo progetto')
    
@section('content')
<header class="text-center my-5">
    <h1>Crea un nuovo progetto</h1>
</header>
    
@include('includes.projects.form')
@endsection