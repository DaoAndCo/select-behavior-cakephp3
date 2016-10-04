<?php
namespace List4Vue\Model\Behavior;

use Cake\ORM\Behavior;
use Cake\ORM\Query;

class VuelistBehavior extends Behavior
{

  public function findSelect(Query $query, array $options)
  {
    $options += [
      'keyField'   => $this->_table->primaryKey(),
      'valueField' => $this->_table->displayField(),
      'groupField' => null
    ];
    $query = $this->_table->findList($query,$options);

    return $query->formatResults(function ($results) use ($options)
    {
      if (is_null($options['groupField']))
      {
        return [ ['items' => $this->_addkeys($results,$options)] ];
      }
      else
      {
        $list = [];
        foreach ($results as $group => $result)
        {
          $list[] = [
            'group' => $group,
            'items' => $this->_addkeys($result,$options)
          ];
        }
        return $list;
      }
    });
  }

  protected function _addKeys($items,$options)
  {
    $list = [];
    foreach ($items as $key => $item)
    {
      $list[] = [
        'key'   => $key,
        'value' => $item
      ];
    }
    return $list;
  }

}