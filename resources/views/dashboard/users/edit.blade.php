@include('dashboard.includes.header')
<!-- Include Header -->
@include('dashboard.includes.sidebar')
<!-- Include Sidebar -->

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{__('site.users')}}</h1> <!-- Page Title -->
                </div>
                <div class="col-sm-6">
                    <!-- Breadcrumb -->
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{route('dashboard.index')}}">{{__('site.dashboard')}}</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <a href="{{route('dashboard.users.index')}}">{{__('site.users')}}</a>
                        </li>
                        <li class="breadcrumb-item active">{{__('site.edit')}}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content-header -->

    <!-- Main Content Section -->
    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{__('site.edit')}} {{__('site.user')}}</h3>
                <!-- Card Tools -->
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

            <!-- Form Start -->
            <div class="card-body">
                <form action="{{route('dashboard.users.update', $user->id)}}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <!-- CSRF Token for Security -->

                    <!-- User Information Section -->
                    <div class="card-body">
                        <!-- First Name -->
                        <div class="form-group col-md-8">
                            <label for="first_name">{{__('site.first_name')}}</label>
                            <input type="text" name="first_name" value="{{$user->first_name}}" class="form-control"
                                id="first_name">
                            @error('first_name')
                            <!-- Error Message for First Name -->
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Last Name -->
                        <div class="form-group col-md-8">
                            <label for="last_name">{{__('site.last_name')}}</label>
                            <input type="text" name="last_name" value="{{$user->last_name}}" class="form-control"
                                id="last_name">
                            @error('last_name')
                            <!-- Error Message for Last Name -->
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="form-group col-md-8">
                            <label for="email">{{__('site.email')}}</label>
                            <input type="text" name="email" value="{{$user->email}}" class="form-control" id="email">
                            @error('email')
                            <!-- Error Message for Email -->
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Image Upload -->
                        <div class="form-group col-md-8">
                            <label for="image">{{__('site.image')}}</label>
                            <input type="file" name="image" class="form-control" id="image">
                            @error('image')
                            <!-- Error Message for Image -->
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Display Current Image -->
                        <div class="form-group col-md-8">
                            <img src="{{$user->image}}" alt="User Image" width="100px" height="100px">
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <!-- Permissions Section -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{__('site.permissions')}}</h3>
                            <!-- Card Tools -->
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
                            <!-- Tabs for Permissions by Model -->
                            <div style="display: flex; flex-direction: column;">
                                <!-- Tab Buttons -->
                                @php
                                $model = ['categories', 'products', 'clients', 'orders', 'users'];
                                $maps = ['create', 'read', 'update', 'delete'];
                                @endphp
                                <ul
                                    style="display: flex; list-style-type: none; padding: 0; margin: 0; border-bottom: 1px solid #ccc;">
                                    @foreach($model as $index => $table)
                                    <li style="margin-right: 2px;">
                                        <button type="button"
                                            style="padding: 10px 20px; cursor: pointer; border: none; background-color: #f1f1f1;"
                                            onclick="openTab(event, '{{$index}}')">{{__('site.'.$table)}}</button>
                                    </li>
                                    @endforeach
                                </ul>

                                <!-- Tab Content -->
                                @foreach($model as $index => $table)
                                <div id="{{$index}}"
                                    style="display: none; padding: 15px; border: 1px solid #ccc; border-top: none;">
                                    <h3 class="mb-4"></h3>
                                    <div class="row">
                                        @foreach($maps as $map)
                                        <div class="col-3">
                                            <!-- Permission Checkbox -->
                                            <div class="form-check">
                                                <input type="checkbox" name="permissions[]"
                                                    {{$user->hasPermissionTo($map.'_'.$table) ? 'checked' : ''}}
                                                    value="{{$map.'_'.$table}}" class="form-check-input"
                                                    id="check-{{$map}}-{{$table}}">
                                                <label class="form-check-label"
                                                    for="check-{{$map}}-{{$table}}">{{__('site.'.$map)}}</label>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.permissions section -->

                    <!-- Submit Button -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">{{__('site.edit')}}</button>
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
<!-- Include Footer -->