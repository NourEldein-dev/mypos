
@include('dashboard.includes.header')



@include('dashboard.includes.sidebar')



  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{__('site.users')}}</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}">{{__('site.dashboard')}}</a></li>
              <li class="breadcrumb-item active"><a href="{{route('dashboard.users.index')}}">{{__('site.users')}}</a></li>
              <li class="breadcrumb-item active">{{__('site.add')}}</li>
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
          <h3 class="card-title">{{__('site.add')}}</h3>

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


        <form action="{{route('dashboard.users.store')}}" method="post" enctype="multipart/form-data">
            @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">{{__('site.first_name')}}</label>
                    <input type="text" name="first_name" value="{{old('first_name')}}" class="form-control" id="exampleInputEmail1">
                    @error('first_name')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">{{__('site.last_name')}}</label>
                    <input type="text" name="last_name" value="{{old('last_name')}}" class="form-control" id="exampleInputEmail1">
                    @error('last_name')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">{{__('site.email')}}</label>
                    <input type="text" name="email" value="{{old('email')}}" class="form-control" id="exampleInputEmail1">
                    @error('email')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">{{__('site.image')}}</label>
                    <input type="file" name="image" class="form-control" id="exampleInputEmail1">
                    @error('image')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">{{__('site.password')}}</label>
                    <input type="password" name="password" class="form-control" id="exampleInputEmail1">
                    @error('password')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">{{__('site.password_confirmation')}}</label>
                    <input type="password" name="password_confirmation" class="form-control" id="exampleInputEmail1">
                    @error('password_confirmation')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                </div>
                <!-- /.card-body -->


                <div class="card">
        <div class="card-header">
          <h3 class="card-title">{{__('site.permissions')}}</h3>

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


        <!-- Tabs Container -->
<div style="display: flex; flex-direction: column;">
    <!-- Tab Buttons -->
    @php
    $model = ['users'];
    $maps = ['create' , 'read' , 'update' , 'delete'];
    @endphp

    <ul style="display: flex; list-style-type: none; padding: 0; margin: 0; border-bottom: 1px solid #ccc;">

    @foreach($model as $index => $table)
        <li style="margin-right: 2px;">
            <button type="button" style="padding: 10px 20px; cursor: pointer; border: none; background-color: #f1f1f1;" onclick="openTab(event, '{{$index}}')">{{__('site.'.$table)}}</button>
        </li>
    @endforeach
    </ul>

    <!-- Tab Content -->
    @foreach($model as $index => $table)
    <div id="{{$index}}" style="display: none; padding: 15px; border: 1px solid #ccc; border-top: none;">
        <h3 class="mb-4"></h3>

        <div class="row">
          @foreach ($maps as $map)
          <div class="col-3">
                <div class="form-check">
                 <input type="checkbox" name="permissions[]" value="{{$map.'_'.$table}}" class="form-check-input" id="check1">
                  <label class="form-check-label" for="check1">{{__('site.'.$map)}}</label>
                </div>
              </div>
          @endforeach
            </div>

      </div>
      @endforeach
      
       @error('permissions')
        <span class="text-danger">{{ $message }}</span>
       @enderror
</div>

    </div>

        <!-- /.card-body -->
      </div>

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

  <script>
    function openTab(event, tabId) {
        // Hide all tab contents
        var tabContents = document.querySelectorAll('div[id]');
        tabContents.forEach(function(content) {
            content.style.display = 'none';
        });

        // Reset the background color of all tab buttons
        var tabButtons = document.querySelectorAll('ul li button');
        tabButtons.forEach(function(button) {
            button.style.backgroundColor = '#f1f1f1';
            button.style.fontWeight = 'normal';
        });

        // Show the selected tab content
        document.getElementById(tabId).style.display = 'block';

        // Highlight the clicked button
        event.currentTarget.style.backgroundColor = '#ddd';
        event.currentTarget.style.fontWeight = 'bold';
    }

    // Automatically open the first tab without causing a page reload
    document.addEventListener('DOMContentLoaded', function() {
        // Directly open the first tab without triggering a click event
        openTab({ currentTarget: document.querySelector('ul li button') }, 'tab1');
    });
</script>
  



  @include('dashboard.includes.footer')