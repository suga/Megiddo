
    /**
     * Converts the object to the object class
     * @param stdClass $stdClass
     * @param Sql $instance
     * @return object
     */
    private function ConvertingObject(stdClass $stdClass, $instance = null) {
        $ObjPeer = new [%obj%]();
        [%sets%]
        [%end%]