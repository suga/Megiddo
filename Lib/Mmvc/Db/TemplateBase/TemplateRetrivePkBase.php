
    /**
     * Returns the for the primary key
     * @param integer $[%variable%]
     * @return [%obj%]
     */
    public static function retriveByPk($[%variable%]) {
        $criteria = new Criteria();
        $criteria->add(self::[%constant%], $[%variable%]);
        $criteria->setLimit(1);
        $obj = new [%obj%]();
        return $obj->doSelectOne($criteria);
    }
    