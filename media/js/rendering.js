
var tplData = Array();
var i = 0;

function renderObj(href,type,target,replace)
{
	console.log('Render Obj Target: '+target);
	if (replace) $(target).html('');
	var hrefqs = getURLParams(href);
	getDataFor(target,type,hrefqs[hrefqs['type']+'_id'],hrefqs['from'],hrefqs[hrefqs['from']+'_id']);
} 

function getDataFor(into,type,type_id,from,from_id)
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
		$(data[type]).each(function(k,vars)
		{
			if (typeof tplData[type] == 'undefined')
			{
				tplData[type] = $.ajax({ url: 'media/templates/'+type+'_tpl.html', async: false }).responseText;
			}

			$(into).append(tplData[type]);

			$(into).find('#'+type).attr('id',type+'_id_'+vars.id);

			id = '#'+type+'_id_'+vars.id;
			query_id = type+'_id='+vars.id;

			$(id).parent().sortable(
			{
				connectWith: '#past',
				items: '.'+type+'_widget',
			});

			plugDataInto(into,id,query_id,vars)

		});
	});
}

function plugDataInto(into,id,query_id,vars)
{
	// Plug all my params into this .. thing ..
	jQuery.each(vars,function(className,classVal)
	{
		$(into).find(id+' .'+className).val(classVal);
		$(into).find(id+' .'+className).text(classVal);
	});
	
	// Append my id to all my href's in this section
	$(into).find(id+' a').each(function(k,v)
	{
		$(this).attr('href',$(this).attr('href') + '&'+query_id);
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
	getDataFor('#main','clients','1');

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
