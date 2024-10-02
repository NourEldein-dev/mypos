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
                    <h1>{{ __('site.products') }}</h1>
                </div>
                <!-- Breadcrumb navigation -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard.index') }}">{{ __('site.dashboard') }}</a>
                        </li>
                        <li class="breadcrumb-item active">{{ __('site.products') }}</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Search & Add Product -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-10 offset-md-1 mt-3 mb-5 d-flex align-items-center justify-content-between">
                    <!-- Search Form -->
                    <form action="{{ route('dashboard.products.index') }}" method="get" class="d-flex w-100">
                        <div class="input-group mr-2 col-md-5">
                            <input type="search" name="search" value="{{ request('search') }}"
                                class="form-control form-control-lg" placeholder="{{ __('site.search') }}">
                            <div>
                                <button type="submit" class="btn btn-lg btn-default">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Category Filter -->
                        <div class="form-group mr-2 col-md-5 mt-1">
                            <select name="category_id" class="form-control" style="width: 300px; height:40px">
                                <option value="">{{ __('site.all_categories') }}</option>
                                @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ request()->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </form>

                    <!-- Add Product Button -->
                    <div class="mb-2">
                        @if (auth()->user()->hasPermissionTo('create_products'))
                        <a href="{{ route('dashboard.products.create') }}"
                            class="btn btn-primary d-flex align-items-center">
                            <i class="fa-solid fa-square-plus mr-2"></i>
                            {{ __('site.add') }}
                        </a>
                        @else
                        <a href="#" class="btn btn-primary disabled">{{ __('site.add') }}</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content: Product List -->
    <section class="content">
        <div class="card">
            <!-- Card Header -->
            <div class="card-header">
                <h3 class="card-title">{{ __('site.products') }} <small>( {{ $products->count() }} )</small></h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>

            <!-- Card Body: Product Table -->
            <div class="card-body">
                @if($products->count() > 0)
                <div class="card-body table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>{{ __('site.name') }}</th>
                                <th>{{ __('site.description') }}</th>
                                <th>{{ __('site.image') }}</th>
                                <th>{{ __('site.purchase_price') }}</th>
                                <th>{{ __('site.sale_price') }}</th>
                                <th>{{ __('site.profit_percent') }}</th>
                                <th>{{ __('site.stock') }}</th>
                                <th style="width: 40px">{{ __('site.action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $index => $product)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $product->name }}</td>
                                <td>
                                    <div class="expandable-cell" id="app-{{ $product->id }}"
                                        data-description="{{ $product->description }}">
                                        <div class="expandable-content">
                                            <p v-if="!showFullText" class="short-text">@{{ truncatedDescription }}</p>
                                            <p v-else class="full-text">@{{ description }}</p>
                                            <button class="toggle-button" @click="toggleText">
                                                @{{ showFullText ? translations.showLess : translations.showMore }}
                                            </button>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <img src="{{ $product->image }}" alt="" style="width: 100px; height: 100px;">
                                </td>
                                <td>{{ number_format($product->purchase_price , 2) }}</td>
                                <td>{{ number_format($product->sale_price , 2) }}</td>
                                <td>{{ $product->profit_percent }}%</td>
                                <td>{{ $product->stock }}</td>
                                <td>
                                    <div class="d-flex justify-content-start">
                                        @if (auth()->user()->hasPermissionTo('update_products'))
                                        <a href="{{ route('dashboard.products.edit', $product->id) }}"
                                            class="btn btn-info mx-3 d-inline-flex align-items-center">
                                            <i class="fa-regular fa-pen-to-square mr-1"></i>
                                            {{ __('site.edit') }}
                                        </a>
                                        @else
                                        <a href="#" class="btn btn-info mx-3 disabled">{{ __('site.edit') }}</a>
                                        @endif

                                        @if (auth()->user()->hasPermissionTo('delete_products'))
                                        <a href="{{ route('dashboard.products.destroy', $product->id) }}"
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

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center">
                        {{ $products->onEachSide(1)->links('vendor.pagination.bootstrap-5') }}
                    </div>
                </div>
                @else
                <h2>{{ __('site.no_data_found') }}</h2>
                @endif
            </div>
        </div>
    </section>

</div>
<!-- /.content-wrapper -->

<!-- Vue.js translation handling -->
<script>
window.translations = {
    showLess: "{{ __('site.show_less') }}",
    showMore: "{{ __('site.show_more') }}",
};
</script>

@include('dashboard.includes.footer')