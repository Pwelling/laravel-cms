@extends('layouts.app')

@section('content')
<div class="container">
	<meta name="csrf_token" content="{{ csrf_token() }}" />
    <h1><a href="/newGroup" class="a-float-right"><i class="fa fa-plus" aria-hidden="true"></i></a> Groepen </h1>
    @if (count($groups) > 0)
		<table class="table table-hover">
			<thead>
				<tr>
					<th class="nameCol">Naam</th>
					<th class="bewerkCol">Bewerken</th>
					<th class="bewerkCol">Verwijder</th>
				</tr>
			</thead>
			<tbody>
				{{-- */ $i=0; /* --}}
				@foreach ($groups as $group)
					<tr class="">
						<td class="nameCol"><a href="/group/{{ $group->slug }}">{{ $group->name }}</a></td>
						<td class="bewerkCol"><a href="/group/{{ $group->slug }}"><i class="fa fa-pencil" aria-hidden="true"></i></a></td>
						<td class="bewerkCol"><a onclick="checkRemoveGroup({{ $group->id }});"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
					</tr>
				@endforeach
			</tbody>
		</table>
	@endif
</div>	
@endsection

@section('footerscripts')
<script type="text/javascript" src="{{ asset('/js/functions.js') }}"></script>
@endsection