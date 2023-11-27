@extends('layouts.admin.default')
@section('title')
    @parent {{ $pageTitle }}
@stop
@section('head_page')

  <!-- DataTables -->
  <link href="{{ asset('/assets/admin/vendor/datatables.net/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
  type="text/css" />
<link href="{{ asset('/assets/admin/vendor/datatables.net/css/responsive.bootstrap4.min.css') }}" rel="stylesheet"
  type="text/css" />

@stop

@section('breadcrumb')
<li><span>{{ $title }}</span></li>
@stop

@section('content')
<section role="main" class="content-body card-margin">
    <div class="mt-2">
        @include('layouts.admin.includes.modals')
 
        @include('layouts.admin.includes.errors')        
    </div>
    <!-- start: page -->
   
    <div class="row">
        <div class="col">
            <form id="formData" enctype="multipart/form-data" action=" {{ route("admin.clinic-personal.saveFilter") }}" method="post"  novalidate="false">
                @csrf
                @method("post")
            <section class="card card-featured-top card-featured-primary">
                <header class="card-header">
                    <div class="card-actions">
                        <a href="#" class="card-action card-action-toggle" data-card-toggle=""></a>
                        <a href="#" class="card-action card-action-dismiss" data-card-dismiss=""></a>
                    </div>
                    <h2 class="card-title">{!! trans('general/admin_lang.filters_exports') !!}</h2>
                </header>
            
                <div class="card-body py-4">  
                    <div class="row">
                        <div class="col-12 ">                     
                            <div class="form-group">
                                <label for="specialization_id" class="col-12" > {{ trans('clinic-personal/admin_lang.fields.specialization_id') }}</label>
                                <select class="form-control select2 col-12" style="width: 100%" name="specialization_id[]" multiple id="specialization_id">
                                    @foreach ($specializations as $specialization)
                                        <option value="{{ $specialization->id }}" @if (in_array($specialization->id,$filtSpecializationId)) selected @endif >{{ $specialization->name }}</option>
                                    @endforeach 
                                </select>    
                            
                            </div>
                        </div>   
                       
                    </div>                       
                </div>
                <div class="card-footer">  
                    <div class="row ">
                        <div class="col-12 col-md-6 d-flex justify-content-start">
                            <button class="btn btn-success btn-xs " type="submit"> {!! trans('general/admin_lang.filter') !!}</button>
                            <a href="{{ url('admin/clinic-personal/remove-filter') }}" class="ms-2 btn btn-danger btn-xs">
                                {!! trans('general/admin_lang.clean_filter') !!}
                            </a>
                        </div>
                        @if ( Auth::user()->isAbleTo("admin-clinic-personal-list") ) 
                        <div class="col-12 col-md-6 d-flex justify-content-end">
                            <a href="{{ url('admin/clinic-personal/export-excel') }}" class="text-success">
                                <i class="far fa-file-excel fa-2x"></i>
                            </a>
                        </div>
                        @endif
                    </div>                       
                </div>
            </section>
            </form>
        </div>
    </div>

        <div class="row">
            <div class="col">
                <section class="card card-featured-top card-featured-primary">
                    <header class="card-header">
                        <div class="card-actions">
                            <a href="#" class="card-action card-action-toggle" data-card-toggle=""></a>
                            <a href="#" class="card-action card-action-dismiss" data-card-dismiss=""></a>
                        </div>

                        <h2 class="card-title">{{ $title }}</h2>
                    </header>
                    {{-- <div class="card-body">  
                        <div class="text-end">
                            @if(Auth::user()->isAbleTo("admin-clinic-personal-create"))
                              <a href="{{ url('admin/clinic-personal/create') }}" class="btn btn-outline-success">
                                {{ trans('clinic-personal/admin_lang.new') }}
                              </a>
                            @endif
                          </div>
                    </div> --}}

                    <div class="card-body">  
                        <div class="row">
                            <div class="col-12 table-responsive">
                                @if ( Auth::user()->isAbleTo("admin-clinic-personal-list") ) 
                                <table id="table_clinic-personal" class="table table-bordered table-striped" style="width: 100%" aria-hidden="true">
                                    <thead>
                                        <tr>
                                            <th scope="col">
                                            <th scope="col">
                                            <th scope="col">
                                            <th scope="col">
                                            <th scope="col">
                                            <th scope="col">
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th scope="col">
                                            <th scope="col">
                                            <th scope="col">
                                            <th scope="col">
                                            <th scope="col">
                                            <th scope="col">
                                        </tr>                               
                                    </tfoot>
                                </table>
                                @else
                                    <h2 class="text-warning">{!! trans('general/admin_lang.not_permission') !!}</h2>
                                @endif
                            </div>
                        </div>                       
                    </div>
                </section>
            </div>
        </div>
        {{-- @if ( Auth::user()->isAbleTo("admin-clinic-personal-list") ) 
            <div class="row">
                <div class="col">
                    <section class="card card-featured-top card-featured-primary">
                        <header class="card-header">
                            <div class="card-actions">
                                <a href="#" class="card-action card-action-toggle" data-card-toggle=""></a>
                                <a href="#" class="card-action card-action-dismiss" data-card-dismiss=""></a>
                            </div>

                            <h2 class="card-title">{!! trans('general/admin_lang.exports') !!}</h2>
                        </header>
                    
                        <div class="card-body">  
                            <div class="row">
                                <div class="col-12 ">
                                    <a href="{{ url('admin/clinic-personal/export-excel') }}" class="text-success">
                                        <i class="far fa-file-excel fa-4x"></i>
                                    </a>
                                </div>
                            </div>                       
                        </div>
                    </section>
                </div>
            </div>
        @endif --}}
    <!-- end: page -->
