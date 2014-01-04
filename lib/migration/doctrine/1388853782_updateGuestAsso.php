<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version81 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->createForeignKey('event_guest_asso', 'event_guest_asso_asso_id_asso_id', array(
             'name' => 'event_guest_asso_asso_id_asso_id',
             'local' => 'asso_id',
             'foreign' => 'id',
             'foreignTable' => 'asso',
             ));
        $this->createForeignKey('event_guest_asso', 'event_guest_asso_event_id_event_id', array(
             'name' => 'event_guest_asso_event_id_event_id',
             'local' => 'event_id',
             'foreign' => 'id',
             'foreignTable' => 'event',
             ));
        $this->addIndex('event_guest_asso', 'event_guest_asso_asso_id', array(
             'fields' => 
             array(
              0 => 'asso_id',
             ),
             ));
        $this->addIndex('event_guest_asso', 'event_guest_asso_event_id', array(
             'fields' => 
             array(
              0 => 'event_id',
             ),
             ));
    }

    public function down()
    {
        $this->dropForeignKey('event_guest_asso', 'event_guest_asso_asso_id_asso_id');
        $this->dropForeignKey('event_guest_asso', 'event_guest_asso_event_id_event_id');
        $this->removeIndex('event_guest_asso', 'event_guest_asso_asso_id', array(
             'fields' => 
             array(
              0 => 'asso_id',
             ),
             ));
        $this->removeIndex('event_guest_asso', 'event_guest_asso_event_id', array(
             'fields' => 
             array(
              0 => 'event_id',
             ),
             ));
    }
}