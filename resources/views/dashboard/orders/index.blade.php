@include('dashboard.includes.header')
@include('dashboard.includes.sidebar')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Content Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ __('site.orders') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{{ __('site.dashboard') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('site.orders') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- search form -->
        <div class="col-md-5 offset-md-2 mb-5 mt-3 pr-5">
            <form action="{{ route('dashboard.orders.index') }}" method="get">
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
        <div class="container-fluid">

            <!-- Orders Table -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                {{ __('site.orders') }} <small>( {{ $orders->count() }} )</small>
                            </h3>
                        </div>
                        <div class="card-body">
                            @if($orders->count() > 0)
                            <!-- Table for displaying orders -->
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('site.client_name') }}</th>
                                        <th>{{ __('site.price') }}</th>
                                        <th>{{ __('site.created_at') }}</th>
                                        <th>{{ __('site.action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $index => $order)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $order->client->name }}</td>
                                        <td>{{ number_format($order->total_price, 2) }}</td>
                                        <td>{{ $order->created_at->format('Y-m-d') }}<br>{{ $order->created_at->format('H:i:s') }}
                                        </td>
                                        <td style="width: 100px;">
                                            <div class="d-flex justify-content-start">
                                                <!-- Show products button -->
                                                <button @click="fetchProducts({{ $order->id }})"
                                                    class="btn btn-success mx-3 d-inline-flex align-items-center">
                                                    <i class="fa-regular fa-eye mr-1"></i> {{ __('site.show') }}
                                                </button>

                                                @if (auth()->user()->hasPermissionTo('update_orders'))
                                                <a href="{{ route('dashboard.clients.orders.edit', $order->id) }}"
                                                    class="btn btn-info mx-3 d-inline-flex align-items-center">
                                                    <i class="fa-regular fa-pen-to-square mr-1"></i>
                                                    {{ __('site.edit') }}
                                                </a>
                                                @else
                                                <a href="#" class="btn btn-info mx-3 disabled">{{ __('site.edit') }}</a>
                                                @endif

                                                @if (auth()->user()->hasPermissionTo('delete_orders'))
                                                <a href="{{ route('dashboard.orders.destroy', $order->id) }}"
                                                    class="btn btn-danger mx-3 d-inline-flex align-items-center"
                                                    data-confirm-delete="true">
                                                    <i class="fa-solid fa-trash-can mr-1"></i> {{ __('site.delete') }}
                                                </a>
                                                @else
                                                <a href="#"
                                                    class="btn btn-danger mx-3 disabled">{{ __('site.delete') }}</a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <!-- Pagination -->
                            <div class="d-flex justify-content-center">
                                {{ $orders->appends(request()->query())->links('vendor.pagination.bootstrap-4') }}
                            </div>
                            @else
                            <h2>{{ __('site.no_data_found') }}</h2>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products Table -->
            <div class="row mt-5">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('site.show_products') }}</h3>
                        </div>
                        <div class="card-body">
                            <!-- Products display section -->
                            <div v-if="products.length > 0" ref="printSection">
                                <table class="table table-bordered mt-3">
                                    <thead>
                                        <tr>
                                            <th>{{ __('site.product_name') }}</th>
                                            <th>{{ __('site.quantity') }}</th>
                                            <th>{{ __('site.price') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="product in products" :key="product.id">
                                            <td>@{{ product.name }}</td>
                                            <td>@{{ product.pivot.quantity }}</td>
                                            <td>@{{ (product.sale_price * product.pivot.quantity).toFixed(2) }}</td>
                                        </tr>
                                    </tbody>
                                </table>

                                <div class="d-flex justify-content-between text-right mr-5">
                                    <p>@{{total}} : {{ __('site.total')}}</p>
                                    <a href="javascript:void(0);" @click="printTable" class="btn btn-info print-button">
                                        <i class="fa-solid fa-print mr-1"></i>
                                        {{__('site.print')}}
                                    </a>
                                </div>
                            </div>
                            <div v-else>
                                <h2>{{ __('site.no_data_found') }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

</div>

<script src="{{ asset('assets/js/product_order.js') }}"></script>

@include('dashboard.includes.footer')