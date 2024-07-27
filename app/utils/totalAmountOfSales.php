<?php
// initialize a variable that handle the total
    $total = 0;

    //check if the variable exists
    if(isset($data1) && $data1 !== false){
        // iterate to calculate the total price of all sales...
        foreach($data1 as $row => $product){
            $total += $product['total_price'];
        }

        // Format the total amount with commas as thousand separators and no decimal places
        $total = number_format($total, 0, '.', ',');
        // Output the total amount with a dollar sign prefix
        echo "$" . $total;
    } else{
        // if the variable does not exists we print 0
        echo '0';
    }
?>