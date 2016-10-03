<?php
namespace List4Vue\Model\Behavior;

use Cake\ORM\Behavior;
use Cake\ORM\Query;

class VuelistBehavior extends Behavior
{
  public function findJson(Query $query, array $options)
  {
    $options += [
        'keyField' => $this->_table->primaryKey(),
        'valueField' => $this->_table->displayField(),
        'groupField' => null
    ];

    if (!$query->clause('select') &&
        !is_object($options['keyField']) &&
        !is_object($options['valueField']) &&
        !is_object($options['groupField'])
    ) {
        $fields = array_merge(
            (array)$options['keyField'],
            (array)$options['valueField'],
            (array)$options['groupField']
        );
        $columns = $this->_table->schema()->columns();
        if (count($fields) === count(array_intersect($fields, $columns))) {
            $query->select($fields);
        }
    }

    return $query;
  }
}