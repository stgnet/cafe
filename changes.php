<?php
require 'head.php';

echo '<div class="container">';

$options = array(
  'http'=>array(
    'method'=>"GET",
    'header'=>"Accept-language: en\r\n" .
	          "Accept: application/json\r\n".
              "User-Agent: php/cafe (unknown)\r\n" 
  )
);

$context = stream_context_create($options);
//$file = file_get_contents($url, false, $context);
$head=json_decode(file_get_contents('https://api.github.com/repos/stgnet/cafe/git/refs/heads/master',false,$context));

$next_commit_url = $head->object->url;

while ($next_commit_url)
{

	$commit = json_decode(file_get_contents($next_commit_url,false,$context));
	$next_commit_url=false;

	echo '<div class="well">';
	echo '<div class="pull-right"><a role="button" class="btn btn-default btn-xs" href="'.$commit->html_url.'">View Code</a></div>';
	echo '<h5>'.$commit->committer->date.' by '.$commit->committer->name.' ('.$commit->committer->email.')</h5>';
	echo '<p>'.htmlentities($commit->message).'</p>';
	echo '</div>'."\n";

	if (!empty($commit->parents[0]->url))
		$next_commit_url=$commit->parents[0]->url;
	
	//echo '<pre>'.print_r($commit,true).'</pre>';
}


require 'foot.php';

