<?php

    function curl_get_contents($url)
    {
        $ch=curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
        $contents=curl_exec($ch) or die('CURL ERROR: '.curl_error($ch));
        curl_close($ch);
        return($contents);
    }

    function readcsv($path)
    {
        $fp=fopen($path,"r");
        if (!$fp) return(array());

        $table=array();

        $header=fgetcsv($fp);
        while ($row=fgetcsv($fp))
		{
            $record=array();
            $index=0;
            foreach ($row as $data)
            {
                if (empty($header[$index]))
                    $header[$index]="COL$index";
                $record[$header[$index]]=$data;
                $index++;
            }
            $table[]=$record;
        }
        fclose($fp);
        return($table);
    }

    function get_spreadsheet($key)
    {
		if (!$key) throw new Exception('no KEY');
		$url='https://docs.google.com/spreadsheet/fm?key='.$key.'&fmcmd=5&gid=0';
		$file=$key.'.csv';

        if (file_exists($file))
        {
            $modified=filemtime($file);
            $age=time()-$modified;
            if ($age<60)
                return(readcsv($file));
        }
        $contents=curl_get_contents($url);
        if ($contents && $contents[0]!='[')
            file_put_contents($file,$contents);
        return(readcsv($file));
    }
