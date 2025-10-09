<?php

namespace Modules\Frontend\app\Http\Controllers;

use App\Enums\RedirectType;
use App\Http\Controllers\Controller;
use App\Traits\RedirectHelperTrait;
use Modules\Frontend\app\Http\Requests\BrandsSectionRequest;
use Modules\Frontend\app\Models\Section;
use Modules\Frontend\app\Models\SectionTranslation;
use Modules\Frontend\app\Traits\UpdateSectionTraits;
use Modules\Language\app\Enums\TranslationModels;
use Modules\Language\app\Models\Language;
use Modules\Language\app\Traits\GenerateTranslationTrait;

class BrandsSectionController extends Controller
{
    use GenerateTranslationTrait, RedirectHelperTrait, UpdateSectionTraits;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        checkAdminHasPermissionAndThrowException('section.management');
        $code = request('code') ?? getSessionLanguage();
        if (!Language::where('code', $code)->exists()) {
            abort(404);
        }
        $languages = allLanguages();
        $brandsSection = Section::getByName('brands_section');

        return view('frontend::brands-section', compact('languages', 'code', 'brandsSection'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BrandsSectionRequest $request)
    {
        checkAdminHasPermissionAndThrowException('section.management');
        $code = $request->code;
        $brandsSection = Section::getByName('brands_section');

        $this->updateSectionTranslation($brandsSection, $request, $code);

        return $this->redirectWithMessage(RedirectType::UPDATE->value, 'admin.brands-section.index', ['code' => $code]);
    }
}