<?php

require_once __DIR__ . '/config/connection.php';
require_once __DIR__ . '/functions/Utils.php';


//  DEFINE ALL REQUIRE tables and run this page

$tables = [ 

    'trades' => [
        " id INT NOT NULL AUTO_INCREMENT PRIMARY KEY",
        " setup_id INT ",
        " user_id INT NOT NULL",
        " index_product VARCHAR(255) ",
        " ss_img VARCHAR(512) ",
        " pnl ENUM('small_loss', 'big_loss', 'profit', 'big_profit') NOT NULL",
        " points INT(20)",
        " remark TEXT",
        " learning TEXT",
        " created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP",
    ],

    'setups' => [
        " id INT NOT NULL AUTO_INCREMENT PRIMARY KEY",
        " name VARCHAR(100)",
        " accuracy_avg INT(10)",
        " total_trades INT(20)",
        " win_rate INT(10)",
        " risk_reward_avg INT(10)",
        " images_available INT(10)",
        " type ENUM('revarsal', 'trending', 'scalping', 'all')  NOT NULL DEFAULT 'all' ",
        " time_frames VARCHAR(255)",
        " created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP",
    ],

    'user' => [
        " id INT NOT NULL AUTO_INCREMENT PRIMARY KEY",
        " username VARCHAR(120)",
        " email VARCHAR(120)",
        " cookie_token VARCHAR(255)",
        " password VARCHAR(512)",
        " profilePic VARCHAR(512)",
        " created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP",
    ],

];




$initialSeeds = [

    'user' => [
        ['username' => 'test', 'email' => 'abcd@aa.com', 'password' => 'aaa'],   
    ],     
];






// ========================== DONT CHANGE HERE ANYTHING =================================


try {


    $table_names = array_keys($tables);


    for ($i=0; $i < count($table_names) ; $i++) { 

        if(in_array($table_names[$i], $table_names)){
            // dropping table

            $st = RunQuery($conn, "DROP TABLE IF EXISTS {$table_names[$i]}");
            echo "Dropped table <b>{$table_names[$i]}</b><br>";
        }
    }

    echo CreateTables($conn, $tables);

    echo "<br>";

    // inserting seeds
    if(isset($initialSeeds)){
        if(count($initialSeeds)> 0) {
            insertSeeds($conn, $initialSeeds);
        }
    }

}
catch (Exception $e) {
    print_r($e->getMessage());
}


?>