
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
              <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}">{{__('site.dashboard')}}</a></li>
              <li class="breadcrumb-item active"><a href="{{route('dashboard.categories.index')}}">{{__('site.categories')}}</a></li>
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
          <h3 class="card-title">{{__('site.edit')}}</h3>

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


        <form action="{{route('dashboard.categories.update' , $category->id)}}" method="post">
            @csrf
                <div class="card-body">
                @foreach (config('translatable.locales') as $locale)
                <div class="form-group col-md-8">
                    <label for="exampleInputEmail1">{{__('site.'.$locale.'.name')}}</label>
                    <input type="text" name="{{$locale}}[name]" value="{{$category->translate($locale)->name}}" class="form-control" id="exampleInputEmail1">
                    @error("$locale.name")
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                @endforeach
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">{{__('site.edit')}}</button>
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