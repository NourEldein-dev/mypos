
@include('dashboard.includes.header')



@include('dashboard.includes.sidebar')

<!-- css for description -->
<style>
  .expandable-cell {
    max-width: 200px; /* Adjust width as needed */
    padding: 10px;
    border: 1px solid #ddd; /* Optional: for better cell definition */
    position: relative;
}

.expandable-content {
    position: relative;
}

.short-text {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.full-text {
    display: none;
}

.toggle-button {
    margin-top: 5px;
    padding: 5px;
    border: none;
    background-color: #007bff;
    color: #fff;
    cursor: pointer;
    border-radius: 3px;
    font-size: 14px;
}
</style>
<!--end css for description -->



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
              <li class="breadcrumb-item active">{{__('site.products')}}</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>


    <section class="content">
        <div class="container-fluid">
         <div class="row">
    <div class="col-md-10 offset-md-1 mt-5 mb-5 d-flex align-items-center justify-content-between">
        <form action="{{ route('dashboard.products.index') }}" method="get" class="d-flex w-100">
            <div class="input-group mr-2 col-md-5">
                <input type="search" name="search" value="{{ request('search') }}" class="form-control form-control-lg" placeholder="{{ __('site.search') }}">
                <div class="">
                    <button type="submit" class="btn btn-lg btn-default">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </div>
            <div class="form-group mr-2 col-md-5 mt-1">
              <select name="category_id" class="form-control" style="width: 300px; height:40px">
                <option value="">{{__('site.all_categories')}}</option>
                @foreach ($categories as $category)
                <option value="{{$category-> id}}" {{request()->category_id == $category->id ? 'selected': ''}}>{{$category->name}}</option>
                @endforeach
              </select>
            </div>
        </form>
        <div class="mb-2">
            @if (auth()->user()->hasPermissionTo('create_products'))
                <a href="{{ route('dashboard.products.create') }}" class="btn btn-primary">{{ __('site.add') }}</a>
            @else
                <a href="#" class="btn btn-primarydisabled">{{ __('site.add') }}</a>
            @endif
        </div>
    </div>
       </div>
        </div>
    </section>


    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">{{__('site.products')}} <small>( {{$products->count()}} )</small></h3>

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

        

            @if($products->count() > 0)
        <div class="card-body table-responsive">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>{{__('site.name')}}</th>
                      <th>{{__('site.description')}}</th>
                      <th>{{__('site.image')}}</th>
                      <th>{{__('site.purchase_price')}}</th>
                      <th>{{__('site.sale_price')}}</th>
                      <th>{{__('site.profit_percent')}}</th>
                      <th>{{__('site.stock')}}</th>
                      <th style="width: 40px">{{__('site.action')}}</th>
                    </tr>
                  </thead>
                  <tbody>
                  @foreach($products as $index => $product)
                    <tr>
                      <td>{{$index + 1}}</td>
                      <td>{{$product -> name}}</td>
                      <td class="expandable-cell">
                        <div class="expandable-content">
                          <p class="short-text">
                            {{ Str::limit($product->description, 50) }}
                          </p>
                         <p class="full-text" style="display: none;">
                          {{ $product->description }}
                        </p>
                        <button class="toggle-button" onclick="toggleText(this)">
                        {{__('site.show_more')}}
                        </button>
                     </div>
                    </td>
                      <td><img src="{{$product->image}}" alt="" style="width: 100px; height: 100px;"></td>
                      <td>{{$product -> purchase_price}}</td>
                      <td>{{$product -> sale_price}}</td>
                      <td>{{$product -> profit_percent}}%</td>
                      <td>{{$product -> stock}}</td>
                      <td>
                        <div class="d-flex justify-content-start">

                        @if (auth()->user()->hasPermissionTo('update_products'))
                        <a href="{{ route('dashboard.products.edit' , $product->id) }}" class="btn btn-info mx-3">{{ __('site.edit') }}</a>
                        @else
                        <a href="#" class="btn btn-info mx-3 disabled">{{ __('site.edit') }}</a>
                        @endif
    
                       @if (auth()->user()->hasPermissionTo('delete_products'))
                        <form action="{{ route('dashboard.products.destroy', $product->id) }}" method="get" class="d-inline" id="delete-form-{{ $product->id }}">
                          @csrf
                            <button type="submit" class="btn btn-danger mx-3" onclick="confirmDelete('{{ $product->id }}')">
                             {{ __('site.delete') }}
                          </button>
                        </form>
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
                     {{ $products->onEachSide(1)->links('vendor.pagination.bootstrap-5') }}
                   </div>
              </div>
              @else
              <h2>{{__('site.no_data_found')}}</h2>
              @endif
              <!-- /.card-body -->

    </div>
    
        <!-- /.card-body -->
        <!-- <div class="card-footer">
          Footer
        </div> -->
        <!-- /.card-footer-->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  
  <script>
    function toggleText(button) {
    const cell = button.closest('.expandable-cell');
    const shortText = cell.querySelector('.short-text');
    const fullText = cell.querySelector('.full-text');

    if (fullText.style.display === 'none') {
        fullText.style.display = 'block';
        shortText.style.display = 'none';
        button.textContent = "{{__('site.show_less')}}";
    } else {
        fullText.style.display = 'none';
        shortText.style.display = 'block';
        button.textContent = "{{__('site.show_more')}}";
    }
}
</script>


  @include('dashboard.includes.footer')