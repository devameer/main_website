<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function work()
    {
        $projects = Project::published()->ordered()->get();

        return view('site.work', compact('projects'));
    }

    public function workShow(string $locale, string $slug)
    {
        $projects = Project::published()->ordered()->get();

        $project = $projects->firstWhere('slug', $slug);

        abort_if(! $project, 404);

        $index = $projects->search(fn ($p) => $p->is($project));
        $next = $projects[($index + 1) % $projects->count()];

        return view('site.work.show', compact('project', 'next'));
    }

    public function about()
    {
        return view('site.about');
    }

    public function services()
    {
        return view('site.services');
    }

    public function contact()
    {
        return view('site.contact');
    }
}
