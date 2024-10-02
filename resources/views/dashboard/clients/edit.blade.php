@include('dashboard.includes.header')
@include('dashboard.includes.sidebar')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ __('site.clients') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a
                                href="{{ route('dashboard.index') }}">{{ __('site.dashboard') }}</a></li>
                        <li class="breadcrumb-item active"><a
                                href="{{ route('dashboard.clients.index') }}">{{ __('site.clients') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('site.edit') }}</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ __('site.edit') }} {{ __('site.client') }}</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">

                <!-- Client edit form -->
                <form action="{{ route('dashboard.clients.update', $client->id) }}" method="post">
                    @csrf
                    <div class="card-body">

                        <!-- Client Name Field -->
                        <div class="form-group col-md-8">
                            <label>{{ __('site.name') }}</label>
                            <input type="text" name="name" value="{{ $client->name }}" class="form-control">
                            @error('name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Client Mobile Field -->
                        <div class="form-group col-md-8">
                            <label>{{ __('site.mobile') }}</label>
                            <input type="text" name="mobile" value="{{ $client->mobile }}" class="form-control">
                            @error('mobile')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Client Second Mobile Field -->
                        <div class="form-group col-md-8">
                            <label>{{ __('site.second_mobile') }}</label>
                            <input type="text" name="second_mobile" value="{{ $client->second_mobile }}"
                                class="form-control">
                            @error('second_mobile')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Client Address Field -->
                        <div class="form-group col-md-8">
                            <label>{{ __('site.address') }}</label>
                            <textarea name="address" class="form-control">{{ $client->address }}</textarea>
                            @error('address')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>
                    <!-- /.card-body -->

                    <!-- Form Submission -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">{{ __('site.edit') }}</button>
                    </div>
                </form>

            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

@include('dashboard.includes.footer')