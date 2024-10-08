@include('dashboard.includes.header')
<!-- Include Header -->
@include('dashboard.includes.sidebar')
<!-- Include Sidebar -->

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

                <!-- Breadcrumb -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard.index') }}">{{ __('site.dashboard') }}</a>
                        </li>
                        <li class="breadcrumb-item active">{{ __('site.users') }}</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Search Bar and Add Button -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">

                <!-- Search Form -->
                <div class="col-md-5 offset-md-2 mb-5 mt-3 pr-5">
                    <form action="{{ route('dashboard.users.index') }}" method="get">
                        <div class="input-group">
                            <input type="search" name="search" value="{{ request('search') }}"
                                class="form-control form-control-lg" placeholder="{{ __('site.search') }}">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-lg btn-default">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Add User Button -->
                <div class="col-md-3 d-flex align-items-center mb-4 ml-5">
                    @if (auth()->user()->hasPermissionTo('create_users'))
                    <a href="{{ route('dashboard.users.create') }}" class="btn btn-primary">
                        <i class="fa-solid fa-square-plus mr-1"></i> {{ __('site.add') }}
                    </a>
                    @else
                    <a href="#" class="btn btn-primary disabled">{{ __('site.add') }}</a>
                    @endif
                </div>

            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- User Table -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ __('site.users') }} <small>( {{ $users->count() }} )</small></h3>

                <!-- Card Tools (Collapse/Remove) -->
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
                @if ($users->count() > 0)
                <!-- Users Table -->
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>{{ __('site.first_name') }}</th>
                                <th>{{ __('site.last_name') }}</th>
                                <th>{{ __('site.email') }}</th>
                                <th>{{ __('site.image') }}</th>
                                <th style="width: 40px">{{ __('site.action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $index => $user)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $user->first_name }}</td>
                                <td>{{ $user->last_name }}</td>
                                <td>{{ $user->email }}</td>
                                <td><img src="{{ $user->image }}" alt="" width="100px" height="100px"></td>
                                <td>
                                    <div class="d-flex justify-content-start">
                                        <!-- Edit Button -->
                                        @if (auth()->user()->hasPermissionTo('update_users'))
                                        <a href="{{ route('dashboard.users.edit', $user->id) }}"
                                            class="btn btn-info mx-3 d-inline-flex align-items-center">
                                            <i class="fa-regular fa-pen-to-square mr-1"></i> {{ __('site.edit') }}
                                        </a>
                                        @else
                                        <a href="#" class="btn btn-info mx-3 disabled">{{ __('site.edit') }}</a>
                                        @endif

                                        <!-- Delete Button -->
                                        @if (auth()->user()->hasPermissionTo('delete_users'))
                                        <a href="{{ route('dashboard.users.destroy', $user->id) }}"
                                            class="btn btn-danger mx-3 d-inline-flex align-items-center"
                                            data-confirm-delete="true">
                                            <i class="fa-solid fa-trash-can mr-1"></i> {{ __('site.delete') }}
                                        </a>
                                        @else
                                        <a href="#" class="btn btn-danger mx-3 disabled">{{ __('site.delete') }}</a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- Pagination -->
                    <div class="d-flex justify-content-center">
                        {{ $users->appends(request()->query())->links('vendor.pagination.bootstrap-4') }}
                    </div>
                </div>
                @else
                <h2>{{ __('site.no_data_found') }}</h2>
                @endif
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->

</div>
<!-- /.content-wrapper -->

@include('dashboard.includes.footer')
<!-- Include Footer -->