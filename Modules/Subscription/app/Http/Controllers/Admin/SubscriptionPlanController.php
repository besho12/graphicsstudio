<?php

namespace Modules\Subscription\app\Http\Controllers\Admin;

use App\Enums\RedirectType;
use App\Traits\RedirectHelperTrait;
use App\Http\Controllers\Controller;
use Modules\Language\app\Models\Language;
use Modules\Language\app\Enums\TranslationModels;
use Modules\Subscription\app\Models\SubscriptionPlan;
use Modules\Language\app\Traits\GenerateTranslationTrait;
use Modules\Subscription\app\Http\Requests\SubscriptionPlanRequest;

class SubscriptionPlanController extends Controller {
    use GenerateTranslationTrait, RedirectHelperTrait;
    public function index() {
        checkAdminHasPermissionAndThrowException('pricing.view');
        $plans = SubscriptionPlan::orderBy('serial', 'asc')->get();
        return view('subscription::admin.subscription_list', compact('plans'));
    }

    public function create() {
        checkAdminHasPermissionAndThrowException('pricing.view');
        return view('subscription::admin.subscription_create');
    }

    public function store(SubscriptionPlanRequest $request) {
        checkAdminHasPermissionAndThrowException('pricing.management');
        $plan = SubscriptionPlan::create($request->validated());

        $this->generateTranslations(
            TranslationModels::SubscriptionPlan,
            $plan,
            'subscription_plan_id',
            $request,
        );
        return $this->redirectWithMessage(
            RedirectType::CREATE->value,
            'admin.pricing-plan.edit',
            [
                'pricing_plan' => $plan->id,
                'code' => allLanguages()->first()->code,
            ]
        );
    }

    public function edit($id) {
        checkAdminHasPermissionAndThrowException('pricing.view');
        $code = request('code') ?? getSessionLanguage();
        if (!Language::where('code', $code)->exists()) {
            abort(404);
        }
        $languages = allLanguages();
        $plan = SubscriptionPlan::find($id);

        return view('subscription::admin.subscription_edit', compact('code', 'languages','plan'));
    }

    public function update(SubscriptionPlanRequest $request, SubscriptionPlan $pricing_plan) {
        checkAdminHasPermissionAndThrowException('pricing.management');
        $validatedData = $request->validated();

        $pricing_plan->update($validatedData);

        $this->updateTranslations(
            $pricing_plan,
            $request,
            $validatedData,
        );

        return $this->redirectWithMessage(RedirectType::UPDATE->value, 'admin.pricing-plan.edit', ['pricing_plan' => $pricing_plan->id,'code' => $request->code]);
    }

    public function destroy(SubscriptionPlan $pricing_plan) {
        checkAdminHasPermissionAndThrowException('pricing.management');

        $pricing_plan->translations()->each(function ($translation) {
            $translation->subscription_plan()->dissociate();
            $translation->delete();
        });

        $pricing_plan->delete();

        return $this->redirectWithMessage(RedirectType::DELETE->value, 'admin.pricing-plan.index');

    }
}
