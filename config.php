<?php
global $config;
global $db;

function pdo_dsn($params, $omitdbname = false)
{
	$prefix=$params['pdo'].':';
	$dsn='';
	foreach ($params as $key => $value)
	{
		if ($key == 'pdo') continue;
		if ($key == 'dbname' && $omitdbname) continue;
		if ($key == 'username') continue;
		if ($key == 'password') continue;
		if ($dsn) $dsn.=';';
		$dsn.=$key.'='.$value;
	}
	return $prefix.$dsn;
}

class pdb
{
	private $name;

	private function field_definition($column)
	{
		$definition=$column['Field'].' '.$column['Type'];
		if ($column['Key']=='PRI') {
			$definition.=' PRIMARY KEY';
		}
		else if ($column['Key']!='') {
			throw new Exception('Unimplemented');
		}
		if ($column['Null']=='NO' || $column['Null']===False) {
			$definition.=' NOT NULL';
		}
		if ($column['Default'] || $column['Extra']) {
			throw new Exception('Unimplemented');
		}
		return $definition;
	}
	public function __construct($name, $schema)
	{
		global $db;

		$this->name=$name;
		$describe = $db->query('describe '.$name);
		if (!$describe) {
			// database or table may not exist
			$db->query('CREATE DATABASE '.$name.' IF NOT EXISTS');
			$db->query('USE '.$name);
			$fields='';
			foreach ($schema as $column)
			{
				if ($fields) $fields.=',';
				$fields.=$this->field_definition($column);
			}
			$db->query('CREATE TABLE '.$name.'('.$fields.');');
			
			$describe = $db->query('describe '.$name);
		}
		$existing = $describe->fetchAll(PDO::FETCH_ASSOC);
		foreach ($schema as $scol)
		{
			$found=NULL;
			foreach ($existing as $index => $xcol)
			{
				if ($scol['Field']==$xcol['Field'])
					$found=$index;
			}
			if ($found===NULL)
			{
				$result=$db->query('ALTER TABLE '.$name.' ADD '.$this->field_definition($scol).';');
			}
			else
			{
				$xcol=$existing[$found];
				if ($scol['Type']!=$xcol['Type']) {
					throw new Exception('Unmatched type not handled');
				}
				if ($scol['Null']!=$xcol['Null']) {
					throw new Exception('Unmatched type not handled');
				}
				if ($scol['Key']!=$xcol['Key']) {
					throw new Exception('Unmatched key not handled');
				}
				if ($scol['Default']!=$xcol['Default']) {
					throw new Exception('Unmatched default not handled');
				}
				if ($scol['Extra']!=$xcol['Extra']) {
					throw new Exception('Unmatched type not handled');
				}
			}
		}
	}
	private function prepare_fields($fields, $pattern)
	{
		global $db;
		$values=array();
		foreach ($fields as $name => $value) {
			$values[]=str_replace('%', $name, $pattern);
		}
		return implode(',',$values);
	}
	private function prepare_values($fields,$prefix=':')
	{
		$values=array();
		foreach ($fields as $name => $value) {
			$values[$prefix.$name]=$value;
		}
		return $values;
	}
	public function insert($record)
	{
		global $db;
		
		$stmt=$db->prepare('INSERT INTO '.$this->name.' ('.implode(',',array_keys($record)).') VALUES('.$this->prepare_fields($record,':%').');');
		$stmt->execute($this->prepare_values($record));
	}
	public function records($where=array(), $like=FALSE)
	{
		global $db;
		if ($like) {
			$pattern='% LIKE :%';
		} else {
			$pattern='% = :%';
		}
		$query='SELECT * FROM '.$this->name;
		if ($where) {
			$query.=' WHERE '.$this->prepare_fields($where,$pattern);
		}
		$stmt=$db->prepare($query.';');
		$stmt->execute($this->prepare_values($where));
		return($stmt->fetchAll(PDO::FETCH_ASSOC));
	}
	public function record($where=array())
	{
		$records=$this->records($where);
		if (!$records) return($records);
		if (count($records)==1) return($records[0]);
		throw new Exception('record() found multiple records'); 
	}
	public function delete($where)
	{
		global $db;
		$stmt=$db->prepare('DELETE FROM '.$this->name.' WHERE '.$this->prepare_fields($where,'% = :%').';');
		$stmt->execute($this->prepare_values($where));
	}
	public function update($where, $record)
	{
		global $db;
		$stmt=$db->prepare('UPDATE '.$this->name.
			' SET '.$this->prepare_fields($record,'% = :R%').
			' WHERE '.$this->prepare_fields($where,'% = :W%').';');
		$stmt->execute(array_merge($this->prepare_values($record,':R'),$this->prepare_values($where,':W')));
	}
							   
}
/*		
$schema = $db->query('describe test');
print_r($schema);
foreach ($schema->fetchAll(PDO::FETCH_ASSOC) as $row) print_r($row);
//$data=$schema->fetchAll(PDO::FETCH_ASSOC);
//echo "have ".count($data)." records\n";
		
	}
}
*/
function php_error_handler($errno, $errstr, $errfile, $errline)
{
	mail('scott@griepentrog.com','CAFE ERROR', 'ERROR: '.$errstr.' in '.$errfile.' at '.$errline);
	die('ERROR: '.$errstr.' in '.$errfile.' at '.$errline);
}
function php_exception_handler($e)
{
	mail('scott@griepentrog.com','CAFE EXCEPTION', 'EXCEPTION: '.(string)$e);
	die('EXCEPTION: '.(string)$e);
}
set_error_handler('php_error_handler');
set_exception_handler('php_exception_handler');
error_reporting(-1);
ini_set('display_errors','1');

