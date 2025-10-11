<?php

namespace Modules\Frontend\app\Http\Controllers;

use App\Enums\RedirectType;
use App\Http\Controllers\Controller;
use App\Traits\RedirectHelperTrait;
use Modules\Frontend\app\Http\Requests\ServiceSectionRequest;
use Modules\Frontend\app\Models\Section;
use Modules\Frontend\app\Models\SectionTranslation;
use Modules\Frontend\app\Traits\UpdateSectionTraits;
use Modules\Language\app\Enums\TranslationModels;
use Modules\Language\app\Models\Language;
use Modules\Language\app\Traits\GenerateTranslationTrait;

class ServiceSectionController extends Controller {
    use GenerateTranslationTrait, RedirectHelperTrait, UpdateSectionTraits;

    /**
     * Display a listing of the resource.
     */
    public function index() {
        checkAdminHasPermissionAndThrowException('section.management');
        $code = request('code') ?? getSessionLanguage();
        if (!Language::where('code', $code)->exists()) {
            abort(404);
        }
        $languages = allLanguages();
        $serviceSection = Section::getByName('service_section');

        return view('frontend::service-section', compact('languages', 'code', 'serviceSection'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ServiceSectionRequest $request) {
        checkAdminHasPermissionAndThrowException('section.management');
        $section = Section::getByName('service_section');

        // Update translated content
        $content = $this->updateSectionContent($section?->content, $request, ['title', 'sub_title']);

        $translation = SectionTranslation::where('section_id', $section->id)->exists();

        if (!$translation) {
            $this->generateTranslations(TranslationModels::Section, $section, 'section_id', $request);
        }

        $this->updateTranslations($section, $request, $request->validated(), ['content' => $content]);

        return $this->redirectWithMessage(RedirectType::UPDATE->value, 'admin.service-section.index', ['code' => $request->code]);
    }
}