<?php
/*
          <ul class="nav navbar-nav">
            <li class="active"><a href="#">Purchase</a></li>
            <li><a href="balance.php">Balance</a></li>
            <li><a href="faq.php">FAQ</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Admin <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
				  <li><a href="payment.php">Payment <span class="glyphicon glyphicon-lock"></span></a></li>
                <li><a href="report.php">Report <span class="glyphicon glyphicon-lock"></span></a></li>
				  <!--
                <li><a href="#">Something else here</a></li>
                <li class="divider"></li>
                <li class="dropdown-header">Nav header</li>
                <li><a href="#">Separated link</a></li>
                <li><a href="#">One more separated link</a></li>
				-->
              </ul>
            </li>
          </ul>


	<ul class="nav navbar-nav " role="">
		<li class="active"><a href="purchase.php">Purchase</a></li>
		<li><a href="account.php">Account</a></li>
		<li><a href="faq.php">FAQ</a></li>
	</ul>
	<ul class="nav navbar-nav navbar-right" role="">
		<li class="dropdown">
		  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Admin</a>
			<ul class="nav navbar-nav dropdown-menu" role="menu">
				<li><a href="payment.php">Payment <span class="glyphicon glyphicon-lock"></span></a></li>
				<li><a href="report.php">Report <span class="glyphicon glyphicon-lock"></span></a></li>
			</ul>
		</li>
	</ul>
*/

function navbar($menu, $class=NULL, $role=NULL)
{
	$script=basename($_SERVER['SCRIPT_NAME']);
	if ($class!="dropdown-menu") {
		$class='nav navbar-nav '.$class;
	}
	echo '<ul class="'.$class.'" role="'.$role.'">';
	foreach ($menu as $name => $target){
		if (is_array($target)) {
			echo '<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">'.$name.' <span class="caret"></span></a>';
			navbar($target, 'dropdown-menu', 'menu');
			echo '</li>'."\n";
			continue;
		}
		echo '<li';
		if ($target==$script) {
			echo ' class="active"';
		}
		echo '><a href="'.$target.'">'.$name.'</a></li>'."\n";
	}
	echo '</ul>'."\n";
}
