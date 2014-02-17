<?php
use Phalcon\Mvc\Model\Relation;
use Phalcon\Mvc\Model\Resultset;
class ArnContentType extends CacheableModel
{
    /**
     * @var integer
     */
    public $id;

    /**
     * @var string
     */
    public $title;

    /**
     * @var string
     */
    public $description;

    /**
     * @var int
     */
    public $has_image;

    /**
     * @var int
     */
    public $has_media;

    public function initialize()
    {
        $this->hasMany('id', 'ArnContent', 'content_type_id', array(
            'foreignKey' => array(
                'action' => Relation::ACTION_CASCADE
            )
        ));
        $this->hasMany('id', 'ArnField', 'field_id', array(
            'foreignKey' => array(
                'action' => Relation::ACTION_CASCADE
            )
        ));
    }
}
