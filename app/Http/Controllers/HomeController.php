<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\Course;
use App\Models\ExperienceCertificate;
use App\Models\Trainee;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Mail\Message;
use App\Models\Branch;
use App\Models\ImpactStory;
use App\Models\License;
use App\Models\OurStory;
use App\Models\Post;
use App\Models\Privacy;
use App\Models\Project;
use App\Models\Service;
use App\Models\Term;
use App\Models\WhyGdri;

class HomeController extends Controller
{
    // Home Page
    public function index()
    {
        return view('welcome');
    }

    // Privacy Policy Page
    public function privacyPolicy()
    {
        $title = 'Privacy Policy';
        $mainContent = Privacy::first(); // Assuming you have a PrivacyPolicy model
        return view('home.pages.privacy-policy', compact(['title', 'mainContent']));
    }

    // Terms and Condition Page
    public function termCondition()
    {
        $title = 'Terms and Conditions';
        $mainContent = Term::first(); // Assuming you have a Term model
        return view('home.pages.terms-condition', compact(['title', 'mainContent']));
    }

    // License Page
    public function license()
    {
        $title = 'License';
        $mainContent = License::first(); // Assuming you have a License model
        return view('home.pages.license', compact(['title', 'mainContent']));
    }

    // Why GDRI Page
    public function whyGdri()
    {
        $title = 'Why GDRI';
        $mainContent = WhyGdri::first(); // Assuming you have a WhyGdri model
        return view('home.pages.why-gdri', compact(['title', 'mainContent']));
    }

    // Impact Story Page
    public function impactStory()
    {
        $title = 'Impact Story';
        $impactStories = ImpactStory::all(); // Assuming you have an ImpactStory model
        return view('home.pages.impact-story', compact(['title', 'impactStories']));
    }

    // Ongoing Projects Page
    public function ongoingProjects()
    {
        $title = 'Ongoing Projects';
        $ongoingProjects = Project::where('status', 'ongoing')->with(['partners', 'topics'])->get()->map(function ($project) {
            return [
                'id' => $project->id,
                'title' => $project->title,
                'details' => strip_tags($project->details),
                'featured_image' => $project->featured_image,
                'study_area' => $project->study_area,
                'status' => $project->status,
                'partners' => $project->partners->pluck('name')->toArray(),
                'topics' => $project->topics->pluck('name')->toArray(),
            ];
        })->values()->toArray();
        return view('home.pages.ongoing-projects', compact(['title', 'ongoingProjects']));
    }

    // Completed Projects Page
    public function completedProjects()
    {
        $title = 'Completed Projects';
        $completedProjects = Project::where('status', 'completed')->with(['partners', 'topics'])->get()->map(function ($project) {
            return [
                'id' => $project->id,
                'title' => $project->title,
                'details' => strip_tags($project->details),
                'featured_image' => $project->featured_image,
                'study_area' => $project->study_area,
                'status' => $project->status,
                'partners' => $project->partners->pluck('name')->toArray(),
                'topics' => $project->topics->pluck('name')->toArray(),
            ];
        })->values()->toArray();
        return view('home.pages.completed-projects', compact(['title', 'completedProjects']));
    }

    // Project Details Page
    public function projectDetails($id)
    {
        $title = 'Project Details';
        $project = Project::with(['partners', 'topics'])->findOrFail($id);
        return view('home.pages.project-details', compact(['title', 'project']));
    }

    // Publication Report Page
    public function publicationReport()
    {
        $title = 'Publication Report';
        return view('home.pages.publication-report', compact('title'));
    }

    // Services Page
    public function services()
    {
        $title = 'Services';
        $services = Service::all(); // Assuming you have a Service model for services
        return view('home.pages.services', compact(['title', 'services']));
    }

    // Service Details Page
    public function serviceDetails($id)
    {
        $title = 'Service Details';
        $service = Service::findOrFail($id); // Assuming you have a Service model for services
        return view('home.pages.service-details', compact(['title', 'service']));
    }

    // Blog and News Page
    public function blogNews()
    {
        $title = 'Blog and News';
        // How to get authors for each post
        $posts = Post::with(['authors', 'category'])->where('status', 'published')
            ->get()
            ->map(function ($post) {
                $post->author_names = $post->authors->pluck('name')->implode(', ');
                return $post;
            });

        return view('home.pages.blog-news', compact(['title', 'posts']));
    }

    // Post Details Page
    public function postDetails($slug)
    {
        $title = 'Post Details';
        $post = Post::with(['authors','category'])->where('slug', $slug)->firstOrFail();
        $post->author_names = $post->authors->pluck('name')->implode(', ');
        return view('home.pages.post-details', compact(['title', 'post']));
    }

    // Gallery Page
    public function gallery()
    {
        $title = 'Photo Gallery';
        return view('home.pages.gallery', compact('title'));
    }

    // Our Story Page
    public function ourStory()
    {
        $title = 'Our Story';
        $ourStory = OurStory::first(); // Assuming you have an OurStory model
        return view('home.pages.our-story', compact(['title', 'ourStory']));
    }

    // Branches Page
    public function branches()
    {
        $title = 'Branches';
        $branches = Branch::all(); // Assuming you have a Branch model
        return view('home.pages.branches', compact('title', 'branches'));
    }

    // Get Experience Certificate
    public function getExperienceCertificate(Request $request)
    {
        $title = 'Experience Certificate';
        $certificate = ExperienceCertificate::where('certificate_number', $request->input('certificate_number'))->first();
        return view('home.pages.experience-certificate', compact( 'title'));
    }
    // Show Experience Certificate
    public function showExperienceCertificate(Request $request)
    {
        $request->validate([
            'certificate_number' => 'required|string',
        ]);

        $certificate = ExperienceCertificate::where('certificate_number', $request->input('certificate_number'))->first();
        
        return response()->json([
            'certificate' => $certificate,
            'title' => 'Experience Certificate',
        ]);
    }

    // Success Story Page
    // public function emailConfiguration(Request $request, $id)
    // {
    //     $trainee = Trainee::findOrFail($id);
    //     return view('emails.application_confirmation', compact('trainee'));
    // }

    // Success Story Page
    // public function sendMessage(Request $request)
    // {
    //     $data = [
    //         'name'    => $request->name,
    //         'email'   => $request->email,
    //         'phone'   => $request->phone,
    //         'subject' => $request->subject,
    //         'message' => $request->message,
    //     ];
    //     try {
    //         Mail::to($request->email)->send(new Message($data));

    //         return view('emails.message', compact('data'));
    //     } catch (\Throwable $th) {
    //         return redirect()->back()->with('error', $th->getMessage());
    //     }
    // }
}
