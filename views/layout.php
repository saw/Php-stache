<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, user-scaleble=no"/>
	<link rel="stylesheet" href="/css/deploy.source.css" type="text/css" media="screen" title="no title" charset="utf-8">
	
	<title>awesum</title>

</head>
<body>
    <?=$this->body;?>
</div>
</div>
</body>
<script type="text/javascript" src="http://yui.yahooapis.com/combo?3.4.0/build/yui/yui-min.js"></script>
<?php 
if($showYuiConf){

$moduleList = array();

$prod = App::getInstance()->getConf('mode') == 'prod' ? true : false;


foreach($modules as $module){
    if(!$prod){
        echo("<script src=\"{$module->path}\" type=\"text/javascript\"></script>\n");
    }
    $moduleList[] = "{$module->name}";
}

if($prod){
    $cachebuster = App::getInstance()->getConf('cachebust');
    $comboStr = implode($moduleList, '&');
    if($cachebuster){
        $comboStr .= '&.v=' . $cachebuster;
    }
    echo("<script src=\"/combo?$comboStr\" type=\"text/javascript\"></script>\n");
}

?>
<script type="text/javascript">
    YUI({deployData:<?=$yuiconf?>}).use('<?=implode("','", $moduleList); ?>', function(Y){
        <?php
        foreach($modules as $module){
            if($module->initCode){
                echo($module->initCode . "\n");
            }  
        }
        ?>
    });
</script>
<?php } ?>
</html>