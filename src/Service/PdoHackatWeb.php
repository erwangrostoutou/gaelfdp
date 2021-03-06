<?php
namespace App\Service;

use App\Entity\Hackathon;
use PDO;
use App\Entity\Series;

class PdoHackatWeb 
{
    private static $monPdo;
    

    /*
    Constructeur utilisé lorsque le service est configuré dans services.yaml
    public function __construct($serveur,$bdd,$user,$mdp) 
    {
        PdoHackatWeb::$monPdo=new PDO($serveur.';'.$bdd,$user,$mdp);
        PdoHackatWeb::$monPdo->query("SET CHARACTER SET utf8");
    }*/

    //autre méthode qui vont exécuter des requêtes sql
    public function __construct() 
    {
        $serveur= 'mysql:host=127.0.0.1:3307';
        $bdd= 'dbname=smarrier_hackathon';
        $user= 'root';
        $mdp=''; 
        PdoHackatWeb::$monPdo=new PDO($serveur.';'.$bdd,$user,$mdp);
        PdoHackatWeb::$monPdo->query("SET CHARACTER SET utf8");
    }

    

    public function getLesHackathons(){
        $req =  PdoHackatWeb::$monPdo->prepare("select * from  Hackathon");
		$req->execute(); 
		$lesLignes = $req->fetchAll();
		$hackathons = [];
		foreach ($lesLignes as $uneLigne)
		{
		  $hackathons[] = new Hackathon($uneLigne);
		}
        var_dump($hackathons);
		return $hackathons;
    }

    public function getLesVilles(){
        $req =  PdoHackatWeb::$monPdo->prepare("select distinct (ville) from Hackathon where ville IS NOT NULL");
		$req->execute(); 
		$lesVilles = $req->fetchAll();
		$villes = [];
		foreach ($lesVilles as $uneVille)
		{
		  $villes[] = new Hackathon($uneVille);
		}
        var_dump($villes);
		return $villes;
    }

    public function setUser($user){
        
        $req =  PdoHackatWeb::$monPdo->prepare("insert into participant(Mail, Password) values(:mail, :password)");
        $req->bindValue(':mail', $user['mail']);
        $req->bindValue(':password', $user['password']);
        dump($req);
		$req->execute();
    }
}