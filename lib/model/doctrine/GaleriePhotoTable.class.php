<?php

/**
 * GaleriePhotoTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class GaleriePhotoTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object GaleriePhotoTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('GaleriePhoto');
    }
    
    public function getAllGaleries(){
        $q = $this->createQuery('gal')
        	->select('gal.*')
        	->addOrderBy('gal.created_at DESC');
        return $q;
    }
    
    
    

}