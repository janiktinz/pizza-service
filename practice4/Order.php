<?php	// UTF-8 marker äöüÄÖÜß€

require_once './Page.php';

class Order extends Page
{
    // to do: declare reference variables for members 
    // representing substructures/blocks
    
    /**
     * Instantiates members (to be defined above).   
     * Calls the constructor of the parent i.e. page class.
     * So the database connection is established.
     *
     * @return none
     */
    protected function __construct() 
    {
        parent::__construct();
        // to do: instantiate members representing substructures/blocks
    }
    
    /**
     * Cleans up what ever is needed.   
     * Calls the destructor of the parent i.e. page class.
     * So the database connection is closed.
     *
     * @return none
     */
    protected function __destruct() 
    {
        parent::__destruct();
    }

    /**
     * Fetch all data that is necessary for later output.
     * Data is stored in an easily accessible way e.g. as associative array.
     *
     * @return none
     */
    protected function getViewData()
    {
        // to do: fetch data for this view from the database
    }
    
    /**
     * First the necessary data is fetched and then the HTML is 
     * assembled for output. i.e. the header is generated, the content
     * of the page ("view") is inserted and -if avaialable- the content of 
     * all views contained is generated.
     * Finally the footer is added.
     *
     * @return none
     */
    protected function generateView() 
    {
        $this->getViewData();
        $this->generatePageHeader('Bestellung');
        echo <<<EOF
        <img id=main_image src="images/pizza.jpg" alt="Pizza" title="Pizza" />
        <h1>Bestellung</h1>
        
        <div class=order_box_order>
            
            <img src="images/pizza-margherita.png" id="margherita" class="pizza_image" data-price="4.00" name="Margherita" alt="Margherita Pizza" title="Margherita Pizza" onclick="cart.addPizza('margherita')"/>
            <p class="pizza_label">
            Margherita 4,00 €
            </p>

            
            <img src="images/pizza-margherita.png" id="salami" class="pizza_image" data-price="4.50" name="Salami" alt="Salami Pizza" title="Salami Pizza" onclick="cart.addPizza('salami')" /> 
            <p class="pizza_label">       
            Salami 4,50 €
            </p>

            
            <img src="images/pizza-margherita.png" id="hawaii" class="pizza_image" data-price="5.50" name="Hawaii" alt="Hawaii Pizza" title="Hawaii Pizza" onclick="cart.addPizza('hawaii')"/>
            <p class="pizza_label">  
            Hawaii 5,50 €
            </p>
            
        </div>
        
        <div class="cart">
            <form action="https://www.fbi.h-da.de/cgi-bin/Echo.pl" id="order_form" accept-charset="UTF-8" onsubmit="return cart.submit()" method="get">
                <select name="orders[]" id="orders" multiple size="8"></select>

                <p>
                    <span id="sum">0,00</span> €
                </p>
                
                <input id="address" type="text" name="address" value="" size="30" maxlength="70" placeholder="Name, PLZ, Ort, Straße + Hausnummer" />
                <input id="delete-all" type="reset" name="delete-all" value="Alle Löschen" onclick="cart.reset()"/>
                <input id="delete-selected" type="reset" name="delete-selected" value="Auswahl Löschen" onclick="cart.removePizza()"/>
                <input id="order" type="submit" />
            </form>
        </div>
EOF;
        $this->generatePageFooter();
    }
    
    /**
     * Processes the data that comes via GET or POST i.e. CGI.
     * If this page is supposed to do something with submitted
     * data do it here. 
     * If the page contains blocks, delegate processing of the 
	 * respective subsets of data to them.
     *
     * @return none 
     */
    protected function processReceivedData() 
    {
        parent::processReceivedData();
        // to do: call processReceivedData() for all members
    }

    /**
     * This main-function has the only purpose to create an instance 
     * of the class and to get all the things going.
     * I.e. the operations of the class are called to produce
     * the output of the HTML-file.
     * The name "main" is no keyword for php. It is just used to
     * indicate that function as the central starting point.
     * To make it simpler this is a static function. That is you can simply
     * call it without first creating an instance of the class.
     *
     * @return none 
     */    
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

// Zend standard does not like closing php-tag!
// PHP doesn't require the closing tag (it is assumed when the file ends). 
// Not specifying the closing ? >  helps to prevent accidents 
// like additional whitespace which will cause session 
// initialization to fail ("headers already sent"). 
//? >