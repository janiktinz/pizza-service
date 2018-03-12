<?php	// UTF-8 marker äöüÄÖÜß€
 
class Menu    
{
    protected $_database = null;
    
    public function __construct($database) 
    {
        $this->_database = $database;
    }

    protected function getViewData(){}

    public function generateView($id = "", array $pizzas) 
    {
        $this->getViewData();
        if ($id) {
            $id = "id=\"$id\"";
        }
        //echo "<div $id>\n";

        echo "<div class=order_box_order>";
        foreach ($pizzas as $pizza) {
            $formattedPrice = number_format(htmlspecialchars($pizza['price']) / 100, 2);
            $image = htmlspecialchars($pizza['image']);
            $id = htmlspecialchars($pizza['id']);
            $name = htmlspecialchars($pizza['name']);

            echo <<<EOF
            
            <img src="images/{$image}" id="{$id}" class="pizza_image" data-price="{$formattedPrice}" alt="{$name}" title="{$name}" onclick="cart.addPizza('{$id}')"/>
            <p class="pizza_label">
            {$name} {$formattedPrice} €
            </p>

EOF;
        }
        echo "</div>";
        //echo "</div>\n";
    }
    
    public function processReceivedData(){}
}
// Pictures sources:
// http://www.buonemaniere.net/wp-content/uploads/MARGHERITA.jpg (Access: 12.01.2018)
// https://www.pizzahut.com/assets/w/tile/thor/Pepperoni_Lovers_Pizza.png (Access: 12.01.2018)
// https://d.ibtimes.co.uk/en/full/1593185/hawaiian-pizza-pineapple.jpg (Access: 12.01.2018)
// http://ais.kochbar.de/kbrezept/370393_366944/1500x1500/9829-pizza-diavolo-9829-rezept.jpg (Access: 12.01.2018)
// http://feelgrafix.com/data_images/out/13/870852-pizza-wallpaper.jpg (Access: 12.01.2018)
?>