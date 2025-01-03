<?php
require_once(__DIR__ . '/../config/db.php');
class Testimonials extends Db
{

    public function __construct()
    {
        parent::__construct();
    }

    // methode to see all testimonials
    function allTestimonials() {
        // Base query
        $queryStr = "SELECT p.titre_projet, t.commentaire, t.id_temoignage, o.montant, o.delai, o.id_offre
                    FROM temoignages t
                    JOIN offres o ON t.id_offre = o.id_offre
                    JOIN projets p ON o.id_projet = p.id_projet";

        $query = $this->conn->prepare($queryStr);
        $query->execute();

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // methode to delete a testimonal
    function removeTestimonial($idtesTimonial){
        $removeTestimonial = $this->conn->prepare("DELETE FROM temoignages WHERE id_temoignage=?");
        $removeTestimonial->execute([$idtesTimonial]);
    }
}
