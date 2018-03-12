<?php	// UTF-8 marker äöüÄÖÜß€
require_once './Page.php';

class Index extends Page
{
    protected function __construct() 
    {
        parent::__construct();
    }

    protected function __destruct() 
    {
        parent::__destruct();
    }

    protected function getViewData(){}
    
    protected function generateView() 
    {
        $this->getViewData();
        $this->generatePageHeader('Übersicht', false);
        echo <<<EOF

        <h1> Übersicht </h1>
        <ul>
            <li>
                <a href="Baker.php">Bäcker</a>
            </li>
            <li> 
                <a href="Status.php">Kunde</a>
            </li>
            <li> 
                <a href="Order.php">Bestellung</a>
            </li>
            <li> 
                <a href="Driver.php">Fahrer</a>
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
            $page = new Index();
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
Index::main();
?>