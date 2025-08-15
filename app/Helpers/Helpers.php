<?php

use App\Models\Branch;
use App\Models\DistrictCoverage;
use App\Models\HomeAccordian;
use App\Models\Partner;
use App\Models\Project;
use App\Models\Social;
use Illuminate\Support\Str;

if (!function_exists('getCoveredDistricts')) {
    function getCoveredDistricts()
    {
        return DistrictCoverage::pluck('name')->map(fn($n) => strtolower($n))->toArray();
    }
}

// Get home accordion items
if (!function_exists('getHomeAccordionItems')) {
    function getHomeAccordionItems()
    {
        return HomeAccordian::orderBy('created_at', 'desc')->whereNot('id', 1)->get()->map(function ($item) {
            return [
                'id' => $item->id,
                'title' => $item->title,
                'content' => $item->content,
            ];
        })->values()->toArray();
    }
}

// Get home accordion first item
if (!function_exists('getHomeAccordionFirstItem')) {
    function getHomeAccordionFirstItem()
    {
        return HomeAccordian::orderBy('created_at', 'desc')->where('id', 1)->first();
    }
}

// Get all projects
if (!function_exists('getAllProjects')) {
    function getAllProjects()
    {
        return Project::with(['partners', 'topics'])->get()->map(function ($project) {
            return [
                'id' => $project->id,
                'title' => Str::limit($project->title, 40),
                // HTML tag ছাড়া limit করুন
                'details' => Str::limit(strip_tags($project->details), 100),
                'featured_image' => $project->featured_image,
                'study_area' => $project->study_area,
                'partners' => $project->partners->pluck('name')->toArray(),
                'topics' => $project->topics->pluck('name')->toArray(),
            ];
        })->values()->toArray();
    }
}

// Get branch first
if (!function_exists('getBranchFirst')) {
    function getBranchFirst()
    {
        return Branch::orderBy('created_at', 'desc')->where('id', 1)->first();
    }
}

// Get all Clients
if (!function_exists('getAllClients')) {
    function getAllClients()
    {
        return Partner::all()->map(function ($client) {
            return [
                'id' => $client->id,
                'name' => Str::limit($client->name, 40),
                'description' => Str::limit($client->description, 100),
                'logo' => $client->logo,
                'website' => $client->website,
            ];
        })->values()->toArray();
    }
}

// Get all social media
if (!function_exists('getAllSocial')) {
    function getAllSocial()
    {
        $social = Social::findOrFail(1);
        return [
            'id' => $social->id,
            'facebook' => $social->facebook,
            'twitter' => $social->twitter,
            'linkedin' => $social->linkedin,
            'youtube' => $social->youtube,
            'instagram' => $social->instagram,
        ];
    }
}
