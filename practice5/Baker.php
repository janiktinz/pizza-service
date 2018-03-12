<?php	// UTF-8 marker äöüÄÖÜß€

require_once './Page.php';
require_once './blocks/StatusTable.php';

class Baker extends Page
{
    private $statusTable;
    public $_statusTmp = 0;
    
    protected function __construct() 
    {
        parent::__construct();
        $this->statusTable= new StatusTable($this->_database);
    }
      
    protected function __destruct() 
    {
        parent::__destruct();
    }

    protected function getViewData()
    {
      $SQLabfrage = "SELECT supply.pizzaName, supply.id, orderedPizza.pizzaID, orderedPizza.status, orderedPizza.fOrderID
        FROM orderedPizza
        INNER JOIN supply ON supply.id = orderedPizza.fID";
        $Recordset = $this->_database->query ($SQLabfrage);
        if ($Recordset) {
          $this->_orders = array();
          $Record = $Recordset->fetch_assoc();
          while ($Record) {
            $name = $Record["pizzaName"];
            $supplyId = $Record["id"];
            $pizzaId = $Record["pizzaID"];
            $status = $Record["status"];
            $orderId = $Record["fOrderID"];

            $this->_statusTmp = $status;
            if($status > 2){
              $status = 2;
            }
            if (!isset($this->_orders[$orderId])) {
              $this->_orders[$orderId] = array();
            }

            $this->_orders[$orderId][$pizzaId] = array('id' => $supplyId, 'name' => $name, 'status' => $status);
            $Record = $Recordset->fetch_assoc();
          }
        }
    }
    
    protected function generateView() 
    {
        $this->getViewData();
        $this->generatePageHeader('Bäcker', true);

        $columns = array('bestellt', 'im Ofen', 'fertig');
        $url = 'Baker.php';
        $styleBox = "order_box_baker";

        echo <<<EOF
        <h1>Bäcker</h1>             
EOF;
        echo '<form action="' . $url . '" method="POST">';
        foreach ($this->_orders as $order) {
          $this->statusTable->generateView(null, null, $columns,
                                              $order, $styleBox, true);
          echo '<hr>' . PHP_EOL;
        }
        echo '</form>' . PHP_EOL;

        $this->generatePageFooter();
    }
    
    protected function processReceivedData() 
    {
        parent::processReceivedData();

        if (isset($_POST['order'])) {
            foreach ($_POST['order'] as $id => $status) {
              if($this->_statusTmp > 2){
                $status = $this->_statusTmp;
              }
              $SQLabfrage = "UPDATE orderedPizza SET status = \"$status\" WHERE pizzaID = \"$id\"";
              $this->_database->query($SQLabfrage);
            }

            // Check if an order is finished
            $SQLabfrage = "SELECT fOrderID, status FROM orderedPizza";
            $Recordset = $this->_database->query ($SQLabfrage);
            if ($Recordset) {
              $orders = array();
              $Record = $Recordset->fetch_assoc();
              while ($Record) {
                $orderId = $Record["fOrderID"];
                $status = $Record["status"];
                // Create entry if not already exists
                if (!isset($orders[$orderId])) {
                  $orders[$orderId] = true;
                }
  
                // Status 2 == finished
                $orders[$orderId] = $orders[$orderId] && $status == 2;
                $Record = $Recordset->fetch_assoc();
              }
            }
        }
    }
   
    public static function main() 
    {
        try {
            $page = new Baker();
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
Baker::main();
?>