</section>   
@endsection
@section('foot_page')
<!-- DataTables -->
<script src="{{ asset('/assets/admin/vendor/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/assets/admin/vendor/datatables.net/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('/assets/admin/vendor/datatables.net/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('/assets/admin/vendor/datatables.net/js/responsive.bootstrap4.min.js') }}"></script>

<script>
    $(document).ready(function() {
        $('.select2').select2();
      
    });
    var oTable = '';
    @if ( Auth::user()->isAbleTo("admin-clinic-personal-list") )    
        $(function() {
            oTable = $('#table_clinic-personal').DataTable({
                "stateSave": true,
                "stateDuration": 60,
                "processing": true,
                "serverSide": true,
                "pageLength": 50,
                "responsive": true,
                ajax: {
                    "headers": {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    url: "{{ url('admin/clinic-personal/list') }}",
                    type: "POST"
                },
            /* order: [
                    [2, "asc"]
                ],*/
                columns: [
                  
                    {
                        "title": "{!! trans('clinic-personal/admin_lang.fields.photo') !!}",
                        orderable: false,
                        searchable: false,
                        data: 'photo',
                        name: 'photo',
                        sWidth: '80px'
                    },
                    {
                        "title": "{!! trans('clinic-personal/admin_lang.fields.name') !!}",
                        orderable: true,
                        searchable: true,
                        data: 'fullname',
                        name: 'fullname',
                        sWidth: ''
                    },
                    {
                        "title": "{!! trans('clinic-personal/admin_lang.fields.phone') !!}",
                        orderable: true,
                        searchable: true,
                        data: 'phone',
                        name: 'user_profiles.phone',
                        sWidth: ''
                    },
                    {
                        "title": "{!! trans('clinic-personal/admin_lang.fields.email') !!}",
                        orderable: true,
                        searchable: true,
                        data: 'email',
                        name: 'users.email',
                        sWidth: ''
                    },
                    {
                        "title": "{!! trans('clinic-personal/admin_lang.fields.specialization_id') !!}",
                        orderable: false,
                        searchable: false,
                        data: 'specializations',
                        name: 'specializations',
                        sWidth: ''
                    },
                    
                    {
                        "title": "{!! trans('general/admin_lang.actions') !!}",
                        orderable: false,
                        searchable: false,
                        sWidth: '100px',
                        data: 'actions'
                    }

                ],
                "fnDrawCallback": function(oSettings) {
                    $('[data-bs-toggle="popover"]').mouseover(function() {
                        $(this).popover("show");
                    });

                    $('[data-bs-toggle="popover"]').mouseout(function() {
                        $(this).popover("hide");
                    });
                },
                oLanguage: {!! json_encode(trans('datatable/lang')) !!}

            });

            var state = oTable.state.loaded();
            $('tfoot th', $('#table_clinic-personal')).each(function(colIdx) {
                var title = $('tfoot th', $('#table_clinic-personal')).eq($(this).index()).text();
                if (oTable.settings()[0]['aoColumns'][$(this).index()]['bSearchable']) {
                    var defecto = "";
                    if (state) defecto = state.columns[colIdx].search.search;

                    $(this).html(
                        '<input style="width: 99.9%" type="text" class="form-control input-small input-inline" placeholder="' +
                        oTable.context[0].aoColumns[colIdx].title + ' ' + title + '" value="' +
                        defecto + '" />');
                }
            });

            $('#table_clinic-personal').on('keyup change', 'tfoot input', function(e) {
                oTable
                    .column($(this).parent().index() + ':visible')
                    .search(this.value)
                    .draw();
            });

        });    
   
    @endif 
   
   
   
</script>

@stop