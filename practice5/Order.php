<?php	// UTF-8 marker äöüÄÖÜß€

require_once './Page.php';
require_once './blocks/Menu.php';
require_once './blocks/ShoppingCart.php';

class Order extends Page
{
    private $_menu;
    private $_cart;
    
    protected function __construct() 
    {
        parent::__construct();
        
        // Initialize members
        $this->_menu = new Menu($this->_database);
        $this->_cart   = new ShoppingCart($this->_database);
    }
    
    protected function __destruct() 
    {
        parent::__destruct();
    }

    protected function getViewData()
    {
        $SQLabfrage = "SELECT id, image, pizzaName, price FROM supply";
        $Recordset = $this->_database->query ($SQLabfrage);

        if (!$Recordset)
	        throw new Exception("Keine Pizza in der Datenbank");

        if ($Recordset) {
            $Record = $Recordset->fetch_assoc();
            while ($Record) {
                $pizzen[] = array(
                    'id'    => $Record["id"],
                    'image' => $Record["image"],
                    'name'  => $Record["pizzaName"],
                    'price' => $Record["price"]
                );
                $Record = $Recordset->fetch_assoc();
            }
            $Recordset->free();
        }
        return $pizzen;
    }
    
    protected function generateView() 
    {
        $pizzen = $this->getViewData();
        $this->generatePageHeader('Bestellung', false);
        echo <<<EOF
        <img id=main_image src="images/pizza.jpg" alt="Pizza" title="Pizza" />
        <h1>Bestellung</h1>
EOF;
        $this->_menu->generateView('menu', $pizzen);
        $this->_cart->generateView('cart', 'Order.php');

        $this->generatePageFooter();
    }
    
    protected function processReceivedData() 
    {
        parent::processReceivedData();
        if (isset($_POST['orders'], $_POST['address']) && count($_POST['orders']) > 0 && strlen($_POST['address']) > 0) {
            $address = $_POST['address'];
            $sqlAddressCustomer = $this->_database->real_escape_string($address);
            $SQLabfrage = "INSERT INTO orderPizza SET addressCustomer = \"$address\", orderTimestamp = \"CURRENT_TIMESTAMP\"";
					
            if ($this->_database->query($SQLabfrage)) {
                $orderId = $this->_database->insert_id;
                $_SESSION['lastOrder'] = $orderId;

                $status = 0;
                foreach ($_POST['orders'] as $order) {
                    $data = json_decode($order, true);
                    $id = $data['id'];
                    for($i = 0; $i < $data['count']; $i++){
                        $SQLabfrage = "INSERT INTO orderedPizza SET fID = \"$id\", fOrderID = \"$orderId\", status = \"$status\"";
                        $this->_database->query ($SQLabfrage);
                    }
                }
                header('Location: Status.php');
            }
        }
    }
   
    public static function main() 
    {
        try {
            $page = new Order();
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
Order::main();
?>