<?php
use Phalcon\Cache\Backend\Libmemcached;
class CacheableModel extends Phalcon\Mvc\Model
{
    protected static $_loadedOnce = array();
    protected static $_cacheLifeTime = 3600;

    public static function getCache(){
        $cache = false;
        $config = new Phalcon\Config\Adapter\Ini(__DIR__ . '/../config/config.ini');
        $frontCache = new Phalcon\Cache\Frontend\Data(array(
            "lifetime" => self::$_cacheLifeTime
        ));
        if($config->cache->method == 'memory') {
            $cache = new Phalcon\Cache\Backend\Memcache($frontCache, array(
                "host" => "localhost",
                "port" => "11211"
            ));
        } else if($config->cache->method == 'file') {
            $cache = new Phalcon\Cache\Backend\File($frontCache, array(
                "cacheDir" => "../app/cache/file/"
            ));
        }
        return $cache;
    }

    public static function _getKey($functionName, $parameters = array())
    {
        $uniqueKey = array(get_called_class(), $functionName);
        if($parameters != null) {
            if(!is_array($parameters)) {
                $parameters = array($parameters);
            }
            foreach ($parameters as $key => $value) {
                if (is_scalar($value)) {
                    $uniqueKey[] = $key . ':' . $value;
                } else {
                    if (is_array($value)) {
                        $uniqueKey[] = $key . ':[' . self::_getKey('parameter', $value) .']';
                    }
                }
            }
        }
        return md5(join('_', $uniqueKey));
    }

    private static function _getCached($key, $cache) {
        if (!isset(self::$_loadedOnce[$key])) { // Check memory
            if($cache) {
                if($cached = $cache->get($key)) {
                    self::$_loadedOnce[$key] = $cached;  
                    $classKey = md5(get_called_class());
                    $storedClassKeys = $cache->get($classKey) || array();
                    array_push($storedClassKeys, $key);
                    $cache->save($classKey, $storedClassKeys);
                    return $cached;
                }
            }
            return null;
        }
        return self::$_loadedOnce[$key];
    }

    public static function clearGetCache($id) {
        $cache = $this->getCache();
        if($cache) {
            $cache->delete($this->_getKey('findFirst', $id));
        }
    }

    public static function flushCache() {
        $cache = self::getCache();
        if($cache) {
            $classKey = md5(get_called_class());
            $storedClassKeys = $cache->get($classKey) || array();
            if($storedClassKeys) {
                foreach ($storedClassKeys as $key) {
                    $cache->delete($key);
                }
            }            
        }
    }

    public static function find($parameters=null)
    {
        $cache = self::getCache();
        $key = self::_getKey('find', $parameters);
        if(($cached = self::_getCached($key, $cache)) !== null) {
            return $cached;
        }
        $data = parent::find($parameters);
        self::$_loadedOnce[$key] = $data;
        if($cache) {
            $cache->save($key, $data);
        }
        return $data;
    }

    public static function findFirst($parameters=null)
    {
        $cache = self::getCache();
        $key = self::_getKey('findAll', $parameters);
        if(($cached = self::_getCached($key, $cache)) !== null) {
            return $cached;
        }
        $data = parent::findFirst($parameters);
        self::$_loadedOnce[$key] = $data;
        if($cache) {
            $cache->save($key, $data);
        }
        return $data;
    }
}
