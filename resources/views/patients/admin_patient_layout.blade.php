@extends('layouts.admin.default')
@section('title')
    @parent {{ $pageTitle }}
@stop
@section('head_page')
<link href="{{ asset('/assets/admin/vendor/jquery-bonsai/css/jquery.bonsai.css')}}" rel="stylesheet" />
@yield('tab_head')

@stop

@section('breadcrumb')
<li><a href="{{ url('admin/patients') }}">{{ $title }}</a></li>
@yield('tab_breadcrumb')
@stop

@section('content')
@php
$disabled= isset($disabled)?$disabled : null;
@endphp
<section role="main" class="content-body card-margin">      
    <div class="mt-2">
         @include('layouts.admin.includes.modals')
      
        @include('layouts.admin.includes.errors')   
    </div>
   @if (!empty( $patient->id))
        <div class="row">
            <div class="col-12 text-end">
                <h3> <span class="badge badge-primary p-2"><b>{{ $patient->UserProfile->fullName }}</b></span></h3>
            </div>
        </div>
    @else
        <div class="col-12 mb-5"></div>
    @endif

    <div class="row mt-2">
        @if (!empty( $patient->id) && !isset($notImage))
            <div class="col-12 col-md-3 mb-3">
                <section class="card">
                
                    <div class="card-body">
                        
                        <div class="thumb-info mb-3">
                            <div id="fileOutput">
                                @if($patient->userProfile->photo!='')
                                    <img src='{{ url('admin/patients/get-image/'.$patient->userProfile->photo) }}' id='image_ouptup' class="rounded img-fluid" alt="{{$patient->userProfile->photo}}">
                                @else                                
                                    <img src="{{ asset("/assets/front/img/!logged-user.jpg") }}" class="rounded img-fluid" alt="image">
                                @endif
                            </div>   
                            <div class="thumb-info-title">
                                <span class="thumb-info-inner">{{  $patient->UserProfile->fullName}}</span>
                                <span class="thumb-info-type"> {{ implode(",", $patient->roles->pluck('display_name')->toArray()) }}</span>
                            </div>                         
                        </div>

                        @if (!$disabled && Auth::user()->isAbleTo("admin-patients-update")  && isset($deleteImage))                                
                                <div id="remove" onclick="deleteElement()" class="text-danger" style="@if($patient->userProfile->photo=='') display: none; @endif cursor: pointer; text-align: center;"><i class="fa fa-times" aria-hidden="true"></i> {{ trans('profile/admin_lang.quit_image') }} </div>                                          
                        @endif


                        <hr class="dotted short">
    
                        <h5 class="mb-2 mt-3">  {{ trans('profile/admin_lang.acerca_de') }}</h5>
                        <p class="text-2">
                            {{ trans('profile/admin_lang.registered_at') }} {{ $patient->createdAtFormatted }}
                        </p>
                      
                    </div>
                </section>
            </div>
        @endif
        <div class="col-12   @if (!empty( $patient->id)  && !isset($notImage))col-md-9 @endif">
            <div class="tabs tabs-primary">
                <ul class="nav nav-tabs" id="custom-tabs">
            
                    <li class="nav-item @if ($tab == 'tab_1') active @endif">
                        @if(Auth::user()->isAbleTo("admin-patients-update"))
                            <a id="tab_1" class="nav-link" data-bs-target="#tab_1-1" data-bs-toggle="tabajax"
                                href="{{ !empty($patient->id) ? url('admin/patients/' . $patient->id . '/edit') : '#' }}"
                                data-target="#tab_1-1" aria-controls="tab_1-1" aria-selected="true">
                                {{ trans('patients/admin_lang.general_info') }}
                            </a>  
                        @elseif(Auth::user()->isAbleTo("admin-patients-read"))
                            <a id="tab_1" class="nav-link" data-bs-target="#tab_1-1" data-bs-toggle="tabajax"
                                href="{{ !empty($patient->id) ? url('admin/patients/' . $patient->id . '/show') : '#' }}"
                                data-target="#tab_1-1" aria-controls="tab_1-1" aria-selected="true">
                                {{ trans('patients/admin_lang.general_info') }}
                            </a>  
                        @endif
                    </li>
                    
                    @if (!empty($patient->id))
                        @if(  Auth::user()->isAbleTo("admin-patients-clinic-record-update") || Auth::user()->isAbleTo("admin-patients-clinic-record-read"))
                            <li class="nav-item @if ($tab == 'tab_2') active @endif">
                                <a id="tab_2" class="nav-link" data-bs-target="#tab_2-2"
                                data-bs-toggle="tabajax" href="{{ url('admin/patients/clinical-record/'.$patient->id.'/edit') }}" data-target="#tab_2-2"
                                aria-controls="tab_2-2" aria-selected="true" >
                                {{ trans('patients/admin_lang.clinic_record') }}
                                </a>
                            
                            </li>
                        @endif                   
                        @if(  Auth::user()->isAbleTo("admin-patients-insurance-carriers-update") || Auth::user()->isAbleTo("admin-patients-insurance-carriers-read"))
                            <li class="nav-item @if ($tab == 'tab_3') active @endif">
                                <a id="tab_3" class="nav-link" data-bs-target="#tab_3-3"
                                data-bs-toggle="tabajax" href="{{ url('admin/patients/insurance-carriers/'.$patient->id.'/edit') }}" data-target="#tab_3-3"
                                aria-controls="tab_3-3" aria-selected="true" >
                                {{ trans('patients/admin_lang.insurance_carriers') }}
                                </a>
                            
                            </li>
                        @endif                   
                        @if(  Auth::user()->isAbleTo("admin-patients-medicines-update") || Auth::user()->isAbleTo("admin-patients-medicines-read"))
                            <li class="nav-item @if ($tab == 'tab_4') active @endif">
                                <a id="tab_4" class="nav-link" data-bs-target="#tab_4-4"
                                data-bs-toggle="tabajax" href="{{ url('admin/patients/'.$patient->id.'/medicines') }}" data-target="#tab_4-4"
                                aria-controls="tab_4-4" aria-selected="true" >
                                {{ trans('patient-medicines/admin_lang.patient-medicines') }}
                                </a>
                            
                            </li>
                        @endif                   
                        @if(  Auth::user()->isAbleTo("admin-patients-medical-studies-update") || Auth::user()->isAbleTo("admin-patients-medical-studies-read"))
                            <li class="nav-item @if ($tab == 'tab_5') active @endif">
                                <a id="tab_5" class="nav-link" data-bs-target="#tab_5-5"
                                data-bs-toggle="tabajax" href="{{ url('admin/patients/'.$patient->id.'/medical-studies') }}" data-target="#tab_5-5"
                                aria-controls="tab_5-5" aria-selected="true" >
                                {{ trans('patient-medical-studies/admin_lang.patient-medical-studies') }}
                                </a>
                            
                            </li>
                        @endif                   
                        @if(  Auth::user()->isAbleTo("admin-patients-monitoring-update") || Auth::user()->isAbleTo("admin-patients-monitoring-read"))
                            <li class="nav-item @if ($tab == 'tab_6') active @endif">
                                <a id="tab_6" class="nav-link" data-bs-target="#tab_6-6"
                                data-bs-toggle="tabajax" href="{{ url('admin/patients/'.$patient->id.'/monitorings') }}" data-target="#tab_6-6"
                                aria-controls="tab_6-6" aria-selected="true" >
                                {{ trans('patient-monitorings/admin_lang.patient-monitorings') }}
                                </a>
                            
                            </li>
                        @endif        
                    @endif           
                </ul>
                <div class="tab-content" id="tab_tabContent">
                    <div id="tab_1-1" class="tab-pane @if ($tab == 'tab_1') active @endif">
            
                        @yield('tab_content_1')
                    </div>
                    @if (!empty($patient->id))
                        <div id="tab_2-2" class="tab-pane @if ($tab == 'tab_2') active @endif">
                
                            @yield('tab_content_2')
                        </div>
                        <div id="tab_3-3" class="tab-pane @if ($tab == 'tab_3') active @endif">
                
                            @yield('tab_content_3')
                        </div>
                        <div id="tab_4-4" class="tab-pane @if ($tab == 'tab_4') active @endif">
                
                            @yield('tab_content_4')
                        </div>
                        <div id="tab_5-5" class="tab-pane @if ($tab == 'tab_5') active @endif">
                
                            @yield('tab_content_5')
                        </div>
                        <div id="tab_6-6" class="tab-pane @if ($tab == 'tab_6') active @endif">
                
                            @yield('tab_content_6')
                        </div>
                    @endif
                 
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('foot_page')
<script>
    $(document).ready(function() {
      
    });
    function deleteElement() {
        @if(empty($patient->userProfile->photo))
        $('#fileOutput').html('<img src="{{ asset("/assets/front/img/!logged-user.jpg") }}" class="rounded img-fluid" alt="{{ Auth::user()->userProfile->fullName }}">');
        $("#remove").css("display","none");
        $('#nombrefichero').val("");
        $('#center_image').val("");
        return false;
        @endif
        var strBtn = "";
        $("#confirmModalLabel").html("{{ trans('general/admin_lang.delete') }}");
        $("#confirmModalBody").html("<div class='d-flex align-items-center'><i class='fas fa-question-circle text-success' style='font-size: 64px; float: left; margin-right:15px;'></i><label class='text-primary' style='font-size: 18px'>{{ trans('general/admin_lang.delete_question_image') }}</label></div>");
        strBtn+= '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ trans('general/admin_lang.close') }}</button>';
        strBtn+= '<button type="button" class="btn btn-primary" onclick="javascript:deleteinfo();">{{ trans('general/admin_lang.yes_delete') }}</button>';
        $("#confirmModalFooter").html(strBtn);
        $('#modal_confirm').modal('toggle');
    }

    function deleteinfo() {

        $.ajax({
            url     : "{{ url('admin/patients/delete-image/'.$patient->id) }}",
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
      
                      $('#fileOutput').html('<img src="{{ asset("/assets/front/img/!logged-user.jpg") }}" class="rounded img-fluid" alt="{{ Auth::user()->userProfile->fullName }}">');
                         $("#remove").css("display","none");
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

@yield('tab_foot')
@stop

