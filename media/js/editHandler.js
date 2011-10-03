	$(function() { attachEditHandler(); });

	function postForm(obj,url)
	{
		$.get(url,$(obj).serialize(),function(data)
		{
			if (data['func'] != undefined) eval(data['func']);
		},'json');
	}

	function addEditDialog(obj)
	{
		$.getJSON($(obj).attr('href') + '&r=form',function(d)
		{
			$("#dialog").html(unescape(d['editForm'])).dialog(
			{
				width:d['width'],height:d['height'],modal: false,resizable:false,draggable:true, title: d['title'],autoOpen: true,buttons: 
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
			addEditDialog($(this));
		});
	}
