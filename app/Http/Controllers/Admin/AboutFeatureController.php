<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutFeature;
use Illuminate\Http\Request;
use Modules\Language\app\Traits\GenerateTranslationTrait;
use Modules\Language\app\Enums\TranslationModels;
use Modules\Language\app\Models\Language;
use App\Traits\RedirectHelperTrait;

class AboutFeatureController extends Controller
{
    use GenerateTranslationTrait, RedirectHelperTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        checkAdminHasPermissionAndThrowException('section.management');
        $features = AboutFeature::with('translation')->ordered()->get();
        $code = request('code') ?? getSessionLanguage();
        if (!Language::where('code', $code)->exists()) {
            abort(404);
        }
        $languages = allLanguages();
        return view('admin.about-features.index', compact('features', 'languages', 'code'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        checkAdminHasPermissionAndThrowException('section.management');
        $code = request('code') ?? getSessionLanguage();
        if (!Language::where('code', $code)->exists()) {
            abort(404);
        }
        $languages = allLanguages();
        return view('admin.about-features.create', compact('languages', 'code'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        checkAdminHasPermissionAndThrowException('section.management');
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'boolean'
        ]);

        $aboutFeature = AboutFeature::create([
            'order' => $request->order,
            'status' => $request->status ?? true
        ]);

        $this->updateTranslations(
            $aboutFeature,
            $request,
            $request->only(['title', 'description'])
        );

        return redirect()->route('admin.about-features.index', ['code' => $request->code])
            ->with('success', __('About feature created successfully.'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AboutFeature $aboutFeature)
    {
        $code = request('code') ?? getSessionLanguage();
        $languages = allLanguages();
        
        return view('admin.about-features.edit', compact('aboutFeature', 'code', 'languages'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AboutFeature $aboutFeature)
    {
        checkAdminHasPermissionAndThrowException('section.management');
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'order' => 'required|integer|min:0',
            'status' => 'boolean'
        ]);

        $aboutFeature->update([
            'status' => $request->status ?? true
        ]);

        $this->updateTranslations(
            $aboutFeature,
            $request,
            $request->only(['title', 'description'])
        );

        return redirect()->route('admin.about-features.index', ['code' => $request->code])
            ->with('success', __('About feature updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AboutFeature $aboutFeature)
    {
        checkAdminHasPermissionAndThrowException('section.management');
        $aboutFeature->translations()->delete();
        $aboutFeature->delete();

        return redirect()->route('admin.about-features.index')
            ->with('success', __('About feature deleted successfully.'));
    }
}
