@extends('layouts.app')

@section('content')
@if (count($errors) > 0)
   <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif
<div class="container">
	
	@if(isset($page))
		{!! Form::model($page, array('route' => array('pageUpdate', $page->id))) !!}
	@else
		{!! Form::open(['route' => 'pageInsert']) !!}
	@endif
        <div class="form-group row">
            {!! Form::label('group_id', 'Groep', ['class' => 'col-sm-2 col-form-label']) !!}
            <div class="col-sm-10">
                {!! Form::select('group_id', $groups, null, ['class' => 'selectpicker']) !!}
            </div>
        </div>
        <div class="form-group row">
            {!! Form::label('title', 'Titel', ['class' => 'col-sm-2 col-form-label']) !!}
            <div class="col-sm-10">
                {!! Form::text('title') !!}
            </div>
        </div>
        <div class="form-group row">
            {!! Form::label('body', 'inhoud', ['class' => 'col-sm-2 col-form-label']) !!}
            <div class="col-sm-10">
                {!! Form::textarea('body') !!}
            </div>
        </div>
        <div class="form-group row">
            <div class="offset-sm-2 col-sm-10">
                {!! Form::submit('opslaan', array('class' => 'btn btn-success')) !!}
                {!! Form::button('annuleren',array('class' => 'btn btn-danger', 'onclick'=>'window.location=\'/pages\';')) !!}
            </div>
    	</div>
	{!! Form::close() !!}
</div>	
@endsection

@section('footerscripts')
<script type="text/javascript" src="{{ asset('/js/tinymce/tinymce.min.js') }}"></script>
<script type="text/javascript">
	$(function(){
		setTimeout(function(){
			$('.alert').hide();
		},5000);
	});
	tinymce.init({
		selector : "textarea",
		plugins : ["advlist autolink lists link image charmap print preview anchor", "searchreplace visualblocks code fullscreen", "insertdatetime media table contextmenu paste"],
		toolbar : "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
	}); 
</script>
@endsection
