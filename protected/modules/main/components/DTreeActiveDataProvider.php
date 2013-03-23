<?php
/**
 * @author ElisDN <mail@elisdn.ru>
 * @link http://www.elisdn.ru
 */

class DTreeActiveDataProvider extends CActiveDataProvider
{
    public $childRelation = 'child_items';

    /**
     * Fetches the data from the persistent data storage.
     * @return array list of data items
     */
    protected function fetchData()
    {
        $criteria=clone $this->getCriteria();

        if(($pagination=$this->getPagination())!==false)
        {
            $pagination->setItemCount($this->getTotalItemCount());
            $pagination->applyLimit($criteria);
        }

        $baseCriteria=$this->model->getDbCriteria(false);

        if(($sort=$this->getSort())!==false)
        {
            // set model criteria so that CSort can use its table alias setting
            if($baseCriteria!==null)
            {
                $c=clone $baseCriteria;
                $c->mergeWith($criteria);
                $this->model->setDbCriteria($c);
            }
            else
                $this->model->setDbCriteria($criteria);
            $sort->applyOrder($criteria);
        }

        $this->model->setDbCriteria($baseCriteria!==null ? clone $baseCriteria : null);

        $cr = clone $criteria;
        $cr->addCondition('t.parent_id=0');
        $items=$this->model->findAll($cr);
        if (!$items)
            $items=$this->model->findAll($criteria);
        $data = $this->recursive($items);

        $this->model->setDbCriteria($baseCriteria);  // restore original criteria
        return $data;
    }

    protected function recursive($items, $indent=0, $foolproof=20)
    {
        $data = array();
        foreach ($items as $item)
        {
            $item->indent = $indent;
            $data[] = $item;
            if ($foolproof && $item->{$this->childRelation})
                $data = array_merge($data, $this->recursive($item->{$this->childRelation}, $indent + 1, $foolproof - 1));
        }
        return $data;
    }
}
