
    /**
     * Delete the information in the Database
     * @return bollean
     */
    public function delete() {
        $pk = array(
                        self::[%constant%] => $this->[%variable%]);
        $sql = new Sql();
        return $sql->delete(self::TABLE, $pk);
    }
    