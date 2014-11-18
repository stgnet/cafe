<?php
	require 'head.php';
?>
<div class="container">
	<form role="form" action="bought.php" method="post">
		<div class="form-group">
			<label for="email-ac">Email address</label>
			<input type="email" class="form-control" name="email" id="email-ac" placeholder="Enter email">
		</div>
		<div class="form-group">
			<?php foreach (array(1,2,3,4,5) as $count) { ?>
			<div class="form-inline">
				<!--
				<label for="item1">Item</label>
				-->
				<div class="input-group">
					<input type="text" class="form-control items" name="items[]" id="item<?php echo $count; ?>" placeholder="Item" />
					<div class="input-group-addon">$</div><input type="text" class="form-control" name="costs[]" id="cost<?php echo $count; ?>" />
				</div>
			</div>
			<?php } ?>
		</div>
		<input type="hidden" name="action" value="purchase" />
		<button type="submit" class="btn btn-default active">Purchase</button>
	</form>
</div>
<?php
	$postscript='
	jQuery(function(){
		var a = $("#email-ac").autocomplete({
			serviceUrl:"email_ac.php"
		});
		var b = $(".items").autocomplete({
			onSelect: function(suggestion){
				data = suggestion.data.split("|");
				$(this).val(data[0]);
				$(this).next().next().val(data[1]);
			},
			serviceUrl:"items_ac.php"
		});
	});
	';
	require 'foot.php';
