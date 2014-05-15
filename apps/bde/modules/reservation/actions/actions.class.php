<?php

/**
 * reservation actions.
 *
 * @package    simde
 * @subpackage reservation
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class reservationActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
  		$this->param = "index";
  }
  
  /**
  *	Toute la gestion des salles
  **/
  
  public function executeSalle(sfWebRequest $request)
  {
  		$this->param = "salle";
  		
  		$this->salles = SalleTable::getInstance()->getAllSalles()->execute();
  }
  
  public function executeSalleUpdate(sfWebRequest $request)
  {
  
  		$this->param = "salle";
  		
  		$this->id = $request->getParameter('id',-1);
  		
  		$this->forward404Unless(SalleTable::getInstance()->isSalleExist($this->id));
  
  		$this->salle_modif = SalleTable::getInstance()->getSalleById($this->id)->execute()[0];
		
		$this->form = new SalleForm($this->salle_modif);
  		
  		$this->update = false;
  		
  		if ($request->isMethod('post'))
  		{
  			$this->form->bind($request->getParameter($this->form->getName()));
		
			if ($this->form->isValid())
			{
				$this->salle = $this->form->save();
				$this->update = true;
			}
  		}
  		

  }
  
  public function executeSalleNew(sfWebRequest $request)
  {
  		$this->param = "salle";
  		
  		$this->form = new SalleForm();
  
  		if ($request->isMethod('post'))
  		{
  			$this->form->bind($request->getParameter($this->form->getName()));
		
			if ($this->form->isValid())
			{
				$this->salle = $this->form->save();
			}
  		}
   
  }
  
  public function executeSalleDelete(sfWebRequest $request)
  {
  		$this->param = "salle";
  		
  		$this->id = $request->getParameter('id',-1);
  		
  		$this->forward404Unless(SalleTable::getInstance()->isSalleExist($this->id));
  		
  		$this->salle = SalleTable::getInstance()->getSalleById($this->id)->execute()[0];
  		
  		$this->suppr = false;
  		
  		if ($request->isMethod('post'))
  		{
  			SalleTable::getInstance()->deleteSalle($this->id)->execute();
  			
  			$this->suppr = true;
  		}

  }
  
  /**
  *	Toute la gestion des reservations à valider
  */
  
  public function executeValidation(sfWebRequest $request)
  {
   	$this->param = "validation";
   	
   	$this->id = $request->getParameter('id',-1);
   	
   	// Affichage liste non validé
   	if ($this->id == -1)
   	{
   		$this->reservations = ReservationTable::getInstance()->getReservationNoValide()->execute();
   	}
   	else
   	{
   		$this->forward404Unless(ReservationTable::getInstance()->isReservationNoValidExist($this->id));
   		
   		$this->reservation = ReservationTable::getInstance()->getReservationById($this->id)->execute()[0];
   	}	
  }
  
  public function executeValidationValid(sfWebRequest $request)
  {
		if (!$request->isMethod('post'))
  		{
  			$this->forward404Unless(false);
  		}  
  
   	$this->param = "validation";
   	
   	$this->id = $request->getParameter('id',-1);
   	
   	// Erreur si pas d'id
   	if ($this->id == -1)
   	{
   		$this->forward404Unless(false);
   	}
   	else // Tout est OK !
   	{
  	
   		$this->forward404Unless(ReservationTable::getInstance()->isReservationNoValidExist($this->id));
   	
   		$this->reservation = ReservationTable::getInstance()->getReservationById($this->id)->execute()[0];
   		
   		$accepter = $request->getParameter("accepter",false); 
   		$refuser = $request->getParameter("refuser",false);
   		
   		$this->commentaire = $request->getParameter("commentaire","");

			$mailDestinataire = $this->reservation->getUserReserve()->getEmailAddress();

   		// Si accepter => valide la reservation, ajoute la personne qui a validé, update base
   		if ($accepter && !$refuser)
   		{
   			$this->valider = true;
   			$this->reservation->setEstvalide(true);
   			$this->reservation->setIdUserValid($this->getUser()->getGuardUser()->getId());
   			$this->reservation->save();
   			
   			$this->mail = $this->sendMail(
							$this->reservation->getSalle(),
							$this->reservation,
							$mailDestinataire,
							$this->commentaire,
							$this->valider
							);
   			
   		}
   		// Si refuser => on supprime la reservation de la base
   		else if ($refuser && !$accepter)
   		{
   			$this->valider = false;
   			
   			$this->mail = $this->sendMail(
							$this->reservation->getSalle(),
							$this->reservation,
							$mailDestinataire,
							$this->commentaire,
							$this->valider
							);
   			
   			$this->reservation->delete();
   		}
   		else
   		{
   			$this->forward404Unless(false);
   		}
   		
   	}	
  }
  
  // Gestion des reservations dans son ensemble
  public function executeGestion(sfWebRequest $request)
  {
  		$this->param = "gestion";
  
  
  }
  
  /**
  *	Envoie un mail
  * 	/return le contenu du mail
  *
  */
  private function sendMail($nameSalle,$reservation,$destinataire,$commentaire,$estValide)
  {
  		$mailContent = 'Bonjour,'."\n\n";
   	$mailContent .= 'Votre demande de la salle '.$nameSalle.' a été ';
  
  		if ($estValide)
			$mailContent .= 'validée.'."\n\n";
		else
			$mailContent .= 'refusée.'."\n\n";
			
		$mailContent .= 'Rappel de la réservation : '."\n\n";
		$mailContent .= 'Date : '.date("j/n/Y",strtotime(str_replace('-','/', $reservation->getDate())))."\n";
		$mailContent .= 'Heure Debut : '.$reservation->getHeuredebut()."\n";
		$mailContent .= 'Heure Fin : '.$reservation->getHeurefin()."\n\n";
		
		if (trim($commentaire) != "")
		{
		
			$mailContent .= 'Commentaire :'."\n";
			$mailContent .= $commentaire."\n\n";
		
		}
		
		$mailContent .= 'Ceci est un mail automatique'."\n";
		$mailContent .= 'BDE'."\n";
		
		// Envoi d'un mail de confirmation
		$message = $this->getMailer()->compose(
			array('bde@assos.utc.fr' => 'BDE'),
			$destinataire,
			'Reservation d\'une salle',
			$mailContent
		);
		
		//$this->getMailer()->send($message);
		
		return $mailContent;
  }
  
}
