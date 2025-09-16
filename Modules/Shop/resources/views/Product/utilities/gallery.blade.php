@extends('admin.master_layout')
@section('title')
    <title>{{ __('Update Gallery') }}</title>
@endsection
@section('admin-content')
    <div class="main-content">
        <section class="section">
            <x-admin.breadcrumb title="{{ __('Update Gallery') }}" :list="[
                __('Dashboard') => route('admin.dashboard'),
                __('Product List') => route('admin.product.index'),
                __('Edit Product') => route('admin.product.edit', [
                    'product' => $product->id,
                    'code' => allLanguages()->first()->code,
                ]),
                __('Update Gallery') => '#',
            ]" />

            @include('shop::Product.utilities.navbar')

            <div class="section-body">
                <div class="mt-4 row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <h4>{{ __('Update Gallery') }}</h4>
                                <div>
                                    <a href="{{ route('admin.product.edit', [
                                        'product' => $product->id,
                                        'code' => allLanguages()->first()->code,
                                    ]) }}"
                                        class="btn btn-primary"><i class="fa fa-arrow-left"></i> {{ __('Back') }}</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <form id="dropzoneForm" method="post"
                                    action="{{ route('admin.product.gallery.update', request('id')) }}"
                                    enctype="multipart/form-data" class="dropzone">
                                    @csrf
                                    @method('PUT')
                                </form>
                                <div class="mt-3 text-center">
                                    <button type="button" class="btn btn-success" id="submit-all"><i
                                            class="fas fa-upload"></i>
                                        {{ __('Upload All') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h4>{{ __('Gallery') }}</h4>
                            </div>
                            <div class="card-body">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>{{ __('SN') }}</th>
                                            <th>{{ __('Preview') }}</th>
                                            <th>{{ __('Image') }}</th>
                                            <th class="text-center">{{ __('Actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($gallery as $item)
                                            <tr>
                                                <td>{{ $loop->index + 1 }}</td>
                                                <td>
                                                    @if ($item->preview)
                                                        <img class="img-thumbnail" src="{{ asset($item->preview) }}"
                                                            alt="" height="100px" width="100px">
                                                    @endif
                                                </td>
                                                <td>
                                                    <img class="img-thumbnail" src="{{ asset($item->image) }}"
                                                        alt="" height="100px" width="100px">
                                                </td>
                                                <td class="text-center">
                                                    <div>
                                                        <a href="{{ route('admin.product.gallery.delete', $item->id) }}"
                                                            data-modal="#deleteModal"
                                                            class="delete-btn btn btn-danger btn-sm"><i class="fa fa-trash"
                                                                aria-hidden="true"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <x-empty-table :name="__('Gallery')" route="admin.product.index" create="no"
                                                :message="__('No data found!')" colspan="4">
                                            </x-empty-table>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <x-admin.delete-modal />
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('backend/dropzone/dropzone.min.css') }}">
    <style>
        .dropzone {
            background: white;
            border-radius: 5px;
            border: 2px dashed rgb(0, 135, 247);
            border-image: none;
            max-width: 805px;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
@endpush
@push('js')
    <script src="{{ asset('backend/dropzone/dropzone.min.js') }}"></script>
    <script type="text/javascript">
        Dropzone.options.dropzoneForm = {
            autoProcessQueue: false,
            uploadMultiple: true,
            parallelUploads: 10,
            thumbnailHeight: 200,
            thumbnailWidth: 200,
            maxFilesize: 3,
            filesizeBase: 1000,
            addRemoveLinks: true,
            renameFile: function(file) {
                var dt = new Date();
                var time = dt.getTime();
                return time + file.name;
            },
            acceptedFiles: ".jpeg,.jpg,.png,.gif,.webp",
            init: function() {
                myDropzone = this;
                $('#submit-all').on('click', function(e) {
                    e.preventDefault();
                    myDropzone.processQueue();
                });

                this.on("complete", function() {
                    if (this.getQueuedFiles().length == 0 && this.getUploadingFiles().length == 0) {
                        var _this = this;
                        _this.removeAllFiles();
                    }
                });
            },
            success: function(file, response) {
                window.location.href = response.url;
                toastr.success(response.message, 'Success');
            },
        };
    </script>
@endpush
