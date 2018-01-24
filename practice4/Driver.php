<?php	// UTF-8 marker äöüÄÖÜß€

require_once './Page.php';

class Driver extends Page
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
        $this->generatePageHeader('Fahrer');
        echo <<<EOF
        <h1 >Fahrer</h1>    
               
        <section class=order_box_driver>
            <h2>Müller, Freßgasse 11, 6500 Frankfurt</h2>
            
            <p>
            Tonno, Calzone, Marghertita, Hawaii, Tonno 
            </p>
            
            <p>
            Preis: 13,00 €
            </p>
            
            <form action="https://www.fbi.h-da.de/cgi-bin/Echo.pl" id="driver_form1" accept-charset="UTF-8" method="get">
                <label>gebacken
                    <input type="radio" name="1" onclick="document.forms['driver_form1'].submit();" checked /> 
                </label>
                <label>unterwegs 
                    <input type="radio" name="1" onclick="document.forms['driver_form1'].submit();" />
                </label>
                <label>ausgeliefert
                    <input type="radio" name="1" onclick="document.forms['driver_form1'].submit();" />
                </label> 
            </form>
        </section>
        
        <section class=order_box_driver>
            <h2>Meier, Haupstraße 5</h2>
            
            <p>
            Tonno, Tonno, Marghertita, 
            </p>
            
            <p>
            Preis: 10,50 €
            </p>
            
            <form action="https://www.fbi.h-da.de/cgi-bin/Echo.pl" id="driver_form2" accept-charset="UTF-8" method="get">
                <label>gebacken
                    <input type="radio" name="2" onclick="document.forms['driver_form2'].submit();" checked /> 
                </label>
                <label>unterwegs 
                    <input type="radio" name="2" onclick="document.forms['driver_form2'].submit();" />
                </label>
                <label>ausgeliefert
                    <input type="radio" name="2" onclick="document.forms['driver_form2'].submit();" />
                </label> 
            </form>
        </section> 
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

// Zend standard does not like closing php-tag!
// PHP doesn't require the closing tag (it is assumed when the file ends). 
// Not specifying the closing ? >  helps to prevent accidents 
// like additional whitespace which will cause session 
// initialization to fail ("headers already sent"). 
//? >