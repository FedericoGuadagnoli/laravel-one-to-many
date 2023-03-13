<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Validation\Rule;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Type;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::all();

        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $project = new Project();
        $types = Type::all();
        return view('admin.projects.create', compact('project', 'types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required | string | unique:projects| min:5 | max:50',
            'image' => 'nullable',
            'content' => 'required | string',
            'link_github' => 'required | url | unique:projects',
            'type_id' =>  'nullable|exists:types,id',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,svg'
        ], [
            'title.required' => 'Il titolo è obbligatorio',
            'title.unique' => "Esiste già un post con il titolo $request->title.",
            'title.min' => 'Il titolo deve avere almeno 5 caratteri',
            'title.max' => 'Il titolo non deve superare i 20 caratteri',
            'content.required' => 'La descrizione del progetto va inserita',
            'link_github.required' => 'Il link del progetto è obbligatorio',
            'link_github.url' => 'Devi inserire un link valido',
            'image.image' => 'L\'immagine deve essere un file di tipo immagine',
            'image.mimes' => 'L\'immagine può essere solo di tipo jpeg o jpg o png o svg'
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($data['title'], '-');
        $project = new Project();
        if (Arr::exists($data, 'image')) {
            $img_url = Storage::put('projects', $data['image']);
            $data['image'] = $img_url;
        }

        $project->fill($data);
        $project->save();
        return to_route('admin.projects.show', $project->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $project = Project::findOrFail($id);
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $types = Type::all();
        return view('admin.projects.edit', compact('project', 'types'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {

        $request->validate([
            'title' => ['required', 'string', Rule::unique('projects')->ignore($project->id), 'min:5', 'max:50'],
            'image' => 'nullable',
            'content' => 'required|string',
            'link_github' => ['required', 'url', Rule::unique('projects')->ignore($project->id)],
            'type_id' =>  'nullable|exists:types,id',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,svg'
        ], [
            'title.required' => 'Il titolo è obbligatorio',
            'title.unique' => "Esiste già un post con il titolo $request->title.",
            'title.min' => 'Il titolo deve avere almeno 5 caratteri',
            'title.max' => 'Il titolo non deve superare i 20 caratteri',
            'content.required' => 'La descrizione del progetto va inserita',
            'link_github.required' => 'Il link del progetto è obbligatorio',
            'link_github.url' => 'Devi inserire un link valido',
            'image.image' => 'L\'immagine deve essere un file di tipo immagine',
            'image.mimes' => 'L\'immagine può essere solo di tipo jpeg o jpg o png o svg'
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($data['title'], '-');
        if (Arr::exists($data, 'image')) {
            if ($project->image) Storage::delete($project->image);
            $img_url = Storage::put('projects', $data['image']);
            $data['image'] = $img_url;
        }
        $project->update($data);
        return to_route('admin.projects.show', $project->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $project->delete();
        return to_route('admin.projects.index');
    }
}
