<!-- Dieses SQL Statement liefert eine Liste aller geschlossenen Meldungen -->
<?php
$pdo = new PDO('mysql:host=localhost;dbname=tbec', 'root', '');
$statement = $pdo->prepare(
       "SELECT m.id as m_id,
	           m.timestamp as m_ts,
               m.melder_id as m_mid,
               um.username as um_name,
               m.meldung_art as m_art,
               m.etab_id as m_eid,
               e.name as e_name,
               m.cock_id as m_cid,
               c.name as c_name,
               m.user_id as m_uid,
               uu.username as uu_name
         FROM meldung m
            LEFT JOIN cock c 
                ON c.id = m.cock_id 
            LEFT JOIN etab e 
                ON e.id = m.etab_id 
            LEFT JOIN user um 
                ON um.id = m.melder_id
            LEFT JOIN user uu 
                ON uu.id = m.user_id
         WHERE status = 1
         ORDER BY m_ts DESC"
);
$result = $statement->execute();
$meldInfoClosed = $statement->fetchAll();
for ($i = 0; $i < count($meldInfoClosed); $i++) {
    $meldInfoClosed[$i]["m_ts"] = date("d.m.Y", strtotime($meldInfoClosed[$i]['m_ts']));
 }
$pdo = NULL;