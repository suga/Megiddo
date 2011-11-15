<?php
/**
 * Log class
 * @author Marco Antonio Sugamele <marco@iaol.com.br>
 * @since 10/12/2009
 * Class responsible for the System Log
 * Last revision : 13/02/2010
 */
class Log extends LogPeer {

    /**
     * Returns the log for the primary key
     * @param interger $idLog
     * @return Object
     */
    public static function retriveByPk($idLog) {
        $criteria = new Criteria();
        $criteria->add(self::ID, $idLog);
        $criteria->setLimit(1);
        $objLog = new Log();
        return $objLog->doSelectOne($criteria);
    }

    /**
     * Returns the log object by date (yyyy-mm-dd)
     * @param date $date
     * @param integer $limit
     * @return ArrayObject
     */
    public static function retriveByDate($date, $limit = null) {
        $criteria = new Criteria();
        $criteria->add(self::DATE, $date . '%', Criteria::LIKE);
        $criteria->addOrderBy(self::DATE, Criteria::ORDER_BY_DESC);
        if (!is_null($limit)) {
            $criteria->setLimit($limit);
        }
        $objLog = new Log();
        return $objLog->doSelect($criteria);
    }

    /**
     * Returns the log for the error (if error or not)
     * @param interger $error (1 = erro | 0 = ok)
     * @param integer  $limit
     * @return Object
     */
    public static function retriveByError($error, $limit = null) {
        $criteria = new Criteria();
        $criteria->add(self::IS_ERROR, $error);
        if (!is_null($limit)) {
            $criteria->setLimit($limit);
        }
        $objLog = new Log();
        return $objLog->doSelect($criteria);
    
    }

    /**
     * Returns the log object      
     * @param integer  $limit
     * @return Object
     */
    public function getLog($limit = null) {
        $criteria = new Criteria();
        $criteria->addNotWhere();
        if (!is_null($limit)) {
            $criteria->setLimit($limit);
        }
        $objLog = new Log();
        return $objLog->doSelect($criteria);
    }

    
	/**
     * Returns the log object      
     * @param integer  $limit
     * @return Object
     */
    public function getLogDesc($limit = null) {
        $criteria = new Criteria();
        $criteria->addNotWhere();
        if (!is_null($limit)) {
            $criteria->setLimit($limit);
        }
        $criteria->addOrderBy(LogPeer::ID, 'DESC');
        $objLog = new Log();
        return $objLog->doSelect($criteria);
    }
    
    /**
     * Logging the message in the system
     * @param string $file
     * @param string $message
     * @param interger $isError
     * @param interger $idSite
     * @return Boolean
     */
    public function setLog($file, $message, $isError = true) {
        $this->setDate(date('Y-m-d H:i:s'));
        $this->setFile($file);
        $this->setIsError($isError);
        $this->setMessage($message);
        $this->save();
    
    }

}
