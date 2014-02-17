<?php
use Phalcon\Mvc\Model\Relation;
use Phalcon\Mvc\Model\Resultset;
class ArnField extends CacheableModel
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
     * @var string
     */
    public $title;

    /**
     * @var string
     */
    public $description;

    /**
     * @var string
     */
    public $value_type;

    public function initialize()
    {
        $this->belongsTo('content_type_id', 'ArnContentType', 'id', array(
            'foreignKey' => array(
                'message' => 'The content type does not exist in the app'
            )
        ));
        $this->hasMany('id', 'ArnContentField', 'field_id', array(
            'foreignKey' => array(
                'action' => Relation::ACTION_CASCADE
            )
        ));
    }
}
