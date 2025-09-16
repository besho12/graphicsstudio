@extends('admin.master_layout')
@section('title')
    <title>{{ __('Pricing Plan') }}</title>
@endsection
@section('admin-content')
    <div class="main-content">
        <section class="section">
            <x-admin.breadcrumb title="{{ __('Pricing Plan') }}" :list="[
                __('Dashboard') => route('admin.dashboard'),
                __('Pricing Plan') => '#',
            ]" />

            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <x-admin.form-title :text="__('Pricing Plan')" />
                                <div>
                                    <x-admin.add-button :href="route('admin.pricing-plan.create')" />
                                </div>
                            </div>
                            <div class="card-body text-center">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <tr>
                                            <th>{{ __('Serial') }}</th>
                                            <th>{{ __('Name') }}</th>
                                            <th>{{ __('Price') }}</th>
                                            <th>{{ __('Expiration') }}</th>
                                            <th>{{ __('Status') }}</th>
                                            @adminCan('pricing.management')
                                                <th>{{ __('Action') }}</th>
                                            @endadminCan
                                        </tr>

                                        @forelse ($plans as $index => $plan)
                                            <tr>
                                                <td>{{ $plan?->serial }}</td>
                                                <td>{{ $plan?->plan_name }}</td>
                                                <td>{{ currency($plan?->plan_price) }}</td>
                                                <td>{{ $plan?->expiration_date }}</td>

                                                <td>
                                                    @if ($plan?->status == Modules\Subscription\app\Enums\SubscriptionStatusType::ACTIVE->value)
                                                        <div class="badge bg-success">{{ __('Active') }}</div>
                                                    @else
                                                        <div class="badge bg-danger">{{ __('Inactive') }}</div>
                                                    @endif
                                                </td>
                                                @adminCan('pricing.management')
                                                    <td>
                                                        <x-admin.edit-button :href="route('admin.pricing-plan.edit', [
                                                            'pricing_plan' => $plan?->id,
                                                            'code' => getSessionLanguage(),
                                                        ])" />
                                                        <a href="{{ route('admin.pricing-plan.destroy', $plan->id) }}"
                                                            data-modal="#deleteModal"
                                                            class="delete-btn btn btn-danger btn-sm"><i class="fa fa-trash"
                                                                aria-hidden="true"></i></a>
                                                    </td>
                                                @endadminCan
                                            </tr>
                                        @empty
                                            <x-empty-table :name="__('Pricing')" route="admin.pricing-plan.create"
                                                create="yes" :message="__('No data found!')" colspan="6" />
                                        @endforelse
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    @adminCan('pricing.management')
        <x-admin.delete-modal />
    @endadminCan
@endsection
