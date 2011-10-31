	$(function() { attachEditHandler(); });

	function postForm(obj,url)
	{
		$.get(url,$(obj).serialize(),function(data)
		{
			if (data['func'] != undefined) eval(data['func']);
		},'json');
	}

	function addEditDialog(obj,top_id)
	{
		var d = { title : '' };

		params = getURLParams(obj.attr('href'));

		type	= params.type;
		type_id = params[type+'_id'];


		if (typeof top_id != 'undefined') parentData	= top_id.split('_');

		if (typeof tplData['edit'+type] == 'undefined')
		{
			tplData['edit'+type] = $.ajax({ url: 'index.php?l=none&page=edit'+type+'_tpl', async: false }).responseText;
		} 

		$.getJSON($(obj).attr('href')+'&r=json',function(data)
		{

			if (data != null) 
			{
				d = data[type][0];
				d_title = d['title'];
			}
			else d_title = 'Create '+type;

			if (typeof parentData != 'undefined') 
			{
				if (typeof params.from !='undefined')
				{
					from	= params.from;
					from_id = params[from+'_id'];
					d[from+'_id'] = from_id;
				}
				parentType	= parentData[0];
				parentId	= parentData[2];
				d[parentType+'_id'] = (parentId > 0) ? parentId : 'x';
			}

			$("#dialog").html(tplData['edit'+type]).dialog(
			{
				width:600,height:600,modal: false,resizable:false,draggable:true, title: d_title,autoOpen: true,buttons: 
				{ 
					"OK": function() 
					{ 
						if ($('#editForm').length)
						{
							$.get('index.php',$('#editForm').serialize()+'&r=json',function(data)
							{
								if (data != null)
								{
									if (typeof data['func'] != 'undefined' && data['func'] != null) eval(data['func']);
								}
							},'json');
						}
						$(this).dialog("close");  
					}, 
					"Cancel": function() 
					{ 
						$(this).dialog('close'); 
					}
				}
			});
			plugDataInto('#dialog','#editForm','',d);
			
		});
	}

	function updateHandler(id,data)
	{
		$.each(data,function(idx,d)
		{
			$(id+' .'+idx).html(d);
		});
	}

	function attachEditHandler()
	{
		$('a.editHandler').live('click',function(event)
		{
			event.preventDefault();
			addEditDialog($(this),$(this).closest('.top').attr('id'));
		});
	}
