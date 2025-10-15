@extends('admin.master_layout')
@section('title')
    <title>{{ __('Create About Feature') }}</title>
@endsection
@section('admin-content')
    <div class="main-content">
        <section class="section">
            <x-admin.breadcrumb title="{{ __('Create About Feature') }}" :list="[
                __('Dashboard') => route('admin.dashboard'),
                __('About Section Features') => route('admin.about-features.index'),
                __('Create About Feature') => '#',
            ]" />

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <x-admin.form-title :text="__('Create About Feature')" />
                                <div>
                                    <x-admin.back-button :href="route('admin.about-features.index')" />
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <form action="{{ route('admin.about-features.store') }}" method="POST">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="title">{{ __('Title') }} <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="title" id="title" 
                                                               value="{{ old('title') }}" required>
                                                        @error('title')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="icon">{{ __('Icon Class') }} <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="icon" id="icon" 
                                                               value="{{ old('icon') }}" placeholder="e.g., fas fa-lightbulb" required>
                                                        @error('icon')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="order">{{ __('Order') }} <span class="text-danger">*</span></label>
                                                        <input type="number" class="form-control" name="order" id="order" 
                                                               value="{{ old('order', 1) }}" min="0" required>
                                                        @error('order')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="status">{{ __('Status') }}</label>
                                                        <select class="form-control" name="status" id="status">
                                                            <option value="1" {{ old('status', 1) == 1 ? 'selected' : '' }}>{{ __('Active') }}</option>
                                                            <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>{{ __('Inactive') }}</option>
                                                        </select>
                                                        @error('status')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="description">{{ __('Description') }} <span class="text-danger">*</span></label>
                                                <textarea class="form-control" name="description" id="description" 
                                                          rows="4" required>{{ old('description') }}</textarea>
                                                @error('description')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary">{{ __('Create') }}</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection