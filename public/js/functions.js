function checkRemoveGroup(gId) {
	$.ajax({
		url : '/checkGroupRemoval',
		data : {
			gId : gId,
			_token : $('meta[name="csrf_token"]').attr('content')
		},
		datatype : 'json',
		method : 'post'
	}).done(function(data) {
		if (data.result == true) {
			if (confirm('Weet je zeker dat je deze groep wilt verwijderen?')) {
				removeGroup(gId);
			}
		} else {
			alert('Deze groep kan niet verwijderd worden.Verplaats eerst de nog gekoppelde pagina\'s of verwijder deze.');
		}
	});
}

function removeGroup(gId) {
	$.ajax({
		url : '/removeGroup',
		data : {
			gId : gId,
			_token : $('meta[name="csrf_token"]').attr('content')
		},
		method : 'post'
	}).done(function() {
		window.location = window.location;
	});
}

function showHidePageGroup(pageR) {
	if($('#' + pageR).css('display') == 'none'){
		$('.pageRow').hide();
		$('#' + pageR).show();
	} else {
		$('#' + pageR).hide();
	}
}

function removePage(pId) {
	if(confirm('Weet u zeker dat u deze pagina wilt verwijderen?')){
		$.ajax({
		url : '/removePage',
		data : {
			pId : pId,
			_token : $('meta[name="csrf_token"]').attr('content')
		},
		method : 'post'
	}).done(function() {
		window.location = window.location;
	});
	}
}
