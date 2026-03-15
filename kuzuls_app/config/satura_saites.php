<?php

return [
    // Keep this list small & relevant. Add more any time.
    'cities' => [
        'rīga','cesis','cēsis','jelgava','liepāja','daugavpils','ventspils','rezekne','rēzekne',
        'jūrmala','valmiera','ogre','tukums','sigulda','kuldīga','talsi','madona','jēkabpils',
    ],

    // “Meaning groups” that should strongly connect content.
    // You can add/edit these freely.
    'activity_groups' => [
        'kafija_karjera' => ['kafija','kafejnīca','kafe','cv','karjera','linkedin','darbs','vakars','konsultants'],
        'joga_sports'    => ['joga','sports','treniņš','kustība','skriešana','fitness','vingrošana'],
        'tirgus_amatnieki'=> ['tirgus','tirdziņš','amatnieki','roku','darbi','pavasara','ziemas','vasaras'],
    ],

    // Weights (tune later)
    'weights' => [
        'text' => 1.0,
        'city_exact' => 22,      // same city match
        'category' => 14,        // same kategorija_id
        'time_close_max' => 18,  // max time proximity bonus
        'group_match' => 16,     // same activity group match
        'bigram' => 10,          // phrase/bigram match bonus
    ],
];