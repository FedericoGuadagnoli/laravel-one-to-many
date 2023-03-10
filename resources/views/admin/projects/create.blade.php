@extends('layouts.app')

@section('title', 'Crea nuovo progetto')
    
@section('content')
<header class="text-center my-5">
    <h1>Crea un nuovo progetto</h1>
</header>
    
<form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control bg-dark text-light" id="title" name="title" required>
                <small class="text-muted">Inserisci il nome del progetto</small>
            </div>
        </div>

        <div class="col-md-6">
            <div class="mb-3">
                <label for="image" class="form-label">Immagine</label>
                <input type="file" class="form-control bg-dark text-light" id="image" name="image">
            </div>
        </div>    
    </div>

    <div class="row">
        <div class="col-md-6">   
            <div class="mb-3">
                <label for="link_github" class="form-label">Link github</label>
                <input type="url" class="form-control bg-dark text-light" id="link_github" name="link_github">
                <small class="text-muted">Incolla l'url del link a github</small>
            </div>
        </div>
        <div class="col-md-6">
            <label for="type_id" class="form-label">Tipi di progetto</label>
            <select class="form-select bg-dark text-light" name="type_id" id="type_id">
                <option hidden value="">Scegli una tipologia ↓</option>
                @foreach ($types as $type)
                    <option @if ($project->type_id == $type->id) selected @endif value="{{ $type->id }}">{{ $type->label }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="mb-3">
                <label for="content" class="form-label">Contenuto</label>
                <textarea class="form-control bg-dark text-light" id="content" name="content" rows="15" required></textarea>
            </div>
        </div>
    </div>      
</div>

<footer class="my-4">
    <div class="text-center">
        <a href="{{ route('admin.projects.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me2"></i>
        Indietro</a>
        <button type="submit" class="btn btn-success">
            <i class="fas fa-floppy-disk me-2"></i>
            Salva
        </button>
    </div>
</footer>
</form>
@endsection