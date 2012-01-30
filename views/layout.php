
<body>

    <?=$this->body;?>

</body>
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