<?php

namespace App\Repositories;

use App\Project;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;

class ProjectsRepository
{

    public function list()
    {
        return request()->user()->projects()->get();
    }

    public function create(Request $request)
    {
        $request->user()->projects()->create([
            'name' => $request->name,
            'thumbnail' => $this->thumb($request)
        ]);
    }

    public function find($id)
    {
        return Project::findOrFail($id);
    }

    public function todos($project)
    {
        return $project->tasks()->where('completion', 0)->get();
    }

    public function done($project)
    {
        return $project->tasks()->where('completion', 1)->get();
    }


    public function update(Request $request, $id)
    {
        $project = $this->find($id);
        $project->name = $request->name;
        if ($request->hasFile('thumbnail')) {
            $project->thumbnail = $this->thumb($request);
        }
        $project->save();
    }

    public function delete($id)
    {
        $project = $this->find($id);
        $project->delete();
    }

    public function thumb(Request $request)
    {
        if ($request->hasFile(('thumbnail'))) {
            $thumb = $request->thumbnail;
            $name = $thumb->hashName();
            $thumb->storeAs('public/thumbs/original', $name);

            $path = storage_path('app/public/thumbs/cropped/') . $name;
            Image::make($thumb)->resize(200, 90)->save($path);
            return $name;
        }
        return null;
    }
}
