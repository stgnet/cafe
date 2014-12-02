<?php
	require 'head.php';
?>
<div class="container">
	<form role="form" action="bought.php" method="post">
		<div class="form-group">
			<label for="email-ac">Email address</label>
			<input type="email" class="form-control" name="email" id="email-ac" placeholder="Enter email">
		</div>
		<div class="form-group" id="itemcopy">
			<div class="input-group">
				<input type="text" class="form-control items needs-ac" name="items[]" id="item" placeholder="Item" />
				<div class="input-group-addon">$</div><input type="text" class="form-control" name="costs[]" id="cost" />
			</div>
		</div>
		<div id="itemnext"></div>
		<button type="button" class="btn btn-default" id="additem">+</button>
		<div class="form-group">
			<input type="hidden" name="action" value="purchase" />
		</div>
		<button type="submit" class="btn btn-default active">Purchase</button>
	</form>
</div>
<?php
	$postscript=<<<'SCRIPT'
	jQuery(function(){
		var item_html = '<div class="form-group">' + $("#itemcopy").html() + '</div>';
		var a = $("#email-ac").autocomplete({
			serviceUrl:"email_ac.php"
		});
		function attach_item_ac(){
			var b = $(".needs-ac").removeClass('needs-ac').autocomplete({
				onSelect: function(suggestion){
					data = suggestion.data.split("|");
					$(this).val(data[0]);
					$(this).next().next().val(data[1]);
				},
				serviceUrl:"items_ac.php"
			});
		}
		attach_item_ac();
		
		function add_another_item(){
			$("#itemnext").before('<div class="form-group">'+item_html+'</div>');
			attach_item_ac();
		}
		$("#additem").on("click", function (e) {
			add_another_item();
		})
	});
SCRIPT;
	require 'foot.php';
