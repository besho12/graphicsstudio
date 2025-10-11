<?php

namespace App\Http\Controllers\Frontend;

use App\Enums\ThemeList;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Rules\CustomRecaptcha;
use App\Traits\GlobalMailTrait;
use Modules\Faq\app\Models\Faq;
use Illuminate\Http\JsonResponse;
use Modules\Blog\app\Models\Blog;
use Modules\Award\app\Models\Award;
use Modules\Brand\app\Models\Brand;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Modules\OurTeam\app\Models\OurTeam;
use Modules\Project\app\Models\Project;
use Modules\Service\app\Models\Service;
use Modules\Frontend\app\Models\Section;
use Illuminate\Support\Facades\Validator;
use Modules\Testimonial\app\Models\Testimonial;
use Modules\PageBuilder\app\Models\CustomizeablePage;
use Modules\SiteAppearance\app\Models\SectionSetting;
use Modules\Subscription\app\Models\SubscriptionPlan;
use Modules\GlobalSetting\app\Models\CustomPagination;

class HomePageController extends Controller {
    use GlobalMailTrait;

    function index(): View {
        $sectionSetting = SectionSetting::first();

        $theme_name = Session::has('demo_theme') ? Session::get('demo_theme') : DEFAULT_HOMEPAGE;
        $sections = Section::whereHas("home", function ($q) use ($theme_name) {
            $q->where('slug', $theme_name);
        })->get();

        $hero = $sections->where('name', 'hero_section')->first();
        $aboutSection = $sections->where('name', 'about_section')->first();

        $faqs = Faq::select('id')->with(['translation' => function ($query) {
            $query->select('faq_id', 'question', 'answer');
        }])->active()->latest()->take(4)->get();

        $projects = Project::select('id', 'slug', 'image', 'thumbnail','project_date','service_id')->with([
            'translation' => function ($query) {
            $query->select('project_id', 'title', 'project_category');
        },
        'service' => function ($query) {
            $query->select('id','slug');
        },
        'service.translation' => function ($query) {
            $query->select('service_id','title');
        },
        ])->whereHas('service', function ($query) {
            $query->active();
        })->active()->latest()->get();

        $teams = OurTeam::select('name', 'slug', 'designation', 'image')->active()->latest()->take(4)->get();

        $testimonialSection = $sections->where('name', 'testimonial_section')->first();
        $testimonials = Testimonial::select('id')->with(['translation' => function ($query) {
            $query->select('testimonial_id', 'name', 'designation', 'comment');
        }])->active()->latest()->take(4)->get();

        $latest_blogs = Blog::select('id', 'blog_category_id', 'slug', 'image', 'created_at')->with([
            'translation'          => function ($query) {
                $query->select('blog_id', 'title');
            },
            'category'             => function ($query) {
                $query->select('id', 'slug');
            },
            'category.translation' => function ($query) {
                $query->select('blog_category_id', 'title');
            },
        ])->whereHas('category', function ($query) {
            $query->active();
        })->active()->homepage()->latest()->take(3)->get();

        $bannerSection = $sections->where('name', 'banner_section')->first();
        $brands = Brand::select('name', 'image', 'url')->active()->take(8)->get();

        $awards = Award::select('id', 'url')->with([
            'translation' => function ($query) {
                $query->select('award_id', 'year', 'title', 'sub_title', 'tag');
            },
        ])->active()->latest()->take(4)->get();

        $services = Service::select('id', 'slug', 'icon')->with(['translation' => function ($query) {
            $query->select('service_id', 'title', 'short_description', 'btn_text');
        }])->active()->latest()->take(4)->get();

        $servicefeatureSection = $sections->where('name', 'service_feature_section')->first();

        $serviceSection = $sections->where('name', 'service_section')->first();

        $chooseUsSection = $sections->where('name', 'choose_us_section')->first();

        $counterSection = $sections->where('name', 'counter_section')->first();

        $brandsSection = $sections->where('name', 'brands_section')->first();

        $projectSection = $sections->where('name', 'project_section')->first();

        $faqSection = $sections->where('name', 'faq_section')->first();

        $plans = SubscriptionPlan::select('id', 'plan_price','expiration_date','button_url')->with([
            'translation'          => function ($query) {
                $query->select( 'subscription_plan_id','plan_name','short_description','description','button_text');
            },
        ])->active()->orderBy('serial')->take(3)->get();

        //
        return view('frontend.home.' . $theme_name . '.index', compact(
            'sectionSetting',
            'hero',
            'aboutSection',
            'faqs',
            'projects',
            'teams',
            'testimonialSection',
            'testimonials',
            'latest_blogs',
            'bannerSection',
            'brands',
            'awards',
            'services',
            'servicefeatureSection',
            'serviceSection',
            'chooseUsSection',
            'counterSection',
            'brandsSection',
            'projectSection',
            'faqSection',
            'plans',
        ));
    }
    function changeTheme(string $theme) {
        if (cache()->get('setting')?->show_all_homepage != 1) {
            abort(404);
        }
        foreach (ThemeList::cases() as $enumTheme) {
            if ($theme == $enumTheme->value) {
                Session::put('demo_theme', $enumTheme->value);
                break;
            }
        }
        return redirect('/');
    }
    public function about(): View {
        $theme_name = DEFAULT_HOMEPAGE;

        $counterSection = Section::whereHas("home", function ($q) use ($theme_name) {
            $q->where('slug', $theme_name);
        })->where('name', 'counter_section')->first();

        $chooseUsSection = Section::whereHas("home", function ($q) use ($theme_name) {
            $q->where('slug', $theme_name);
        })->where('name', 'choose_us_section')->first();

        $awards = Award::select('id', 'url')->with([
            'translation' => function ($query) {
                $query->select('award_id', 'year', 'title', 'sub_title', 'tag');
            },
        ])->active()->latest()->take(4)->get();
        $teams = OurTeam::select('name', 'slug', 'designation', 'image')->active()->latest()->take(4)->get();
        $brands = Brand::select('name', 'image', 'url')->active()->take(8)->get();

        return view('frontend.pages.about', compact('counterSection','chooseUsSection','teams','brands','awards'));

    }
    public function faq(): View {
        $faqs = Faq::select('id')->with(['translation' => function ($query) {
            $query->select('faq_id', 'question', 'answer');
        }])->active()->latest()->get();

        return view('frontend.pages.faq', compact('faqs'));

    }
    public function pricing(): View {
        $per_age = cache('CustomPagination')?->pricing_plan ?? CustomPagination::where('section_name', 'Pricing Plan')->value('item_qty');

        $plans = SubscriptionPlan::select('id', 'plan_price','expiration_date','button_url')->with([
            'translation'          => function ($query) {
                $query->select( 'subscription_plan_id','plan_name','short_description','description','button_text');
            },
        ])->active()->orderBy('serial')->paginate($per_age);

        $faqs = Faq::select('id')->with(['translation' => function ($query) {
            $query->select('faq_id', 'question', 'answer');
        }])->active()->latest()->get();

        return view('frontend.pages.pricing', compact('plans','faqs'));

    }
    public function team(): View {
        $per_age = cache('CustomPagination')?->team_list ?? CustomPagination::where('section_name', 'Team List')->value('item_qty');
        $teams = OurTeam::select('name', 'slug', 'designation', 'image')->active()->latest()->paginate($per_age);

        $theme_name = DEFAULT_HOMEPAGE;

        $testimonialSection = Section::whereHas("home", function ($q) use ($theme_name) {
            $q->where('slug', $theme_name);
        })->where('name', 'testimonial_section')->first();

        $testimonials = Testimonial::select('id')->with(['translation' => function ($query) {
            $query->select('testimonial_id', 'name', 'designation', 'comment');
        }])->active()->latest()->get();

        return view('frontend.pages.team', compact('teams', 'testimonialSection', 'testimonials'));
    }
    public function singleTeam($slug): View {
        $team = OurTeam::select('name', 'slug', 'designation', 'image', 'sort_description', 'email', 'phone', 'facebook', 'twitter', 'dribbble', 'instagram')->whereSlug($slug)->active()->first();
        if ($team) {
            return view('frontend.pages.team-details', compact('team'));
        }
        abort(404);
    }
    public function portfolios(Request $request): View {
        $per_age = cache('CustomPagination')?->portfolio_list ?? CustomPagination::where('section_name', 'Portfolio List')->value('item_qty');
        
        $query = Project::select('id', 'slug', 'image', 'thumbnail')->with(['translation' => function ($query) {
            $query->select('project_id', 'title', 'project_category');
        }])->whereHas('service', function ($query) {
            $query->active();
        })->active()->latest();

        // Filter by category if provided
        if ($request->has('category') && $request->category !== 'all') {
            $query->whereHas('translation', function ($q) use ($request) {
                $q->where('project_category', $request->category);
            });
        }

        $projects = $query->paginate($per_age);
        
        // Get all unique categories for the filter
        $categories = Project::select('id')->with(['translation' => function ($query) {
            $query->select('project_id', 'project_category');
        }])->whereHas('service', function ($query) {
            $query->active();
        })->active()->get()
        ->pluck('translation.project_category')
        ->unique()
        ->filter()
        ->values();

        return view('frontend.pages.portfolio.index', compact('projects', 'categories'));
    }
    public function singlePortfolio($slug): View {
        $project = Project::select('id', 'slug', 'image','tags','project_author','created_at')->with([
            'translation' => function ($query) {
            $query->select('project_id', 'title','description', 'project_category', 'seo_title', 'seo_description');
        },
        'service' => function ($query) {
            $query->select('id');
        },
        'service.translation' => function ($query) {
            $query->select('service_id','title');
        },
        'images' => function ($query) {
            $query->select('project_id', 'small_image', 'large_image');
        },
        ])->whereHas('service', function ($query) {
            $query->active();
        })->active()->where('slug', $slug)->first();

        if (!$project) {
            abort(404);
        }

        $tagString = '';
        if ($project?->tags) {
            $tags = json_decode($project?->tags, true);
            $tagString = implode(', ', array_map(function ($tag) {
                return $tag['value'];
            }, $tags));
        }

        $nextPost = Project::select('id', 'slug')->whereHas('service', function ($query) {
            $query->active();
        })->active()->where('id', '>', $project->id)->first();

        $prevPost = Project::select('id', 'slug')->whereHas('service', function ($query) {
            $query->active();
        })->active()->where('id', '<', $project->id)->orderBy('id', 'desc')->first();

        return view('frontend.pages.portfolio.details', compact('project','tagString', 'nextPost', 'prevPost'));
    }
    public function services(): View {
        $per_age = cache('CustomPagination')?->service_list ?? CustomPagination::where('section_name', 'Service List')->value('item_qty');
        
        $services = Service::select('id', 'slug', 'icon')->with(['translation' => function ($query) {
            $query->select('service_id', 'title', 'short_description', 'btn_text');
        }])->active()->latest()->paginate($per_age);

        $theme_name = DEFAULT_HOMEPAGE;

        $bannerSection = Section::whereHas("home", function ($q) use ($theme_name) {
            $q->where('slug', $theme_name);
        })->where('name', 'banner_section')->first();
        
        return view('frontend.pages.service.index', compact('services','bannerSection'));
    }
    public function singleService($slug): View {

        $sectionSetting = SectionSetting::first();

        $service = Service::select('id', 'slug', 'image','created_at')->with([
            'translation' => function ($query) {
            $query->select('service_id', 'title','description','seo_title', 'seo_description', 'benefit_1_title', 'benefit_1_description', 'benefit_2_title', 'benefit_2_description', 'benefit_3_title', 'benefit_3_description', 'feature_1_title', 'feature_1_description', 'feature_1_highlight', 'feature_2_title', 'feature_2_description', 'feature_2_highlight', 'feature_3_title', 'feature_3_description', 'feature_3_highlight', 'process_1_title', 'process_1_description', 'process_2_title', 'process_2_description', 'process_3_title', 'process_3_description', 'process_4_title', 'process_4_description');
        }])
        ->with([
            'projects.translations',
        ])
        ->active()->where('slug', $slug)->first();

        if (!$service) {
            abort(404);
        }

        $faqs = Faq::select('id')->where('service_id', $service->id)->with(['translation' => function ($query) {
            $query->select('faq_id', 'question', 'answer');
        }])->active()->latest()->take(4)->get();


        return view('frontend.pages.service.details', compact('service','sectionSetting','faqs'));
    }
    public function contactTeamMember(Request $request, $slug):JsonResponse {
        try {
            $setting = cache()->get('setting');

            if ($setting?->contact_team_member !== 'active') {
                return response()->json(['success' => false, 'message' => __('Something went wrong, please try again')]);
            }

            $validator = Validator::make($request->all(), [
                'name'                 => 'required',
                'email'                => 'required',
                'message'              => 'required',
                'g-recaptcha-response' => $setting?->recaptcha_status == 'active' ? ['required', new CustomRecaptcha()] : '',
            ], [
                'name.required'                 => __('Name is required'),
                'email.required'                => __('Email is required'),
                'message.required'              => __('Message is required'),
                'g-recaptcha-response.required' => __('Please complete the recaptcha to submit the form'),
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => false, 'message' => $validator->errors()], 422);
            }

            $member = OurTeam::select('email')->active()->whereSlug($slug)->first();
            if (!$member) {
                return response()->json(['success' => false, 'message' => __('Not Found!')], 404);
            }
            $str_replace = [
                'name'    => $request->name,
                'email'   => $request->email,
                'message' => $request->message,
            ];
            [$subject, $message] = $this->fetchEmailTemplate('contact_team_mail', $str_replace);
            $this->sendMail($member?->email, $subject, $message);
            return response()->json(['success' => true,'message' => __('Message Sent Successfully')]);
        } catch (\Exception $e) {
            info($e->getMessage());
            return response()->json(['success' => false,'message' => __('Mail sending operation failed. Please try again.')]);
        }
    }
    public function privacyPolicy(): View {
        $customPage = CustomizeablePage::with('translation')->whereSlug('privacy-policy')->whereStatus(true)->first();
        if ($customPage) {
            return view('frontend.pages.custom-page', compact('customPage'));
        }
        abort(404);
    }

    public function termsCondition(): View {
        $customPage = CustomizeablePage::with('translation')->whereSlug('terms-conditions')->whereStatus(true)->first();
        if ($customPage) {
            return view('frontend.pages.custom-page', compact('customPage'));
        }
        abort(404);
    }
    public function customPage($slug): View {
        $customPage = CustomizeablePage::with('translation')->whereStatus(true)->whereSlug($slug)->first();
        if ($customPage) {
            return view('frontend.pages.custom-page', compact('customPage'));
        }
        abort(404);
    }
}
