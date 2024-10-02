@include('dashboard.includes.header')

@include('dashboard.includes.sidebar')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{__('site.dashboard')}}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{{__('site.dashboard')}}</a></li>
                        <!-- <li class="breadcrumb-item active">Blank Page</li> -->
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <div class="row mr-2 ml-2">
        <!-- Categories Count Box -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{$category_count}}</h3>
                    <p>{{__('site.categories')}}</p>
                </div>
                <div class="icon">
                    <i class="fa-solid fa-list"></i>
                </div>
                <a href="{{route('dashboard.categories.index')}}" class="small-box-footer">{{__('site.show')}} <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->

        <!-- Products Count Box -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{$product_count}}</h3>
                    <p>{{__('site.products')}}</p>
                </div>
                <div class="icon">
                    <i class="fa-solid fa-layer-group"></i>
                </div>
                <a href="{{route('dashboard.products.index')}}" class="small-box-footer">{{__('site.show')}} <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->

        <!-- Clients Count Box -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{$client_count}}</h3>
                    <p>{{__('site.clients')}}</p>
                </div>
                <div class="icon">
                    <i class="fa-solid fa-person-walking-luggage"></i>
                </div>
                <a href="{{route('dashboard.clients.index')}}" class="small-box-footer">{{__('site.show')}} <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->

        <!-- Users Count Box -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{$user_count}}</h3>
                    <p>{{__('site.users')}}</p>
                </div>
                <div class="icon">
                    <i class="fa-regular fa-user"></i>
                </div>
                <a href="{{route('dashboard.users.index')}}" class="small-box-footer">{{__('site.show')}} <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
    </div>

    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{__('site.sales_graph')}}</h3>

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
                <!-- Canvas element for the chart -->
                <canvas id="salesChart" width="400" height="200"></canvas>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

@include('dashboard.includes.footer')