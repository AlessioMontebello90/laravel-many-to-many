<?php


namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Project;
use App\Models\Type;
use App\Models\Tecnology;
use Illuminate\Http\Request;


use App\Http\Controllers\Controller;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;


use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Mail;
use App\Mail\ProjectPublished;


class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * *@return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::all();
        return view("admin.projects.index", compact("projects"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * *@return \Illuminate\Http\Response
     */
    public function create()
    {
        $tecnologies = Tecnology::all();
        $types = Type::all();
        return view('admin.projects.create', compact('types', 'tecnologies'));
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * *@return \Illuminate\Http\Response
     */
    public function store(StoreProjectRequest $request)
    {
        
        $data = $request->validated();


        $project = new Project();
        $project->fill($data);
        $project->slug = Str::slug($project->name);

       
        if ($request->hasFile('cover_image')) {
            $cover_image_path = Storage::put('uploads/projects/cover_image', $data['cover_image']);
            $project->cover_image = $cover_image_path;
        }

        $project->save();

        
        if (Arr::exists($data, 'tecnologies')) {
            $project->tecnologies()->attach($data['tecnologies']);
        }

        return redirect()->route('admin.projects.show', $project);
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * *@return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {

        return view("admin.projects.show", compact("project"));

        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * *@return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        $types = Type::all();
        $tecnologies = Tecnology::all();
        $project_tecnologies = $project->tecnologies->pluck('id')->toArray();
        return view("admin.projects.edit", compact("project", "types", 'tecnologies', 'project_tecnologies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $data = $request->validated();
       
        $project->slug = Str::slug($project->name);

        $project->fill($data);

        
        if ($request->hasFile('cover_image')) {
            if ($project->cover_image) {
                Storage::delete($project->cover_image);
            }
            $cover_image_path = Storage::put('uploads/projects/cover_image', $data['cover_image']);
            $project->cover_image = $cover_image_path;
        }

        if (Arr::exists($data, 'tecnologies')) {
            $project->tecnologies()->sync($data['tecnologies']);
        } else {
            $project->tecnologies()->detach();
        }

        $project->save();

        return redirect()->route("admin.projects.show", $project);
        
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $project->tecnologies()->detach();

        
        if ($project->cover_image) {
            Storage::delete($project->cover_image);
        }

        $project->delete();

        return redirect()->route('admin.projects.index');
        //
    }

    
    public function deleteImage(Project $project)
    {
        Storage::delete($project->cover_image);
        $project->cover_image = null;
        $project->save();

        return redirect()->back();
    }

    public function publish(Project $project, Request $request)
    {

        $data = $request->all();
        
        $project->published = Arr::exists($data, 'published') ? '1' : null;

        $project->save();

        
        $user = Auth::user();

        $published_project_mail = new ProjectPublished($project);
        Mail::to($user->email)->send($published_project_mail);


        return redirect()->back();
        
    }

}