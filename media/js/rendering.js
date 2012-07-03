
var tplData = Array();
var i = 0;

function renderObj(href,type,target,replace)
{
	//console.log('Render Obj Target: '+target+' Type:'+type);
	//if (replace) $('#'+type+'_id_'+replace).hide('fade');
	var hrefqs = getURLParams(href);
	getDataFor(target,type,hrefqs[hrefqs['type']+'_id'],hrefqs['from'],hrefqs[hrefqs['from']+'_id'],replace);
} 

function getDataFor(into,type,type_id,from,from_id,replace)
{
/*
	console.log(into);
	console.log(type);
	console.log(type_id);
	console.log(from);
	console.log(from_id);
*/

	url = '';
	if (typeof from != 'undefined' && from.length) 
	{
		url+='from='+from+'&';
		if (typeof from_id != 'undefined') url+=from+'_id='+from_id+'&';
	}
	if (typeof type != 'undefined' && type.length) 
	{
		url+='type='+type+'&';
		if (typeof type_id != 'undefined') url+=type+'_id='+type_id+'&';
	}

	$.getJSON('index.php?action=get&'+url+'&r=json',function(data,ui)
	{
		if (data != null)
		{
			// If we actually have data of 'type' 
			if (typeof data[type] != 'undefined')
			{
				// Load up the template if we need
				if (typeof tplData[type] == 'undefined')
				{
					tplData[type] = $.ajax({ url: 'index.php?l=none&page='+type+'_tpl', async: false }).responseText;
				}
				jQuery.each(data[type],function(k,vars)
				{

					if (!replace) $(into).append(tplData[type]);

					$(into).find('#' + type).attr('id',type + '_id_' + vars.id);

					id			= '#' + type + '_id_' + vars.id;
					query_id	= type + '_id=' + vars.id;

					$(id).parent().sortable(
					{
						connectWith: '#past',
						items: '.'+type+'_widget'
					});
					plugDataInto(into,id,query_id,vars);
					if (replace) $('#'+type+'_id_'+vars.id).effect('pulsate', { times: 3},250);
				});
			}
		}
	});
}

function plugDataInto(into,id,query_id,vars)
{
	//console.log('Into: '+into);
	// Parent id wrangling
	parent_id = (into.substr(1,into.length));
	widgets = parent_id.split(' ');
	parent_widget = widgets[0].split('_');
	
	//console.log('Into: '+into+" Widgets: "+widgets[0]+' '+widgets[1]+' Parent Id: '+parent_widget[0]);
	if (typeof parent_widget[2] != 'undefined') 
	{
		vars[parent_widget[0]+'_id'] = parent_widget[2];
        query_id = query_id + '&from='+parent_widget[0]+'&'+parent_widget[0]+'_id='+parent_widget[2]
	}
	// Plug all my params into this .. thing ..
	jQuery.each(vars,function(className,classVal)
	{
		//console.log("Class: "+className+' = '+classVal);
		$(into).find(id+' .'+className+':first').val(classVal);
		$(into).find(id+' .'+className+':first').html(classVal);
		// In case we have a hidden field (probably set showhidden class or something)
		if (classVal != null && typeof classVal != 'undefined' && classVal.length) 
		{
			if (className != 'content') 
			{
				// Show my labels
				$(id + ' label[for="'+className+'"]').show();
				$(into).find(id+' .'+className+':first').show().parent().show();
			}
		}
	});
	
	// Append my id to all my href's in this section
	$(into).find(id+' a.openboth:first,'+id+' .editHandler').each(function(k,v)
	{
		$(this).attr('href',$(this).attr('href') + '&'+query_id);
		//console.log('Appending ids: '+v  + ' ' + query_id);
	});
}

function getURLParams(aURL)
{
	var responseObj = {};
	if (aURL.indexOf('?') > -1) {
		var argArray = aURL.substr(aURL.indexOf('?') + 1).split('&');
		var key, val;
		var safeRe = /^([0-9]{1,}|true|false)$/i;
		var quoteRe = /'/g;
		for (var i = 0; i < argArray.length; i++) {
			key = '';
			val = '';
			if (argArray[i].indexOf('=') > -1) {
				key = argArray[i].substr(0, argArray[i].indexOf('='));
				val = argArray[i].substr(argArray[i].indexOf('=') + 1);
				val = unescape(val);
			} else {
				key = argArray[i];
			}
			responseObj[key] = val;
		}
	}
	return responseObj;
}

function removeWidget(id)
{
	$(id).remove();
}


$(document).ready(function()
{
	getDataFor('#main_clients','clients','1');

	$('.sortable').live('sortupdate',function(e,ui)
	{
		if (typeof $(this).children().attr('class') != 'undefined')
		{
			widget = $(this).children().attr('class').split('_');
			widget = widget[0];
			$.ajax({ url: 'index.php?action=sort&type='+widget,data : $(this).sortable('serialize') } );
		}
	});

	$('.openboth').live('click',function(e)
	{
		e.preventDefault();
		obj = $(this);
		var hrefqs = getURLParams($(obj).attr('href'));
		var job_id = hrefqs['jobs_id'];

		if ($(obj).hasClass('ui-icon-triangle-1-e'))
		{
			getDataFor('#jobs_id_'+job_id+ ' .notes','notes','','jobs',job_id);
			getDataFor('#jobs_id_'+job_id+ ' .tasks','tasks','','jobs',job_id);
		}
		else
		{
			jid = $(obj).closest('.top').attr('id');
			$('#'+jid+' .notes_widget,#'+jid+' .tasks_widget').remove();
		}
		$(this).toggleClass('ui-icon-triangle-1-e ui-icon-triangle-1-s');
	}); 

});
