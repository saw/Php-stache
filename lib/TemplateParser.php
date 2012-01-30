<?php

/**
 * This class is used to parse templates
 * it takes a 
 */
class TemplateParser {
    
    const regex = "/\{([a-z][a-z0-9]+?)\}/i";
    const cachekey = 'tmp';
    
    static function parse($path, $data){
        $app = App::getInstance();
        
        //that's right, I am caching the rendered version, because it
        //makes sense, every rendered version will be read several times.
        if(App::getInstance()->getConf('mode') == 'prod'){
            $id = md5($path . implode('', $data));
            
            $str = apc_fetch($id);
            if($str){
                return $str;
            }
        }
        
        //cache templates
        if($app->getConf('mode') == 'prod'){
            $template = apc_fetch(self::cachekey . $path);
            if(!$template){
                $template = file_get_contents(__DIR__ . '/../minitemplates/'. $path);
                apc_store(self::cachekey . $path, $template);
            }
        }else{
            // super slow in dev mode
            $template = file_get_contents(__DIR__ . '/../minitemplates/'. $path);
        }
        
        
    
        if(!$template){
            throw new Exception('Mini template file not found');
        }
        $returnStr = $template;

        preg_match_all(self::regex, $template, $matches);
        $len = count($matches[0]);
        try{
        for ($i=0; $i < $len; $i++) { 
            $itemName = $matches[1][$i];
            if(array_key_exists($itemName, $data)){
                if(is_string($data[$itemName]) || is_int($data[$itemName]) || is_float($data[$itemName])){
                    $returnStr = str_replace($matches[0][$i], $data[$itemName], $returnStr);
                }else{
                    $returnStr = str_replace($matches[0][$i], "{not string or number:$itemName}", $returnStr);
                }
            }else{
                $returnStr = str_replace($matches[0][$i], "{undefined:$itemName}", $returnStr);
            }
        }
        }catch (Exception $e){
            error_log($e->getMessage());
        }
        
        if($app->getConf('mode') == 'prod'){
            apc_store($id, $returnStr,  $app->getConf('template_cache_ttl'));
        }
        
        return $returnStr;

    }
    
}