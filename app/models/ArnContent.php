<?php
use Phalcon\Mvc\Model\Relation;
use Phalcon\Mvc\Model\Resultset;
class ArnContent extends CacheableModel
{
    /**
     * @var integer
     */
    public $id;

    /**
     * @var integer
     */
    public $content_type_id;

    /**
     * @var integer
     */
    public $content_id;

    /**
     * @var integer
     */
    public $parent_id;

    /**
     * @var string
     */
    public $title;

    /**
     * @var string
     */
    public $slug;

    /**
     * @var string
     */
    public $description;

    /**
     * @var string
     */
    public $main_image_url;

    /**
     * @var string
     */
    public $main_image_title;

    /**
     * @var int
     */
    public $state;

    /**
     * @var int
     */
    public $published_at;

    /**
     * @var int
     */
    public $updated_at;

    /**
     * @var int
     */
    public $created_at;

    /**
     * @var int
     */
    public $created_user_id;

    /**
     * @var array
     */
    public $images = array();

    /**
     * @var array
     */
    public $fields = array();

    public function initialize()
    {
        $this->belongsTo('content_type_id', 'ArnContentType', 'id', array(
            'foreignKey' => array(
                'message' => 'The content type does not exist in the app'
            )
        ));
        $this->belongsTo('created_user_id', 'Users', 'id', array(
            'foreignKey' => array(
                'message' => 'The user does not exist in the app'
            )
        ));
        $this->hasMany('id', 'ArnContent', 'content_id', array(
            'foreignKey' => array(
                'action' => Relation::ACTION_CASCADE
            )
        ));
        $this->hasMany('id', 'ArnContentField', 'content_id', array(
            'foreignKey' => array(
                'action' => Relation::ACTION_CASCADE
            )
        ));
        $this->hasMany('id', 'ArnContentMedia', 'content_id', array(
            'foreignKey' => array(
                'action' => Relation::ACTION_CASCADE
            )
        ));
    }

    public static function list($contentTypeTitle, $parameters=array())
    {
        $cache = self::getCache();
        $key = self::_getKey('list_'.$contentTypeTitle, $parameters);
        if(($cached = self::_getCached($key, $cache)) !== null) {
            return $cached;
        }
        $data = array();
        if(!is_array($parameters)) {
            $parameters = array($parameters);
        }
        $contentType = ArnContentType::findFirst(array(
            "title = :contentTypeTitle:",
            "bind" => array("contentTypeTitle" => $contentTypeTitle)
        ));
        if($contentType) {
            array_push($parameters, "content_type_id = ".(int)$contentType->id);
            $data = parent::find($parameters);
            $fields = $contentType->getArnField();
            if(count($fields) > 0) {
                foreach ($data as $item) {
                    foreach ($item->getArnContentField() as $contentField) {
                        foreach ($fields as $field) {
                            if($field->id == $contentField->content_field_id) {
                                $item->fields[$field['title']] = $contentField->getValue();
                            }
                        }
                    }
                }
            }
            if($contentType->has_media) {
                foreach ($data as $item) {
                    $item->media = $item->getArnContentMedia();
                }
            }
        }
        if($cache) {
            $cache->save($key, $data);
        }
        return $data;
    }

    public static function get($parameters=null)
    {
        $cache = self::getCache();
        $key = self::_getKey('get', $parameters);
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

    public function getImageUrl($width = null, $height = null) {
        if($this->main_image_url) {
            return ImageService::getImageServiceUrl($this->main_image_url, $width, $height);            
        }
    }

    public function getMediaUrl($index, $width = null, $height = null) {
        if(isset($this->media[$index])) {
            return ImageService::getImageServiceUrl($this->media[$index]->value, $width, $height);
        }
    }
}
