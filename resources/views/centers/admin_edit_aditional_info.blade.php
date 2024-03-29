@extends('centers.admin_centers_layout')


@section('tab_head')
   <style>
    .role-selected{
        cursor: pointer;
    }
   </style>
@stop

@section('tab_breadcrumb')
    <li class="breadcrumb-item active"><a href="#">{{ $pageTitle }}</a></li>
@stop

@section('tab_content_2')
@php
    $disabled= isset($disabled)?$disabled : null;
@endphp
<div class="row">
    
    <div class="col-12">
        <form id="formData" enctype="multipart/form-data" action="{{ route("admin.centers.updateAditionalInfo",$center->id) }}" method="post"  novalidate="false">
            @csrf 
             @method('patch') 
              
            <div class="card-body">
                <div class="row form-group mb-3">
                    <div class="col-12">
                     
                        <div class="form-group">
                            <label class='text-primary' for="schedule"> {{ trans('centers/admin_lang.fields.schedule') }}</label>
                            <input value="{{!empty($center->schedule) ? $center->schedule :null }}" type="text" {{ $disabled }}  class="form-control" name="schedule"  placeholder="{{ trans('centers/admin_lang.fields.schedule') }}">
                        </div>
                    </div>                                       
                </div>
                <div class="row form-group mb-3">
                    <div class="col-12">                     
                        <div class="form-group">
                            <label class='text-primary' for="name"> {{ trans('centers/admin_lang.fields.specialities') }}</label>
                            <textarea name="specialities" {{ $disabled }}  class="form-control" id="" cols="30" rows="10">{{ $center->specialities }}</textarea>
                            
                        </div>
                    </div>                                       
                </div>
                               
            </div>
            <div class="card-footer row">
                <div class="col-12  d-flex justify-content-between">

                    <a href="{{ url('admin/centers') }}" class="btn btn-default">{{ trans('general/admin_lang.back') }}</a>
                    
                    @if (empty( $disabled ))
                        <button type="submit" class="btn btn-primary">{{ trans('general/admin_lang.save') }}</button>   
                        
                    @endif 
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section("tab_foot")
<script>
    $(document).ready(function(){
    }); 

 
</script>
@stop