$config=parse_ini_file('config.ini',true);
$pdo = $config['db'];
try {
	$db = new PDO(pdo_dsn($pdo), $pdo['username'], $pdo['password']);
} catch (PDOException $e) {
	die('pdo failure '.(string)$e);
}

$users_schema=array(
	array(
		'Field' => 'email',
		'Type' => 'varchar(128)',
		'Null' => 'NO',
		'Key' => 'PRI',
		'Default' => '',
		'Extra' => ''
	),
	array(
		'Field' => 'name',
		'Type' => 'varchar(128)',
		'Null' => 'YES',
		'Key' => '',
		'Default' => '',
		'Extra' => '' 
	),
	array(
		'Field' => 'pin',
		'Type' => 'varchar(16)',
		'Null' => 'YES',
		'Key' => '',
		'Default' => '',
		'Extra' => '' 
	),
	array(
		'Field' => 'balance',
		'Type' => 'decimal(10,2)',
		'Null' => 'YES',
		'Key' => '',
		'Default' => '',
		'Extra' => '' 
	)
);

global $db_users;
$db_users=new pdb('users', $users_schema);

$items_schema=array(
	array(
		'Field' => 'name',
		'Type' => 'varchar(128)',
		'Null' => 'NO',
		'Key' => '',
		'Default' => '',
		'Extra' => ''
	),
	array(
		'Field' => 'cost',
		'Type' => 'decimal(10,2)',
		'Null' => 'YES',
		'Key' => '',
		'Default' => '',
		'Extra' => '' 
	)
);


global $db_items;
$db_items=new pdb('items', $items_schema);
	
$trans_schema=array(
	array(
		'Field' => 'email',
		'Type' => 'varchar(128)',
		'Null' => 'NO',
		'Key' => '',
		'Default' => '',
		'Extra' => ''
	),
	array(
		'Field' => 'datetime',
		'Type' => 'datetime',
		'Null' => 'NO',
		'Key' => '',
		'Default' => '',
		'Extra' => ''
	),
	array(
		'Field' => 'item',
		'Type' => 'varchar(128)',
		'Null' => 'NO',
		'Key' => '',
		'Default' => '',
		'Extra' => ''
	),
	array(
		'Field' => 'amount',
		'Type' => 'decimal(10,2)',
		'Null' => 'YES',
		'Key' => '',
		'Default' => '',
		'Extra' => '' 
	)
);

global $db_trans;
$db_trans=new pdb('trans', $trans_schema);

/*
$db->query('SELECT * FROM users') as $row) {
	print_r($row);
}
*/
