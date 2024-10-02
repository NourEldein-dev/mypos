@include('dashboard.includes.header')

@include('dashboard.includes.sidebar')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <!-- Page Title -->
                <div class="col-sm-6">
                    <h1>{{ __('site.users') }}</h1>
                </div>

                <!-- Breadcrumbs -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard.index') }}">{{ __('site.dashboard') }}</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard.users.index') }}">{{ __('site.users') }}</a>
                        </li>
                        <li class="breadcrumb-item active">{{ __('site.add') }}</li>
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
                <!-- Card Title -->
                <h3 class="card-title">{{ __('site.add') }} {{ __('site.user') }}</h3>

                <!-- Card Tools (Collapse & Remove buttons) -->
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>

            <!-- Card Body -->
            <div class="card-body">
                <!-- Form Start -->
                <form action="{{ route('dashboard.users.store') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <!-- User Information Inputs -->
                    <div class="card-body">

                        <!-- First Name -->
                        <div class="form-group col-md-8">
                            <label for="exampleInputEmail1">{{ __('site.first_name') }}</label>
                            <input type="text" name="first_name" value="{{ old('first_name') }}" class="form-control"
                                id="exampleInputEmail1">
                            @error('first_name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Last Name -->
                        <div class="form-group col-md-8">
                            <label for="exampleInputEmail1">{{ __('site.last_name') }}</label>
                            <input type="text" name="last_name" value="{{ old('last_name') }}" class="form-control"
                                id="exampleInputEmail1">
                            @error('last_name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="form-group col-md-8">
                            <label for="exampleInputEmail1">{{ __('site.email') }}</label>
                            <input type="text" name="email" value="{{ old('email') }}" class="form-control"
                                id="exampleInputEmail1">
                            @error('email')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Image -->
                        <div class="form-group col-md-8">
                            <label for="exampleInputEmail1">{{ __('site.image') }}</label>
                            <input type="file" name="image" class="form-control" id="exampleInputEmail1">
                            @error('image')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="form-group col-md-8">
                            <label for="exampleInputEmail1">{{ __('site.password') }}</label>
                            <input type="password" name="password" class="form-control" id="exampleInputEmail1">
                            @error('password')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Password Confirmation -->
                        <div class="form-group col-md-8">
                            <label for="exampleInputEmail1">{{ __('site.password_confirmation') }}</label>
                            <input type="password" name="password_confirmation" class="form-control"
                                id="exampleInputEmail1">
                            @error('password_confirmation')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                    </div><!-- /.card-body -->

                    <!-- Permissions Section -->
                    <div class="card">
                        <div class="card-header">
                            <!-- Permissions Title -->
                            <h3 class="card-title">{{ __('site.permissions') }}</h3>

                            <!-- Card Tools (Collapse & Remove buttons) -->
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Card Body (Permissions Tabs) -->
                        <div class="card-body">
                            <!-- Tabs Container -->
                            <div style="display: flex; flex-direction: column;">

                                <!-- Tab Buttons -->
                                @php
                                $model = ['categories', 'products', 'clients', 'orders', 'users'];
                                $maps = ['create', 'read', 'update', 'delete'];
                                @endphp

                                <ul
                                    style="display: flex; list-style-type: none; padding: 0; margin: 0; border-bottom: 1px solid #ccc;">
                                    @foreach($model as $index => $table)
                                    <li style="margin-right: 2px;">
                                        <button type="button"
                                            style="padding: 10px 20px; cursor: pointer; border: none; background-color: #f1f1f1;"
                                            onclick="openTab(event, '{{ $index }}')">
                                            {{ __('site.' . $table) }}
                                        </button>
                                    </li>
                                    @endforeach
                                </ul>

                                <!-- Tab Content (Permissions Checkboxes) -->
                                @foreach($model as $index => $table)
                                <div id="{{ $index }}"
                                    style="display: none; padding: 15px; border: 1px solid #ccc; border-top: none;">
                                    <h3 class="mb-4"></h3>

                                    <div class="row">
                                        @foreach ($maps as $map)
                                        <div class="col-3">
                                            <div class="form-check">
                                                <input type="checkbox" name="permissions[]"
                                                    value="{{ $map . '_' . $table }}" class="form-check-input"
                                                    id="check-{{$map}}-{{$table}}">
                                                <label class="form-check-label"
                                                    for="check-{{$map}}-{{$table}}">{{ __('site.' . $map) }}</label>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div><!-- /.row -->
                                </div>
                                @endforeach

                                <!-- Permissions Error -->
                                @error('permissions')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div><!-- /.tabs container -->
                        </div><!-- /.card-body -->
                    </div><!-- /.permissions card -->

                    <!-- Form Submit Button -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">{{ __('site.add') }}</button>
                    </div>
                </form><!-- /.form -->
            </div><!-- /.card-body -->
        </div><!-- /.card -->

    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

@include('dashboard.includes.footer')