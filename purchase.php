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
				<input type="text" class="form-control items" name="items[]" id="item" placeholder="Item" />
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
	$postscript='
	jQuery(function(){
		var a = $("#email-ac").autocomplete({
			serviceUrl:"email_ac.php"
		});
		function attach_item_ac(){
			var b = $(".items").autocomplete({
				onSelect: function(suggestion){
					data = suggestion.data.split("|");
					$(this).val(data[0]);
					$(this).next().next().val(data[1]);
				},
				serviceUrl:"items_ac.php"
			});
		}
		attach_item_ac();
		$("#additem").on("click", function (e) {
			$("#itemnext").before(\'<div class="form-group">\'+$("#itemcopy").html()+\'</div>\');
			attach_item_ac();
		})
	});
	';
	require 'foot.php';
