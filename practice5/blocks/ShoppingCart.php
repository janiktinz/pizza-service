<?php	// UTF-8 marker äöüÄÖÜß€

class ShoppingCart        
{
    protected $_database = null;
    
    public function __construct($database) 
    {
        $this->_database = $database;
    }

    protected function getViewData(){}
    
    public function generateView($id = "", $url) 
    {
        $this->getViewData();
        if ($id) {
            $id = "id=\"$id\"";
        }
        //echo "<div $id>\n";
        
        echo <<<EOF
        <div class="cart">
            <form action="{$url}" id="order_form" accept-charset="UTF-8" onsubmit="return cart.submit()" method="POST">
                <select name="orders[]" id="orders" multiple size="8"></select>

                <p>
                    <span id="sum">0,00</span> €
                </p>
                
                <input id="address" type="text" name="address" value="" size="30" maxlength="70" placeholder="Name, Adresse" />
                <input id="delete-all" type="reset" name="delete-all" value="Alle Löschen" onclick="cart.reset()"/>
                <input id="delete-selected" type="reset" name="delete-selected" value="Auswahl Löschen" onclick="cart.removePizza()"/>
                <input id="order" type="submit"/>
            </form>
        </div>
EOF;

        //echo "</div>\n";
    }
    
    public function processReceivedData(){}
} 
?>