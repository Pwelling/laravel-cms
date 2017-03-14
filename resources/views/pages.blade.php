@extends('layouts.app')

@section('content')
<div class="container">
	<meta name="csrf_token" content="{{ csrf_token() }}" />
	<h1>Paginas <a href="/newPage" class="a-float-right"><i class="fa fa-plus" aria-hidden="true"></i></a></h1>
	@if (count($groups) > 0)
		<table class="table table-hover">
			<tbody>
				@foreach ($groups as $group)
					<tr class="groupRow" onclick="showHidePageGroup('group{{$group->id}}');">
						<td class="nameCol" width="400">{{ $group->name }} ({{ count($group->pages)}})</td>
					</tr>
					@if( count($group->pages) > 0)
						<tr id="group{{$group->id}}" class="pageRow" style="display:none;">
							<td>
								<table class="table table-hover">
									<thead>
										<tr>
											<th width="300">Naam</th>
											<th width="100">Bewerk</th>
											<th width="100">Verwijder</th>
										</tr>
									</thead>
									<tbody>
										{{-- */ $i=0; /* --}}
										@foreach ($group->pages as $page)
											<tr class="@if($i++%2 == 0)even @else oneven @endif">
												<td><a href="/page/{{ $page->seo }}">{{ $page->title }}</a></td>
												<td><a href="/page/{{ $page->seo }}"><i class="fa fa-pencil" aria-hidden="true"></i></a></td>
												<td><a onclick="removePage('{{ $page->id }}');"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
											</tr>
										@endforeach
									</tbody>
								</table>
							</td>
						</tr>
					@endif
				@endforeach
			</tbody>
		</table>
	@endif
</div>	
@endsection

@section('footerscripts')
<script type="text/javascript" src="{{ asset('/js/functions.js') }}"></script>
@endsection