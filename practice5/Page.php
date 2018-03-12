<?php	// UTF-8 marker äöüÄÖÜß€

abstract class Page
{
    protected $_database = null;

    protected function __construct() 
    {
        // activate full error checking
        error_reporting (E_ALL);
        
        // open database
		require_once 'pwd.php'; // read account data
		$this->_database = new MySQLi($host, $user, $pwd, "pizza-service");
		// check connection to database
	    if (mysqli_connect_errno())
	        throw new Exception("Keine Verbindung zur Datenbank: ".mysqli_connect_error());
		// set character encoding to UTF-8
		if (!$this->_database->set_charset("utf8"))
            throw new Exception("Fehler beim Laden des Zeichensatzes UTF-8: ".$this->_database->error);
            
        session_start();
    }
    
    protected function __destruct()    
    {
        $this->_database->close();
    }
    
    protected function generatePageHeader($headline = "", $refresh = true) 
    {
        $headline = htmlspecialchars($headline);
        header("Content-type: text/html; charset=UTF-8");
        
        echo <<< EOT
        <!DOCTYPE html>
        <html lang="de">
        <head>
            <title>{$headline}</title>
            <meta charset="utf-8">
            <link rel="stylesheet" media="screen" href="css/style-sheet.css" />
            <script src="js/order.js"></script>
            <script src="js/radio-submit.js"></script>
EOT;
    
        if ($refresh) echo '<meta http-equiv="refresh" content="5">';
        echo <<< EOT
        </head>
        <body>
EOT;
    }

    protected function generatePageFooter() 
    {
        echo <<<EOT
        <footer>Pizza Service</footer>
        </body>
        </html>
EOT;
    }

    protected function processReceivedData() 
    {
        if (get_magic_quotes_gpc()) {
            throw new Exception
                ("Bitte schalten Sie magic_quotes_gpc in php.ini aus!");
        }
    }
} // end of class
?>