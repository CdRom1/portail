<?php

/**
 * Document
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    simde
 * @author     Florent Thévenet
 */
class Document extends BaseDocument
{
    public function __toString()
    {
        return $this->getNom();
    }

    public static function getPathForAsso($asso) {
        return sfConfig::get('app_portail_dossier_assos') . '/' . $asso->getLogin() . '/documents/';
    }

    public function getPath() {
        return $this::getPathForAsso($this->getAsso()) . $this->getDocumentType()->getSlug() . '/' . $this->getFichier();
    }

    public function deleteAndUnlink() {
        unlink($this->getPath());
        $this->delete();
    }

    public function generatePDF($title = 'BDE-UTC: Outil de trésorerie', $nom, $html, $culture = 'fr') {
        $this->fichier = $nom . '.pdf';
        $pdf = new Pdf($this->getAsso(), $title);
        return $pdf->generate($this->getDocumentType()->getSlug(), $html, $nom);
    }

    public function setTypeFromSlug($slug) {
        $this->setDocumentType(DocumentTypeTable::getInstance()->findOneBySlug($slug));
    }

    public function getTypeSlug() {
        return $this->DocumentType->getSlug();
    }
}
