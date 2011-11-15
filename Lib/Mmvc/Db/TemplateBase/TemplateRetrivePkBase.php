
    /**
     * Returns the for the primary key
     * @param integer $[%variable%]
     * @param Sql $instance
     * @return [%obj%]
     */
    public static function retriveByPk($[%variable%], $instance = null) {
        $criteria = new Criteria();
        $criteria->add(self::[%constant%], $[%variable%]);
        $criteria->setLimit(1);
        $obj = new [%obj%]();
        return $obj->doSelectOne($criteria, $instance);
    }
    