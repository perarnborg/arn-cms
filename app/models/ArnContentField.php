<?php
use Phalcon\Mvc\Model\Relation;
use Phalcon\Mvc\Model\Resultset;
class ArnContentField extends CacheableModel
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
     * @var integer
     */
    public $field_id;

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
        $this->belongsTo('field_id', 'ArnField', 'id', array(
            'foreignKey' => array(
                'message' => 'The field does not exist in the app'
            )
        ));
    }

    public function getValue() {
        $field = ArnField::findFirst($this->field_id);
        if($field->value_type == 'integer') {
            return intval($this->value, 10);
        }
        if($field->value_type == 'double') {
            return floatval($this->value, 10);
        }
        return $this->value;
    }
}
