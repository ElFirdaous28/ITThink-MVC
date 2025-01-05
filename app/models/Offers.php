<?php
require_once(__DIR__ . '/../config/db.php');
class Offer extends Db
{

    public function __construct()
    {
        parent::__construct();
    }
    
    // methode to get client offers
    public function clientOffers(){
        $user_id = $_SESSION['user_loged_in_id'];
        $query = $this->conn->prepare("SELECT o.delai,o.montant,o.id_offre,o.id_utilisateur,o.id_projet,o.status,p.titre_projet FROM offres o
                                JOIN projets p ON p.id_projet=o.id_projet
                                WHERE p.id_utilisateur=?
                                AND o.status!=3;");
        $query->execute([$user_id]);
        $client_offers = $query->fetchAll(PDO::FETCH_ASSOC);
        return $client_offers;
    }

    // methode to accept an offer
    public function acceptOffre($idOffre){
        $acceptOffre = $this->conn->prepare("UPDATE offres
                                        SET status=2
                                        WHERE id_offre=?");
        $acceptOffre->execute([$idOffre]);
    }
}
