<?php

class Trader{

    public static function getAllTrader()
    {
        $req = Database::getDatabase()->prepare("SELECT * FROM trader");
        $req->execute();
        return $req->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function getAction($numTrader)
    {
        $db = Database::getDatabase();
        $req = $db->prepare("SELECT c.numAction, a.nomAction, c.quantite, c.montantAchat, 
        (c.quantite * c.montantAchat) AS Total FROM acheter AS c JOIN action a ON a.idAction = c.numAction WHERE numTrader = ?");
        $req->bindParam(1, $numTrader, PDO::PARAM_INT);
        $req->execute();

        $result = $req->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public static function sellAction($numTrader, $numAction, $quantitySell)
{
    $db = Database::getDatabase();

    $selectQuery = $db->prepare("SELECT quantite FROM acheter WHERE numAction = ? AND numTrader = ?");
    $selectQuery->bindParam(1, $numAction, PDO::PARAM_INT);
    $selectQuery->bindParam(2, $numTrader, PDO::PARAM_INT);
    $selectQuery->execute();
    $result = $selectQuery->fetch(PDO::FETCH_ASSOC);

    if ($result["quantite"] - $quantitySell < 0) {
        return false;
    }

    if($result["quantite"] == $quantitySell)
    {
        $updateQuery = $db->prepare("DELETE FROM acheter WHERE numAction = ? AND numTrader = ?");
        $updateQuery->bindParam(1, $numAction, PDO::PARAM_INT);
        $updateQuery->bindParam(2, $numTrader, PDO::PARAM_INT);
        $updateQuery->execute();
        return true;
    }

    $updateQuery = $db->prepare("UPDATE acheter SET quantite = quantite - ? WHERE numAction = ? AND numTrader = ?");
    $updateQuery->bindParam(1, $quantitySell, PDO::PARAM_INT);
    $updateQuery->bindParam(2, $numAction, PDO::PARAM_INT);
    $updateQuery->bindParam(3, $numTrader, PDO::PARAM_INT);
    $updateQuery->execute();

    return true;
}

    public static function getCanva()
    {
        $db = Database::getDatabase();
        $req = $db->prepare("SELECT * FROM trader AS t JOIN acheter AS a ON t.idTrader = a.numTrader JOIN action AS ac ON ac.idAction = a.numAction");
        $req->execute();
        $result = $req->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}

?>