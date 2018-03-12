<?php	// UTF-8 marker äöüÄÖÜß€

require_once './Page.php';
require_once './blocks/StatusTable.php';

class Status extends Page
{
    private $statusTable;
    private $_order;
    
    protected function __construct() 
    {
        parent::__construct();
        $this->statusTable = new StatusTable($this->_database);
        //session_start();
    }
    
    protected function __destruct() 
    {
        parent::__destruct();
    }

    protected function getViewData()
    {
        if (isset($_SESSION['lastOrder'])) {   
            $lastOrder = $_SESSION['lastOrder'];          
            $SQLabfrage = "SELECT supply.pizzaName, orderedPizza.status FROM orderedPizza
                        INNER JOIN supply ON supply.id = orderedPizza.fID INNER JOIN orderPizza ON orderPizza.orderID = orderedPizza.fOrderID
                        WHERE orderedPizza.fOrderID = \"$lastOrder\"";
            $Recordset = $this->_database->query ($SQLabfrage);
            if(!$Recordset){
                throw new Exception("Error in database query: ".$this->_database->error);
            }
            if ($Recordset) {
                $Record = $Recordset->fetch_assoc();
                while ($Record) {
                    $name = $Record["pizzaName"];
                    $status = $Record["status"];
                    $this->_order[] = array('name'   => $name, 'status' => $status);
                    $Record = $Recordset->fetch_assoc();
                }
            }
        }
    }
    
    protected function generateView() 
    {
        $this->getViewData();
        $this->generatePageHeader('Status', true);
        $styleBox = "order_box_customer";

        echo <<<EOF
        <h1>Kunde</h1>
EOF;

    if (empty($this->_order)) {
        echo '<p>Keine aktiven Bestellungen!</p>' . PHP_EOL;
    } else {
        $columns = array('bestellt', 'im Ofen', 'fertig', 'unterwegs');
        $this->statusTable->generateView('status', null, $columns, $this->_order, $styleBox);
    }

    echo <<<EOF
        <ul>
            <li> 
                <a href="Order.php">Neue Bestellung</a>
            </li>
        </ul>
EOF;

        $this->generatePageFooter();
    }
    
    protected function processReceivedData() 
    {
        parent::processReceivedData();
    }
   
    public static function main() 
    {
        try {
            $page = new Status();
            $page->processReceivedData();
            $page->generateView();
        }
        catch (Exception $e) {
            header("Content-type: text/plain; charset=UTF-8");
            echo $e->getMessage();
        }
    }
}

// This call is starting the creation of the page. 
// That is input is processed and output is created.
Status::main(); 
?>