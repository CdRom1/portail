<?php

/**
 * BasePhotos
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $order_photo
 * @property integer $gallery_id
 * @property Gallery $Gallery
 * 
 * @method integer getOrderPhoto()  Returns the current record's "order_photo" value
 * @method integer getGalleryId()   Returns the current record's "gallery_id" value
 * @method Gallery getGallery()     Returns the current record's "Gallery" value
 * @method Photos  setOrderPhoto()  Sets the current record's "order_photo" value
 * @method Photos  setGalleryId()   Sets the current record's "gallery_id" value
 * @method Photos  setGallery()     Sets the current record's "Gallery" value
 * 
 * @package    simde
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BasePhotos extends GalleryneFile
{
    public function setTableDefinition()
    {
        parent::setTableDefinition();
        $this->setTableName('photos');
        $this->hasColumn('order_photo', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));
        $this->hasColumn('gallery_id', 'integer', null, array(
             'type' => 'integer',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Gallery', array(
             'local' => 'gallery_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));
    }
}