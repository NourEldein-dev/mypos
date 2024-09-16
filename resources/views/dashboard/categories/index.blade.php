@include('dashboard.includes.header')



@include('dashboard.includes.sidebar')



<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{__('site.categories')}}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}">{{__('site.dashboard')}}</a>
                        </li>
                        <li class="breadcrumb-item active">{{__('site.categories')}}</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>


    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-5 offset-md-2 mb-5 mt-5 pr-5">
                    <form action="{{route('dashboard.categories.index')}}" method="get">
                        <div class="input-group">
                            <input type="search" name="search" value="{{request('search')}}"
                                class="form-control form-control-lg" placeholder="{{__('site.search')}}">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-lg btn-default">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-3 d-flex align-items-center">
                    @if (auth()->user()->hasPermissionTo('create_categories'))
                    <a href="{{route('dashboard.categories.create')}}" class="btn btn-primary">{{__('site.add')}}</a>
                    @else
                    <a href="" class="btn btn-primary disabled">{{__('site.add')}}</a>
                    @endif

                </div>
            </div>
        </div>
    </section>


    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{__('site.categories')}} <small>( {{$categories->count()}} )</small></h3>

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



                @if($categories->count() > 0)
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>{{__('site.name')}}</th>
                                <th>{{__('site.products_count')}}</th>
                                <th>{{__('site.related_products')}}</th>
                                <th style="width: 40px">{{__('site.action')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $index => $category)
                            <tr>
                                <td>{{$index + 1}}</td>
                                <td>{{$category -> name}}</td>
                                <td>{{$category -> products->count()}}</td>
                                <td><a href="{{route('dashboard.products.index',['category_id'=> $category->id])}}"
                                        class="btn btn-success btn-sm">{{__('site.related_products')}}</a></td>
                                <td>
                                    <div class="d-flex justify-content-start">

                                        @if (auth()->user()->hasPermissionTo('update_categories'))
                                        <a href="{{ route('dashboard.categories.edit' , $category->id) }}"
                                            class="btn btn-info mx-3 d-inline-flex align-items-center">
                                            <i class="fa-regular fa-pen-to-square mr-1"></i>
                                            {{ __('site.edit') }}
                                        </a>
                                        @else
                                        <a href="#" class="btn btn-info mx-3 disabled">{{ __('site.edit') }}</a>
                                        @endif

                                        @if (auth()->user()->hasPermissionTo('delete_categories'))
                                        <a href="{{ route('dashboard.categories.destroy', $category->id) }}"
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
                        {{ $categories->onEachSide(1)->links('vendor.pagination.bootstrap-4') }}
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
function confirmDelete(userId) {
    if (confirm("{{__('site.delete_confirmation_message')}}")) {
        document.getElementById('delete-form-' + userId).submit();
    }
}
</script>


@include('dashboard.includes.footer')