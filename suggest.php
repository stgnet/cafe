<?php

require 'head.php';

if (!empty($_POST)) {
	mail("scott@griepentrog.com","CAFE SUGGESTION",print_r($_POST,true).print_r($_SERVER,true));
	echo '<p>Thanks your suggestion has been submitted</p>';
	require foot.php;
	return;
}
	
?>
<div class="container">
	<form role="form" action="suggest.php" method="post">
		<div class="form-group">
			<label for="question">Enter suggestion:</label>
			<textarea class="form-control" name="suggestion" rows="5"></textarea>
		</div>
		<button type="submit" class="btn btn-default">Send</button>
	</form>
</div>
<?php
	require 'foot.php';
