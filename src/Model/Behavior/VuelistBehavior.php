<?php
namespace List4Vue\Model\Behavior;

use Cake\ORM\Behavior;
use Cake\ORM\Query;

class VuelistBehavior extends Behavior
{
  public function findJson(Query $query, array $options)
  {
    $options += [
        'keyField'   => $this->_table->primaryKey(),
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


    return $query->formatResults(function ($results) use ($options) {
      if (is_null($options['groupField']))
      {
        $mapper = function ($row) use ($options) {
          return [
            $options['keyField']   => $row[$options['keyField']] ,
            $options['valueField'] => $row[$options['valueField']] ,
          ];
        };
        $reducer = function ($rows,$row) {
          $rows[] = $row;
          return $rows;
        };
      } else {
        $mapper = function ($row) use ($options) {
          return [ $row[ $options['groupField'] ]  => [
              $options['keyField']   => $row[$options['keyField']] ,
              $options['valueField'] => $row[$options['valueField']] ,
            ]
          ];
        };
        $reducer = function ($rows,$row) {
          $rows[key($row)][] = current($row);
          return $rows;
        };
      }
      $map    = $results->map( $mapper );
      $reduce = $map->reduce( $reducer , [] );
      if (is_null($options['groupField']))
      {
        $result[] = [
          'items' => $reduce
        ];
      } else {
        foreach ($reduce as $key => $value) {
          $result[] = [
            'groupField' => $key,
            'items'      => $value
          ];
        }
      }
      return $result;
    });
  }
}