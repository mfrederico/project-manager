<?php

require("lib/rb.php");
R::setup();
class Model_Todo extends RedBean_SimpleModel {
	public function getList() {
		return R::findAndExport("todo");
	}
}
$beancan = new RedBean_BeanCan;
if (isset($_POST["json"])) die($beancan->handleJSONRequest( $_POST["json"] ));
?>
<html>
	<head><title>DEMO BEANCAN</title>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	</head>
	<body>
		
		<h1>My Todo List</h1>
		<ul class="list">
			<?php foreach(R::find("todo") as $todo): ?>
			<li><button todo="<?php echo $todo->id; ?>">DONE</button><?php echo $todo->description; ?></li>
			<?php endforeach; ?>
		</ul>
		<fieldset>
			<label>Todo:<label>
			<input type="text" id="dscr" />
			<button>add to list</button>
		</fieldset>
		
		<script>
			
			
			$("document").ready(function(){
				//Delete an Item
				var requestDelete = '{"jsonrpc":"2.0","id":"delete","method":"todo:trash","params":[@]}';
				var clickHandler = function(){
					var $btn = $(this);
					$.post("?",{"json":requestDelete.replace("@",$btn.attr("todo"))},function(d){
						var data = jQuery.parseJSON(d);
						if (data.id=="delete") $btn.parent().remove();
					});
				}
				//Attach Click Handlers
				$("li button").click(clickHandler);
				//Add an Item
				$("fieldset button").click(function(){
					var requestAdd = '{"jsonrpc":"2.0","id":"add_todo","method":"todo:store","params":[{"description":"@"}]}';
					$.post("?",{"json":requestAdd.replace("@",$("#dscr").val())},function(d){
						data = JSON.parse(d);
						if (data.id=="add_todo") {
							$(".list").append("<li><button todo='"+data.result+"'>DONE</button>"+$("#dscr").val()+"</li>");
							//Restore Click Handlers
							$("li button").unbind().click(clickHandler);
						}
					});		
				});
			});
			
		</script>
		
	</body>
</html>

