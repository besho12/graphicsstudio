@extends('admin.master_layout')
@section('title')
    <title>{{ __('About Section Features') }}</title>
@endsection
@section('admin-content')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <x-admin.breadcrumb title="{{ __('About Section Features') }}" :list="[
                __('Dashboard') => route('admin.dashboard'),
                __('About Section Features') => '#',
            ]" />

            <div class="section-body">
                <div class="mt-4 row">
                    <div class="col">
                        <div class="card">
                            <div class="card-header">
                                <x-admin.form-title :text="__('About Section Features')" />
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>{{ __('SN') }}</th>
                                                <th>{{ __('Title') }}</th>
                                                <th>{{ __('Description') }}</th>
                                                <th>{{ __('Action') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($features as $index => $feature)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $feature->title }}</td>
                                                    <td>{{ $feature->description }}</td>
                                                    <td>
                                                        <a href="{{ route('admin.about-features.edit', $feature->id) }}" 
                                                           class="btn btn-primary btn-sm">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="4" class="text-center">{{ __('No features found') }}</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection