	cache = new Array();

	function openboth(job_id)
	{
		alert(job_id);
	}

	function render(tpl,dat)
	{
		var rendered = '<em>'+tpl+': undefined</em>';
		var tpl_id = tpl.replace('.','_');

		if (typeof(cache[tpl_id]) == 'undefined')
		{
			$.ajaxSetup({cache:false, async:false});
			$.ajax({ 
				url: 'media/templates/'+tpl+'.html',
				dataType: 'html',
				success: function (data) 
				{ 
					cache [ tpl_id ] = data; 
				}
			});
		}

		rendered = $.jqote(cache[tpl_id],dat);

		return(rendered);
	}
	
	function removeWidget(id)
	{
		$(id).remove();
	}

    function renderObj(href,type,target,replace)
    {

        if (replace) $(target).html('');
		$.ajaxSetup({cache:false, async:false});

        t = $.getJSON(href,function(objData)
        {
			//console.log('Href: '+href+' Type: '+type+ ' Target: '+target);
			$('#'+target).html('');
			$.each(objData,function(objK,objV)
            {
				if (replace) $('#'+target).replaceWith(objV);
				else $('#'+target).append(objV);
            });

			$('#'+target).sortable(
			{
			//	containment: 'parent',
				connectWith: '#past',
				items: 'li.'+type+'_widget',
				/* axis: 'y', */
			});
			//$('li.'+type+'_widget').droppable({ greedy:true, hoverClass: 'ui-state-disabled'});
        });
    } 

	function refresh(obj)
	{
		if ($('#'+obj+' a:first').hasClass('ui-icon-triangle-1-e'))
		{
			$('#'+obj+' a:first').click();
		} 
		else
		{
			$('#'+obj+' a:first').click().click();
		}

	}

	function reveal(obj)
	{
		target	= $(obj).attr('target');
		href	= $(obj).attr('href');
		type	= $(obj).attr('name');

		//console.log(target);
		if($(obj).hasClass('ui-icon-triangle-1-e'))
		{
			renderObj(href,type,target,false);
		}
		$(obj).toggleClass('ui-icon-triangle-1-e ui-icon-triangle-1-s');
		$('#'+target).slideToggle();
	}

	function findFirstParentAttr(target,attr)
	{
		var first    = 0;
		var foundId    = '';
		t = $(target).parents().each(function()
		{
			if ($(this).attr(attr).length && first++ < 1) 
			{
				foundId = this.id;
				return(this.id);
			}
		});
		return(foundId);
	}

	$(function()
	{
		// Render the client widget objects
		renderObj('index.php?action=get&type=clients','clients','client-view');

		// Reveal the default clients
		reveal('.clients a.default');

		$('.openboth').live('click',function(e)
		{
			var job_id = $(this).attr('href').substr(1);
			var tmp		= $(this).clone();
			$(tmp).attr('href',"index.php?action=get&type=notes&from=jobs&id="+job_id);
			$(tmp).attr('target', "jobs_"+job_id+ ' .notes');
			$(tmp).attr('name',"notes");
			reveal($(tmp));

			var tmp		= $(this).clone();
			$(tmp).attr('href',"index.php?action=get&type=tasks&from=jobs&id="+job_id);
			$(tmp).attr('target',"jobs_"+job_id+ ' .tasks');
			$(tmp).attr('name',"tasks");
			reveal($(tmp));
			$(this).toggleClass('ui-icon-triangle-1-e ui-icon-triangle-1-s');
		});

		$('.show').live('click',function(e)
		{
			e.preventDefault();
			thisId = reveal(this);
		});

		$('ul').live('sortupdate',function(e,ui)
		{
			if (typeof $(this).children().attr('class') != 'undefined')
			{
				widget = $(this).children().attr('class').split('_');
				widget = widget[0];
				$.ajax({ url: 'index.php?action=sort&type='+widget,data : $(this).sortable('serialize') } );
			}
		});

		$('#archive').droppable(
		{
			tolerance : 'pointer',
			activeClass : "ui-state-active",
			hoverClass  : "ui-state-highlight",
			drop: function(event,ui)
			{
				uiid = ui.draggable.attr('id');
				dat = uiid.split('_');
				widget = dat[0];
				id = dat[1];
			//	$('#'+uiid).hide();
				$.ajax({ url: 'index.php?action=archive&type='+widget+'&id='+id, dataType: 'json', success: function(data)
				{
					if (data['func'].length) eval(data['func']);
				}})
			}
		});

	});
