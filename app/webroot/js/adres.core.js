var ADres={};
ADres.version=0.1;


ADres.AJAX={
	call:function(e){
		console.log('test');
	},
	selectImplementation:function(e){
		e.stopPropagation();
		e.preventDefault();
		var $select = $(this);
		var $form = $select.closest('form');
		var action = $form.attr('action')+'.json';
			
		$.ajax({
			url:action,
			dataType:'json',
			data:$form.serialize(),
			beforeSend:ADres.LOADER.enable,
			success:function(resp){
				if(resp.status){
					/*
						TODO have initiate ajax call like ODESK
					*/
				}
			},
			complete:ADres.AJAX.disable
		});
	},
	form_submit:function(e){
		e.stopPropagation();
		e.preventDefault();

		var $form = $(this);
		var action = $form.attr('action')+'.json';

		$.ajax({
			url:action,
			dataType:'json',
			data:$form.serialize(),
			beforeSend:ADres.LOADER.enable,
			success:function(resp){
				if(resp.status){
					
				}
			},
			complete:ADres.LOADER.disable
		});
	},
	link:function(e){
		e.stopPropagation();
		e.preventDefault();
		var $link = $(this);
		var action = $link.attr('href')+'.json';
		
		$.ajax({
			url:action,
			dataType:'json',
			beforeSend:ADres.LOADER.enable,
			success:function(resp){
				if(resp.status){
				}
			},
			complete:ADres.LOADER.disable
			
		});
	}
}


ADres.ERROR={
	call:function(e){
	}
}

ADres.LOADER={
	enable:function(){
		
	},
	disable:function(){
		
	}
}


jQuery(document).ready(function() {

	var ajax_options={
		beforeSend:ADres.LOADER.enable,
		complete:ADres.LOADER.disable
	};
	
	//$('.adres-link-ajax').bind('click',ADres.AJAX.call)
	$('.adres-ajax-implementation').bind('change',ADres.AJAX.selectImplementation);
	$('.adres-datagrid tr:even').addClass('zebra');
	$('.adres-ajax-form').bind('submit',ADres.AJAX.form_submit);
	$('.adres-ajax-anchor').live('click',ADres.AJAX.link);

	$('.adres-ajax-record-edit').bind('click',function(){
		var $edit_button = $(this);
		console.log($edit_button.closest('span.adres-attr'));
		return false;
	});
	
	$('#adres-tabs').tabs({
		load: function(event, ui) {
        	$('a.adres-tabs-button', ui.panel).click(function(e) {
        	$(ui.panel).load(this.href);
        	e.stopPropagation();
        	return false;
        });	}
	});
	
});