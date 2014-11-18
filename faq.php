<?php

require 'head.php';

if (!empty($_POST)) {
	mail("scott@griepentrog.com","CAFE QUESTION",print_r($_POST,true).print_r($_SERVER,true));
	echo '<p>Thanks your question has been submitted</p>';
	require foot.php;
	return;
}
	
?>
<div class="container well">
	<h5>There are no questions yet.</h5>
</div>
<div class="container">
	<form role="form" action="faq.php" method="post">
		<div class="form-group">
			<label for="question">Enter new question:</label>
			<textarea class="form-control" name="question" rows="5"></textarea>
		</div>
		<button type="submit" class="btn btn-default">Send</button>
	</form>
</div>
<?php
	require 'foot.php';
