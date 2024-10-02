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
                        <li class="breadcrumb-item active">
                            <a href="{{ route('dashboard.products.index') }}">{{ __('site.products') }}</a>
                        </li>
                        <li class="breadcrumb-item active">{{ __('site.edit') }}</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Card Container -->
        <div class="card">

            <!-- Card Header -->
            <div class="card-header">
                <h3 class="card-title">{{ __('site.edit') }} {{ __('site.product') }}</h3>

                <!-- Tools for collapsing/removing the card -->
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <!-- /.card-header -->

            <!-- Card Body -->
            <div class="card-body">

                <!-- Edit Product Form -->
                <form action="{{ route('dashboard.products.update', $product->id) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf

                    <!-- Category Select Field -->
                    <div class="form-group col-md-8">
                        <label for="category_id">{{ __('site.select_category') }}</label>
                        <select name="category_id" class="form-control" id="category_id">
                            <option value="">{{ __('site.all_categories') }}</option>
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('category_id')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Looping through translatable locales for name and description -->
                    @foreach (config('translatable.locales') as $locale)
                    <div class="form-group col-md-8">
                        <!-- Product Name -->
                        <label for="{{ $locale }}_name">{{ __('site.' . $locale . '.name') }}</label>
                        <input type="text" name="{{ $locale }}[name]" value="{{ $product->translate($locale)->name }}"
                            class="form-control" id="{{ $locale }}_name">
                        @error("$locale.name")
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-8">
                        <!-- Product Description -->
                        <label for="{{ $locale }}_description">{{ __('site.' . $locale . '.description') }}</label>
                        <textarea name="{{ $locale }}[description]" class="form-control ckeditor"
                            id="editor_{{ $locale }}">
                {{ $product->translate($locale)->description }}
              </textarea>
                        @error("$locale.description")
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    @endforeach

                    <!-- Image Upload Section -->
                    <div class="form-group col-md-8">
                        <label for="image">{{ __('site.image') }}</label>
                        <input type="file" name="image" class="form-control" id="image">
                        @error('image')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Displaying current image -->
                    <div class="form-group col-md-8">
                        <img src="{{ $product->image }}" alt="product image" width="100px" height="100px">
                    </div>

                    <!-- Pricing and Stock Fields -->
                    <div class="form-group col-md-8">
                        <label for="purchase_price">{{ __('site.purchase_price') }}</label>
                        <input type="number" name="purchase_price" value="{{ $product->purchase_price }}"
                            class="form-control" id="purchase_price">
                        @error('purchase_price')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-8">
                        <label for="sale_price">{{ __('site.sale_price') }}</label>
                        <input type="number" name="sale_price" value="{{ $product->sale_price }}" class="form-control"
                            id="sale_price">
                        @error('sale_price')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-8">
                        <label for="stock">{{ __('site.stock') }}</label>
                        <input type="number" name="stock" value="{{ $product->stock }}" class="form-control" id="stock">
                        @error('stock')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">{{ __('site.edit') }}</button>
                    </div>

                </form>
                <!-- /.form -->

            </div>
            <!-- /.card-body -->

        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->

</div>
<!-- /.content-wrapper -->

@include('dashboard.includes.footer')