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
                        <li class="breadcrumb-item active">{{ __('site.clients') }}</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Search and Add Client Section -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- Search Form -->
                <div class="col-md-5 offset-md-2 mb-5 mt-3 pr-5">
                    <form action="{{ route('dashboard.clients.index') }}" method="get">
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
                <!-- Add Client Button -->
                <div class="col-md-3 d-flex align-items-center mb-4 ml-5">
                    @if (auth()->user()->hasPermissionTo('create_clients'))
                    <a href="{{ route('dashboard.clients.create') }}" class="btn btn-primary">
                        <i class="fa-solid fa-square-plus mr-1"></i>
                        {{ __('site.add') }}
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

        <!-- Default box for clients -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ __('site.clients') }} <small>( {{ $clients->count() }} )</small></h3>

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

                @if ($clients->count() > 0)
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>{{ __('site.name') }}</th>
                                <th>{{ __('site.mobile') }}</th>
                                <th>{{ __('site.second_mobile') }}</th>
                                <th>{{ __('site.address') }}</th>
                                <th>{{ __('site.add_order') }}</th>
                                <th style="width: 40px">{{ __('site.action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($clients as $index => $client)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $client->name }}</td>
                                <td>{{ $client->mobile }}</td>
                                <td>{{ $client->second_mobile ?? '' }}</td>
                                <td>{{ $client->address }}</td>
                                <td>
                                    @if (auth()->user()->hasPermissionTo('create_orders'))
                                    <a href="{{ route('dashboard.clients.orders.create', $client->id) }}"
                                        class="btn btn-success btn-sm">
                                        <i class="fa-solid fa-square-plus mr-1"></i>
                                        {{ __('site.add_order') }}
                                    </a>
                                    @else
                                    <a href="#" class="btn btn-success btn-sm disabled">{{ __('site.add_order') }}</a>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex justify-content-start">
                                        <!-- Edit Client Button -->
                                        @if (auth()->user()->hasPermissionTo('update_clients'))
                                        <a href="{{ route('dashboard.clients.edit', $client->id) }}"
                                            class="btn btn-info mx-3 d-inline-flex align-items-center">
                                            <i class="fa-regular fa-pen-to-square mr-1"></i>
                                            {{ __('site.edit') }}
                                        </a>
                                        @else
                                        <a href="#" class="btn btn-info mx-3 disabled">{{ __('site.edit') }}</a>
                                        @endif

                                        <!-- Delete Client Button -->
                                        @if (auth()->user()->hasPermissionTo('delete_clients'))
                                        <a href="{{ route('dashboard.clients.destroy', $client->id) }}"
                                            class="btn btn-danger mx-3 d-inline-flex align-items-center"
                                            data-confirm-delete="true">
                                            <i class="fa-solid fa-trash-can mr-1"></i>
                                            {{ __('site.delete') }}
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
                    <div class="d-flex justify-content-center">
                        {{ $clients->appends(request()->query())->links('vendor.pagination.bootstrap-4') }}
                    </div>
                </div>
                @else
                <h2>{{ __('site.no_data_found') }}</h2>
                @endif
                <!-- /.card-body -->

            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

@include('dashboard.includes.footer')