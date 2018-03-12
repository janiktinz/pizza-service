<?php	// UTF-8 marker äöüÄÖÜß€

require_once './Page.php';

class Driver extends Page
{
    protected function __construct() 
    {
        parent::__construct();
    }
    
    protected function __destruct() 
    {
        parent::__destruct();
    }

    protected function getViewData()
    {
        $SQLabfrage = "SELECT supply.pizzaName, supply.price, orderPizza.orderID, orderPizza.addressCustomer, orderedPizza.status FROM orderedPizza
                INNER JOIN supply ON supply.id = orderedPizza.fID
                INNER JOIN orderPizza ON orderPizza.orderID = orderedPizza.fOrderID
                WHERE orderedPizza.status >= 0 ORDER BY orderPizza.orderID";
	    $Recordset = $this->_database->query ($SQLabfrage);
        if($Recordset){
            $this->_orders = array();
            
            // This values will be resetted on every new order
            $currentOrder = 0;
            $Record = $Recordset->fetch_assoc();
            while ($Record) {
                $name = $Record["pizzaName"];
                $price = $Record["price"];
                $id = $Record["orderID"];
                $address = $Record["addressCustomer"];
                $status = $Record["status"];

                if ($id != $currentOrder) {
                    $this->_orders[$id] = array('list' => '', 'price' => 0, 'address' => $address, 'status' => $status);
                    $currentOrder = $id;
                }
                else{
                    if($this->_orders[$id]['status'] > $status){
                        $this->_orders[$id]['status'] = $status;
                    }
                }
                if (strlen($this->_orders[$id]['list']) > 0) {
                    $this->_orders[$id]['list'] .= ', ';
                }
                $this->_orders[$id]['list']  .= $name;
                $this->_orders[$id]['price'] += $price;
                $Record = $Recordset->fetch_assoc();
            }          
		}
		else{
			throw new Exception("Error in query: ".$this->_database->error);
		}
    }
    
    protected function generateView() 
    {
        $this->getViewData();
        $this->generatePageHeader('Fahrer', true);
        echo <<<EOF
        <h1 >Fahrer</h1>    
EOF;
        echo <<<EOF
        <form class="order" action="Driver.php" method="POST">
EOF;
        $columns = array('gebacken', 'unterwegs ', 'ausgeliefert');

        foreach ($this->_orders as $key => $order) {
            if($order['status'] >= 2){
                $last = $key == count($this->_orders) - 1;
                
                $price = number_format($order['price'] / 100, 2);
                $address = htmlspecialchars($order['address']);

                echo <<<EOF
                <section class=order_box_driver>
                    <h2>{$address}</h2>
                    
                    <p>
                    {$order['list']} 
                    </p>
                    
                    <p>
                    Preis: {$price} €
                    </p>
EOF;
                for ($j = 0; $j < count($columns); ++$j) {
                    $checked = "";
                    $i = $j+2;
                    if($i == $order['status']){
                        $checked = ' checked';
                    }
                echo <<<EOF
                    <label>{$columns[$j]}
EOF;
                
                echo <<<EOF
                        <input type="radio" name="{$key}" class="status_button"{$checked} value="$i"/> 
                    </label>
EOF;
                }
                echo "</section>";
                

                if (!$last) {
                    echo '<hr>';
                }
            }
        }
        echo <<<EOF
        </form>
EOF;
        $this->generatePageFooter();
    }
    
    protected function processReceivedData() 
    {
        parent::processReceivedData();

        if (isset($_POST)) {     
            foreach ($_POST as $id => $status) {
                if($status == 4){
                    $SQLabfrage = "DELETE FROM orderPizza WHERE orderID = \"$id\"";
                    $Recordset = $this->_database->query ($SQLabfrage);
                    if (!$Recordset)
                        throw new Exception("Error in query: ".$this->_database->error);   
                    break;
                }
                $SQLabfrage = "UPDATE orderedPizza SET status = \"$status\" WHERE fOrderID = \"$id\"";
                $Recordset = $this->_database->query ($SQLabfrage);  
                if (!$Recordset)
                    throw new Exception("Error in query: ".$this->_database->error);
            }
        }
    }

    public static function main() 
    {
        try {
            $page = new Driver();
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
Driver::main(); 
?>