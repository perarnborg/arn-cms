<?php
use Phalcon\Mvc\Model\Relation;
use Phalcon\Mvc\Model\Resultset;
class ArnContentMedia extends CacheableModel
{
    /**
     * @var integer
     */
    public $id;

    /**
     * @var integer
     */
    public $content_id;

    /**
     * @var string
     */
    public $title;

    /**
     * @var int
     */
    public $sort_order;

    /**
     * @var string
     */
    public $value;

    public function initialize()
    {
        $this->belongsTo('content_id', 'ArnContent', 'id', array(
            'foreignKey' => array(
                'message' => 'The content does not exist in the app'
            )
        ));
    }
}
