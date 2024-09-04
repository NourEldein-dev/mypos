
@include('dashboard.includes.header')



@include('dashboard.includes.sidebar')



  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{__('site.products')}}</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}">{{__('site.dashboard')}}</a></li>
              <li class="breadcrumb-item active"><a href="{{route('dashboard.products.index')}}">{{__('site.products')}}</a></li>
              <li class="breadcrumb-item active">{{__('site.edit')}}</li>
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
          <h3 class="card-title">{{__('site.edit')}} {{__('site.product')}}</h3>

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


        <form action="{{route('dashboard.products.update', $product->id)}}" method="post" enctype="multipart/form-data">
            @csrf
                <div class="card-body">

                <div class="form-group col-md-8">
                    <label for="exampleInputEmail1">{{__('site.select_category')}}</label>
                    <select name="category_id" class="form-control" id="exampleInputEmail1">
                    <option value="">{{__('site.all_categories')}}</option>
                        @foreach ($categories as $category)
                          <option value="{{$category->id}}" {{$product->category_id == $category->id ? 'selected' :''}}>{{$category->name}}</option>
                        @endforeach
                    </select> 
                    @error('category_id')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>


              @foreach (config('translatable.locales') as $locale)
                <div class="form-group col-md-8">
                    <label for="exampleInputEmail1">{{__('site.'.$locale.'.name')}}</label>
                    <input type="text" name="{{$locale}}[name]" value="{{old($locale.'.name')}}" class="form-control" id="exampleInputEmail1">
                    @error("$locale.name")
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>

                  <div class="form-group col-md-8">
                    <label>{{__('site.'.$locale.'.description')}}</label>
                    <textarea name="{{$locale}}[description]" class="form-control ckeditor" id="editor"> {{old($locale.'.description')}} </textarea>
                    @error("$locale.description")
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                @endforeach

                <div class="form-group col-md-8">
                    <label >{{__('site.image')}}</label>
                    <input type="file" name="image" class="form-control">
                    @error('image')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="form-group col-md-8">
                    <label >{{__('site.purchase_price')}}</label>
                    <input type="number" name="purchase_price" value="{{old('purchase_price')}}" class="form-control">
                    @error('purchase_price')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="form-group col-md-8">
                    <label >{{__('site.sale_price')}}</label>
                    <input type="number" name="sale_price" value="{{old('sale_price')}}" class="form-control">
                    @error('sale_price')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="form-group col-md-8">
                    <label >{{__('site.stock')}}</label>
                    <input type="number" name="stock" value="{{old('stock')}}" class="form-control">
                    @error('stock')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">{{__('site.add')}}</button>
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