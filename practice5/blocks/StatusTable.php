<?php	// UTF-8 marker äöüÄÖÜß€
 
class StatusTable        
{
    protected $_database = null;
    public $tmp;
    
    public function __construct($database) 
    {
        $this->_database = $database;
    }

    protected function getViewData(){}
    
    public function generateView($id = "", $url, array $columns, array $data, $styleBox, $editable = false) 
    {
        $this->getViewData();
        if ($id) {
            $id = "id=\"$id\"";
        }
        echo "<div $id>\n";

        if ($url !== null) {
            echo '<form action="' . $url . '" method="POST">';
        }

        echo <<<EOF
        <div class=$styleBox>  
            <div class="header_table">
                <div class="label_table_span">
EOF;
    $tmp = 0;
        foreach ($columns as $column) {
                echo <<<EOF
                <p class="label_table">$column</p>
EOF;
        }
        echo <<<EOF
                </div>
            </div>                       
EOF;
        
        foreach ($data as $i => $row) {
            
        echo <<<EOF
        <div>
                <p class="pizza_name">
                    {$row['name']}
                </p>
EOF;
        for ($j = 0; $j < count($columns); ++$j) {
            $checked = $j == $row['status'] ? ' checked' : '';
            $disabled = (!$editable || $row['status'] == count($columns) - 1) ? ' disabled' : '';
            echo <<<EOF
                <div class="pizza_status">
                    
                    <input type="radio" id="{$tmp}" name="order[{$i}]" value="{$j}" class="status_button"{$checked}{$disabled}/>
                    
                </div>
                
EOF;
          $tmp = $tmp + 1;  
        }
        echo "</div>";
        }
        echo "</div>";
        if ($url !== null) {
            echo "</form>\n";
        }
            echo "</div>\n";
    }
    
    public function processReceivedData(){}
}
?>