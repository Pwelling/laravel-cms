@extends('layouts.app')

@section('content')
<div class="container">

	<div class="dd" id="domenu-0">
		<button class="dd-new-item">
			+
		</button>
		<li class="dd-item-blueprint">
			<button class="collapse" data-action="collapse" type="button" style="display: none;">–</button>
			<button class="expand" data-action="expand" type="button" style="display: none;">+</button>
			<div class="dd-handle dd3-handle"></div>
			<div class="dd3-content">
				<span class="item-name">[item_name]</span>
				<div class="dd-button-container">
					<button class="item-add">+</button>
					<button class="item-remove" data-confirm-class="item-remove-confirm">&times;</button>
				</div>
				<div class="dd-edit-box" style="display: none;">
					<input type="text" name="title" autocomplete="off" placeholder="Item"
						   data-placeholder="Hier moet een menutitel worden ingevoerd"
						   data-default-value="Item {?numeric.increment}" class="inputField">
					<select name="selectItem" class="selectItem">
						<option value="">Maak een keuze</option>
						@foreach ( \App\Helpers\MenuHelper::getMenuItemOptionsArray() as $optGroup => $groupOptions)
							<optgroup label="{{ $optGroup }}">
								@foreach($groupOptions as $groupOption)
									<option value="{{ $groupOption['value'] }}">{{ $groupOption['text'] }}</option>
								@endforeach
							</optgroup>
						@endforeach
					</select>
					<select name="selectTarget">
						<option value="self">Zelfde scherm</option>
						<option value="blank">Nieuw scherm</option>
					</select>
					<input type="text" name="url" style="display:none;"
						   data-placeholder="Hier moet een url worden ingevoerd" class="inputField" value="" />
					<i class="end-edit">save</i>
				</div>
			</div>
		</li>
		<ol class="dd-list"></ol>
		<div id="buttonContainer">
			<input type="button" class="btn btn-success" value="Opslaan" onclick="saveMenu();" />
			<input type="button" class="btn btn-danger" value="Annuleren" onclick="" />
		</div>
	</div>
</div>
@endsection

@section('footerscripts')
<script type="text/javascript" src="{{ asset('/js/jquery.domenu-0.95.77.min.js') }}"></script>
<script type="text/javascript">
$(document).ready(function() {
	$.ajax({
		url: '/getMenuItems',
		dataType: 'json'
	}).done(function(t){
		var items = JSON.stringify(t);
		$('#domenu-0').domenu({
            data : items,
            maxDepth: 2
        })
        .parseJson()
        .onItemAdded(function(item) {
            initShowHideUrlInput(item);
        });
        setTimeout(function() {
            $.each($('.dd-item'), function() {
                initShowHideUrlInput($(this));
                $(this).children('.dd3-content').children('.dd-edit-box').children('.selectItem').trigger('change');
            })
        }, 300);
	});
});

function initShowHideUrlInput(elm) {
    elm.children('.dd3-content').children('.dd-edit-box').children('.selectItem').change(function(){
        if ($(this).val() == '3|0') {
            $($(this).parent().children('input[name=url]').first()).show();
        } else {
            $($(this).parent().children('input[name=url]').first()).hide();
        }
    });
}

function saveMenu(){
	var container = $('#domenu-0 > .dd-list');
	var hoofdItems = container.children('li');
	$.ajax({
		url : '/saveMenu',
		data : {
			_token: '{{ csrf_token() }}',
			menuItems : getItems(hoofdItems),
		},
		dataType : 'json',
		method : 'post'
	}).done(function(data) {
		if (data.error) {
            console.log('fout');
        } else {
            window.location = window.location;
		}
	});
	hoofdItems = null;
	container = null;
}

function getItems(elm) {
    var _return = [];
    $.each(elm, function() {
        var contentBox = $(this).children('div .dd3-content').first();
        var editBox = $(contentBox).children('.dd-edit-box').first();
        var menuTerm = $($(editBox).children('input[name=title]').first()).val();
        var chosenItem = $($(editBox).children('select[name=selectItem]').first()).val();
        var itemUrl = $($(editBox).children('input[name=url]').first()).val();
        var itemTarget = $($(editBox).children('select[name=selectTarget]').first()).val();
        var childElms = false;
        if ($(this).children('.dd-list').length) {
            childElms = getItems($(this).children('.dd-list').children('li'));
        }
        var item = {
            term : menuTerm,
            chosenItem : chosenItem,
            url : itemUrl,
            target : itemTarget
        };
        if (childElms) {
            item.children = childElms;
        }
        _return[_return.length] = item;
        contentBox = null;
        editBox = null;
        menuTerm = null;
        chosenItem = null;
        itemUrl = null;
        childElms = null;
        itemTarget = null;
    });
    return _return;
}

</script>
@endsection

@section('extraCss')
<link rel="stylesheet" type="text/css" href="{{ asset('css/jquery.domenu-0.95.77.css') }}"/>
@endsection
