<?php

/**
 * Created by PhpStorm.
 * User: katban
 * Date: 14.10.15
 * Time: 15:58
 */

include_once ("../config/dbconnect.php");
include_once ("client.class.php");
class ClientDAO
{
    /**
     * @return mixed
     */
    public function loadAll() {

        // SELECT ...
        $sql = 'SELECT * FROM clients';
        $clientsDb = $dbh->query($sql);
        if (count($clientsDb) > 0) {
            $clientsOb = new ArrayObject();
            foreach ($clientsDb as $client) {
//                $myObject = new Client();
//                $myObject->id = $client['id'];

                $myObject = new Client($client);
                $clientsOb->append($myObject);

            }
            return $clientsOb;
        }
        else
            return [];




//        // jeśli nie ma rekordów w bazie
//        return [];
//
//        // jeśli min. jeden rekord
//        $contactrs = new ArrayObject();
//
//        foreach rekords
//        $contactrs->append(createContact(wiersz_wyniku));
//
       // return $contactrs;
    }

    private function createClient($jedenWierszZBazy) {

    }

//
//    private createContact(wiersz)
//{
//    return new Contact(wiersz['inmie'], , dwd ,d)
//}
//}
}