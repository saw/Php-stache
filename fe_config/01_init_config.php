<?php

/**
 * I hate config files! 
 * but the time has come that they make sense.
 */
 
 //
 
 if(!isset($app)){
     $app = App::getInstance();
 }
 
 $app = App::getInstance();

 //in prod mode mini templates are cached in apc...
 //I strongly recommend RESTARTING apache when this package is updated
 // $app->setConf('mode', 'prod');
 $app->setConf('mode', 'dev');
 
 //how long should we store cached (rendered) templates in apc?
 $app->setConf('template_cache_ttl', 10800);
 
 $app->setConf('cachebust', 1);
