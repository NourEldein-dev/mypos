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

                <!-- Breadcrumb -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a
                                href="{{ route('dashboard.index') }}">{{ __('site.dashboard') }}</a></li>
                        <li class="breadcrumb-item active"><a
                                href="{{ route('dashboard.products.index') }}">{{ __('site.products') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('site.add') }}</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content section -->
    <section class="content">
        <!-- Default card box -->
        <div class="card">
            <div class="card-header">
                <!-- Card Title -->
                <h3 class="card-title">{{ __('site.add') }} {{ __('site.product') }}</h3>

                <!-- Card tools: collapse and remove buttons -->
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>

            <!-- Card body (form for adding product) -->
            <div class="card-body">
                <!-- Product Form -->
                <form action="{{ route('dashboard.products.store') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <!-- Form Body -->
                    <div class="card-body">

                        <!-- Category Selection -->
                        <div class="form-group col-md-8">
                            <label for="category">{{ __('site.select_category') }}</label>
                            <select name="category_id" class="form-control" id="category">
                                <option value="">{{ __('site.all_categories') }}</option>
                                @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('category_id')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Product details for each language -->
                        @foreach (config('translatable.locales') as $locale)
                        <!-- Product Name -->
                        <div class="form-group col-md-8">
                            <label for="name_{{ $locale }}">{{ __('site.'.$locale.'.name') }}</label>
                            <input type="text" name="{{ $locale }}[name]" value="{{ old($locale.'.name') }}"
                                class="form-control" id="name_{{ $locale }}">
                            @error("$locale.name")
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Product Description -->
                        <div class="form-group col-md-8">
                            <label for="description_{{ $locale }}">{{ __('site.'.$locale.'.description') }}</label>
                            <textarea name="{{ $locale }}[description]" class="form-control ckeditor"
                                id="description_{{ $locale }}">{{ old($locale.'.description') }}</textarea>
                            @error("$locale.description")
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        @endforeach

                        <!-- Product Image -->
                        <div class="form-group col-md-8">
                            <label for="image">{{ __('site.image') }}</label>
                            <input type="file" name="image" class="form-control" id="image">
                            @error('image')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Purchase Price -->
                        <div class="form-group col-md-8">
                            <label for="purchase_price">{{ __('site.purchase_price') }}</label>
                            <input type="number" name="purchase_price" value="{{ old('purchase_price') }}"
                                class="form-control" id="purchase_price">
                            @error('purchase_price')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Sale Price -->
                        <div class="form-group col-md-8">
                            <label for="sale_price">{{ __('site.sale_price') }}</label>
                            <input type="number" name="sale_price" value="{{ old('sale_price') }}" class="form-control"
                                id="sale_price">
                            @error('sale_price')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Stock Quantity -->
                        <div class="form-group col-md-8">
                            <label for="stock">{{ __('site.stock') }}</label>
                            <input type="number" name="stock" value="{{ old('stock') }}" class="form-control"
                                id="stock">
                            @error('stock')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <!-- Form Footer (Submit Button) -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">{{ __('site.add') }}</button>
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