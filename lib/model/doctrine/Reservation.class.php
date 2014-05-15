<?php

/**
 * Reservation
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    simde
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Reservation extends BaseReservation
{
/*
	public function __toString()
	{

	}
*/
	private $userValid;
	private $userReserve;

	public function getUserValid()
	{
		if (isset($userValid))
			return $userValid;
			
		return $userValid = sfGuardUserTable::getInstance()->getUserById($this->getIdUserValid())->execute()[0];
	}
	
	public function getUserReserve()
	{
		if (isset($userReserve))
			return $userReserve;
			
		return $userReserve = sfGuardUserTable::getInstance()->getUserById($this->getIdUserReserve())->execute()[0];
	}

}
