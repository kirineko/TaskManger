<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;
use App\Repositories\ProjectsRepository;
use App\Http\Requests\CreateProjectRequest;
use App\Http\Requests\UpdateProjectRequest;

class ProjectsController extends Controller
{

    protected $repo;

    public function __construct(ProjectsRepository $repo) {
        $this->middleware('auth');
        $this->repo = $repo;
    }

    // show
    public function index()
    {
        $projects = $this->repo->list();
        return view('welcome', compact('projects'));
    }

    // create
    public function create()
    {
        // show create form view
    }


    public function store(CreateProjectRequest $request)
    {
        $this->repo->create($request);
        return back();
    }

    // show
    public function show($id)
    {
        $project = $this->repo->find($id);
        return view('projects.show');
    }

    // update
    public function edit()
    {
        // show edit form view
    }

    public function update(UpdateProjectRequest $request ,$id)
    {
        $this->repo->update($request, $id);
        return back();
    }

    // delete
    public function destroy($id)
    {
        $this->repo->delete($id);
        return back();
    }
}
