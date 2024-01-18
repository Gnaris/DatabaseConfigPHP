<?php

header("Access-Control-Allow-Origin: *");

require("./Database.php");
require("./Trader.php");

switch($_POST["action"])
    {
        case "getAllTrader": {
            echo json_encode(Trader::getAllTrader());
            break;
        }
        case "getAction" : {
            echo json_encode(Trader::getAction($_POST["traderID"]));
            break;
        }
        case "sellAction" : {
            echo json_encode(Trader::sellAction($_POST["traderID"], $_POST["actionID"], $_POST["quantity"]));
            break;
        }
        case "getCanva" : {
            echo json_encode(Trader::getCanva());
            break;
        }

        default : {
            echo "Error";
            break;
        }
    }


?>