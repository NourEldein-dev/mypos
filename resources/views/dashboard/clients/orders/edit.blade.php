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
                        <li class="breadcrumb-item"><a
                                href="{{ route('dashboard.clients.index') }}">{{ __('site.clients') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('site.edit') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content" id="order-app" data-order-id="{{ $order->id }}">
        <div class="row">

            <!-- Left Column: Orders -->
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('site.edit') }} {{ __('site.order') }}</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Order Form -->
                    <form action="{{ route('dashboard.clients.orders.update', $order->id) }}" method="post">
                        @csrf
                        <div class="card-body">
                            <div>
                                <h3 class="mb-3">
                                    <i class="fa-solid fa-cart-plus"></i>
                                    {{ __('site.orders') }}
                                </h3>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>{{ __('site.product') }}</th>
                                            <th>{{ __('site.quantity') }}</th>
                                            <th>{{ __('site.price') }}</th>
                                            <th>{{ __('site.delete') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(order, index) in orders" :key="index">
                                            <td>@{{ order.name }}</td>
                                            <td>
                                                <input type="number" class="form-control"
                                                    :name="`products[${order.id}][quantity]`" :value="order.quantity"
                                                    v-model="order.quantity" @input="checkInput($event , order)"
                                                    @change="autoRemoveOrder(index)">
                                            </td>
                                            <td>@{{ order.sale_price }}</td>
                                            <td>
                                                <button type="button" class="btn btn-danger btn-sm"
                                                    @click="removeOrder(index)">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <p>@lang('site.total') : @{{ total }}</p>
                                <button type="submit" class="btn btn-primary mt-3" :disabled="total == 0">
                                    @lang('site.edit_order')
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Right Column: Categories and Products -->
            <div class="col-md-6 offset-md-1">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('site.products') }}</h3>
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
                        @foreach($categories as $category)
                        <div class="mb-3">
                            <div class="panel panel-default">
                                <div class="panel-heading rounded p-1 fw-bold"
                                    style="cursor: pointer; background-color: #e8f9ff;"
                                    @click="toggleCategory({{ $category->id }})">
                                    <h4 class="panel-title">{{ $category->name }}</h4>
                                </div>

                                <!-- Vue transition for smooth collapse/expand -->
                                <transition @before-enter="beforeEnter" @enter="enter" @leave="leave">
                                    <div v-if="openedCategory === {{ $category->id }}" class="panel-body p-1">
                                        @if ($category->products->isNotEmpty())
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>{{ __('site.name') }}</th>
                                                    <th>{{ __('site.stock') }}</th>
                                                    <th>{{ __('site.price') }}</th>
                                                    <th>{{ __('site.add') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($category->products as $product)
                                                <tr>
                                                    <td>{{ $product->name }}</td>
                                                    <td>{{ $product->stock }}</td>
                                                    <td>{{ $product->sale_price }}</td>
                                                    <td>
                                                        <button type="button" class="btn btn-success btn-sm"
                                                            @click="addProduct({{ json_encode($product) }})"
                                                            :disabled="calculateRemainingStock({{ json_encode($product) }}) <= 0">
                                                            <i class="fa-solid fa-plus"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        @else
                                        <p class="fw-bold">{{ __('site.no_data_found') }}</p>
                                        @endif
                                    </div>
                                </transition>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

@include('dashboard.includes.footer')