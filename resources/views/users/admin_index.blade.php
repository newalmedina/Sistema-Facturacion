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
            <form id="formData" enctype="multipart/form-data" action=" {{ route("admin.users.saveFilter") }}" method="post"  novalidate="false">
                @csrf
                @method("post")
            <section class="card card-featured-top card-featured-primary">
                <header class="card-header">
                    <div class="card-actions">
                        <a href="#" class="card-action card-action-toggle" data-card-toggle=""></a>
                        <a href="#" class="card-action card-action-dismiss" data-card-dismiss=""></a>
                    </div>
                    <h2 class="card-title">{!! trans('general/admin_lang.filters') !!}</h2>
                </header>
            
                <div class="card-body py-4">  
                    <div class="row">
                        <div class="col-12  col-md-6">                     
                            <div class="form-group">
                                <label class='text-primary' for="role_id" class="col-12" > {{ trans('users/admin_lang.fields.roles') }}</label>
                                <select class="form-control select2 col-12" style="width: 100%" name="role_id[]" multiple id="role_id">
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}"         @if (in_array($role->id,$filtRoleId)) selected @endif >{{ $role->name }}</option>
                                    @endforeach 
                                </select>    
                            </div>
                        </div>   
                        <div class="col-12  col-md-6">                     
                            <div class="form-group">
                                <label class='text-primary' for="center_id" class="col-12" > {{ trans('users/admin_lang.fields.centers') }}</label>
                                <select class="form-control select2 col-12" style="width: 100%" name="center_id[]" multiple id="center_id">
                                    @foreach ($centers as $center)
                                        <option value="{{ $center->id }}"         @if (in_array($center->id,$filtCenterId)) selected @endif >{{ $center->name }}</option>
                                    @endforeach 
                                </select>    
                            </div>
                        </div>   
                       
                    </div>                       
                </div>
                <div class="card-footer">  
                    <div class="row ">
                        <div class="col-12 col-md-6 d-flex justify-content-start">
                            <button class="btn btn-primary btn-xs " type="submit"> {!! trans('general/admin_lang.filter') !!}</button>
                            <a href="{{ url('admin/users/remove-filter') }}" class="ms-2 btn btn-danger btn-xs">
                                {!! trans('general/admin_lang.clean_filter') !!}
                            </a>
                        </div>
                        {{-- @if ( Auth::user()->isAbleTo("admin-clinic-personal-list") ) 
                        <div class="col-12 col-md-6 d-flex justify-content-end">
                            <a href="{{ url('admin/clinic-personal/export-excel') }}" class="text-success">
                                <i class="far fa-file-excel fa-2x"></i>
                            </a>
                        </div>
                        @endif --}}
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
                    <div class="card-body">  
                        <div class="text-end">
                            @if(Auth::user()->isAbleTo("admin-users-create"))
                              <a href="{{ url('admin/users/create') }}" class="btn btn-outline-success">
                                {{ trans('users/admin_lang.new') }}
                              </a>
                            @endif
                          </div>
                    </div>

                    <div class="card-body">  
                        <div class="row">
                            <div class="col-12 table-responsive">
                                @if ( Auth::user()->isAbleTo("admin-users-list") ) 
                                    <table id="table_users" class="table table-bordered table-striped" aria-hidden="true">
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
        
    $(function() {
        oTable = $('#table_users').DataTable({
            "stateSave": true,
            "stateDuration": 60,
            "processing": true,
            "serverSide": true,
            "pageLength": 50,
            ajax: {
                "headers": {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                url: "{{ url('admin/users/list') }}",
                type: "POST"
            },
           /* order: [
                [2, "asc"]
            ],*/
            columns: [
                {
                    "title": "{!! trans('general/admin_lang.active') !!}",
                    orderable: false,
                    searchable: false,
                    data: 'active',
                    name: 'active',
                    sWidth: '80px'
                },
                {
                    "title": "{!! trans('users/admin_lang.fields.first_name') !!}",
                    orderable: true,
                    searchable: true,
                    data: 'fullname',
                    name: 'fullname',
                    sWidth: ''
                },
                
                {
                    "title": "{!! trans('users/admin_lang.fields.email') !!}",
                    orderable: true,
                    searchable: true,
                    data: 'email',
                    name: 'users.email',
                    sWidth: ''
                },
                {
                    "title": "{!! trans('users/admin_lang.centers') !!}",
                    orderable: false,
                    searchable: false,
                    data: 'centers'
                },
                {
                    "title": "{!! trans('users/admin_lang.fields.roles') !!}",
                    orderable: false,
                    searchable: false,
                    data: 'roles',
                    name: 'roles',
                    sWidth: ''
                },
                {
                    "title": "{!! trans('general/admin_lang.actions') !!}",
                    orderable: false,
                    searchable: false,
                    sWidth: '130px',
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
        $('tfoot th', $('#table_users')).each(function(colIdx) {
            var title = $('tfoot th', $('#table_users')).eq($(this).index()).text();
            if (oTable.settings()[0]['aoColumns'][$(this).index()]['bSearchable']) {
                var defecto = "";
                if (state) defecto = state.columns[colIdx].search.search;

                $(this).html(
                    '<input type="text" class="form-control input-small input-inline" placeholder="' +
                    oTable.context[0].aoColumns[colIdx].title + ' ' + title + '" value="' +
                    defecto + '" />');
            }
        });

        $('#table_users').on('keyup change', 'tfoot input', function(e) {
            oTable
                .column($(this).parent().index() + ':visible')
                .search(this.value)
                .draw();
        });

    });

    function changeState(id){
        $.ajax({
            url     : "{{ url('admin/users/change-state/') }}/"+id,
            type    : 'GET',
            success : function(data) {
                console.log("estado actalizado");           
            },
            error : function(data) {
                console.log("Error al actualizar "+error);           
            }
        });
    }

    // function deleteElement(url) {
    //     var strBtn = "";

    //     $("#confirmModalLabel").html("{{ trans('general/admin_lang.delete') }}");
    //     $("#confirmModalBody").html("<div class='d-flex align-items-center'><i class='fas fa-question-circle text-success' style='font-size: 64px; float: left; margin-right:15px;'></i><label class='text-primary' style='font-size: 18px'>{{ trans('general/admin_lang.delete_question') }}</label></div>");
    //     strBtn+= '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ trans('general/admin_lang.close') }}</button>';
    //     strBtn+= '<button type="button" class="btn btn-primary" onclick="javascript:deleteinfo(\''+url+'\');">{{ trans('general/admin_lang.yes_delete') }}</button>';
    //     $("#confirmModalFooter").html(strBtn);
    //     $('#modal_confirm').modal('toggle');
    // }


    function deleteElement(url) {
        Swal.fire({
        title: "{{ trans('general/admin_lang.delete') }}",
        text: 'Esta acción no se puede deshacer',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: "{{ trans('general/admin_lang.yes_delete') }}",
        cancelButtonText: "{{ trans('general/admin_lang.close') }}"
        }).then((result) => {
            if (result.isConfirmed) {
                deleteinfo(url);
            }
        });
    }

    function deleteinfo(url) {
        $.ajax({
            url     : url,
            type    : 'POST',
            "headers": {"X-CSRF-TOKEN": "{{ csrf_token() }}"},
            data: {_method: 'delete'},
            success : function(data) {
                $('#modal_confirm').modal('hide');
                if(data) {
                    // $("#modal_alert").addClass('modal-success');
                    // $("#alertModalHeader").html("{{ trans('general/admin_lang.warning') }}");
                    // $("#alertModalBody").html("<div class='d-flex align-items-center'><i class='fas fa-check-circle text-success' style='font-size: 64px; float: left; margin-right:15px;'></i> <label class='text-primary' style='font-size: 18px'>" + data.msg+"</label></div>");
                    // $("#modal_alert").modal('toggle');
                    toastr.success( data.msg)
                    oTable.ajax.reload(null, false);
                } else {
                    $("#modal_alert").addClass('modal-danger');
                    $("#alertModalBody").html("<i class='fas fa-bug text-danger' style='font-size: 64px; float: left; margin-right:15px;'></i> {{ trans('general/admin_lang.errorajax') }}");
                    $("#modal_alert").modal('toggle');
                }
                return false;
            }

        });
        return false;
    }
</script>

@stop