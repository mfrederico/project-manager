	$(function() { 
		attachEditHandler(); 
	});

	function postForm(obj,url)
	{
		$.get(url,$(obj).serialize(),function(data)
		{
			if (data['func'] != undefined) eval(data['func']);
		},'json');
	}

	function addTinyMCE()
	{
		$('textarea.content').tinymce({
			// Location of TinyMCE script
			script_url : 'media/js/tinymce/jscripts/tiny_mce/tiny_mce.js',

			// General options
			theme : "advanced",
			plugins : "lists,table,searchreplace,advlist",
			mode	: "none",

			// Theme options
			theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|bullist,numlist,|,outdent,indent,|,link,unlink,|,justifyleft,justifycenter,justifyright,justifyfull,formatselect",
			theme_advanced_buttons2 : "",
			theme_advanced_buttons3 : "",
			theme_advanced_buttons4 : "",
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			theme_advanced_statusbar_location : "",
			theme_advanced_resizing : true,
		});
	}

	function removeTinyMCE () {
		tinyMCE.execCommand('mceFocus', false, 'tiny_mce');
		tinyMCE.execCommand('mceRemoveControl', false, 'tiny_mce');
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

			// Set our maximum dialog window width
			thisW = $(window).width() - 20;
			if (thisW  > 600) thisW = 600;

			thisH = $(window).height() - 100;

			$("#dialog").html(tplData['edit'+type]).dialog(
			{
				width:thisW,
				height:thisH,
				modal: true,
				resizable:false,
				draggable:true, 
				title: d_title,
				autoOpen: true,
				open: addTinyMCE,
				close: removeTinyMCE,
				buttons: 
				{ 
					"OK": function() 
					{ 
						if ($('#editForm').length)
						{
							$.post('index.php',$('#editForm').serialize()+'&r=json',function(data)
							{
								if (data != null)
								{
									// Potentially unsafe
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
