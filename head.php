<?php
	require 'utils.php';
	$lock='<span class="glyphicon glyphicon-lock"></span>';
	$menu=array(
		'Menu' => 'menu.php',
		'Purchase' => 'purchase.php',
		'Account' => 'account.php',
		'Help' => array(
			'About' => 'about.php',
			'FAQ' => 'faq.php',
			'Suggest' => 'suggest.php',
			'Changes' => 'changes.php'
		)
	);
	$menu_right=array(
		'Admin' => array(
			'Payment '.$lock => 'payment.php',
			'Report '.$lock => 'report.php',
			'Items '.$lock => 'items.php'
		)
	);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Cafe Honor Sheet">
	<meta name="author" content="http://github.com/stgnet/cafe">
	<?php
		if (!empty($refresh)) {
			echo '<meta http-equiv="refresh" content="'.$refresh.'">'."\n";
		}
	?>
    <title>Digium Beans and Bytes Cafe Honor Sheet</title>
    <link href="//maxcdn.bootstrapcdn.com/bootswatch/3.2.0/cerulean/bootstrap.min.css" rel="stylesheet">
	<style>
		.autocomplete-wrapper { margin: 44px auto 44px; max-width: 600px; }
		.autocomplete-wrapper label { display: block; margin-bottom: .75em; color: #3f4e5e; font-size: 1.25em; }
		.autocomplete-wrapper .text-field { padding: 0 15px; width: 100%; height: 40px; border: 1px solid #CBD3DD; font-size: 1.125em; }
		.autocomplete-wrapper ::-webkit-input-placeholder { color: #CBD3DD; font-style: italic; font-size: 18px; }
		.autocomplete-wrapper :-moz-placeholder { color: #CBD3DD; font-style: italic; font-size: 18px; }
		.autocomplete-wrapper ::-moz-placeholder { color: #CBD3DD; font-style: italic; font-size: 18px; }
		.autocomplete-wrapper :-ms-input-placeholder { color: #CBD3DD; font-style: italic; font-size: 18px; }
		.autocomplete-suggestions { overflow: auto; border: 1px solid #CBD3DD; background: #FFF; }
		.autocomplete-suggestion { overflow: hidden; padding: 5px 15px; white-space: nowrap; }
		.autocomplete-selected { background: #F0F0F0; }
		.autocomplete-suggestions strong { color: #029cca; font-weight: normal; }
	</style>
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
    <div class="navbar navbar-default" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">
			  <img src="http://www.digium.com/sites/digium/files/asterisk-bubble_0.png" width="25" height="21">
			  Digium Cafe Honor Sheet
		  </a>
        </div>
        <div class="navbar-collapse collapse">
			<?php
				navbar($menu); 
				navbar($menu_right,'navbar-right');
			?>
        </div><!--/.nav-collapse -->
      </div>
    </div>
