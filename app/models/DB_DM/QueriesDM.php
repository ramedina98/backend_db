<?php
    // Here we have all the required queries to get data from the data mart...

    class Queries_DM{
        private $conn;

        public function __construct($db){
            $this->conn = $db;
        }


        // private functions...

        // Method to map the product and user information
        private function mapProductUser($data){
            // This is the array that will return the mapped data
            $array = [];

            // Verify if the data is not empty
            if($data !== false){
                // Iterate over each row of data
                foreach($data as $row){
                    // Extract client name, product name, and quantity from the row
                    $client = $row['DM_user_name'];
                    $product = $row['DM_producto'];
                    $quantity = $row['DM_Cantidad'];

                    // Check if the client is already in the array
                    if(!isset($array[$client])){
                        // If the client is not present, initialize an empty array for that client
                        $array[$client] = [];
                    }

                    // Check if the product is already in the array for the client
                    if(isset($array[$client][$product])){
                        // If the product already exists, add the current quantity to the existing quantity
                        $array[$client][$product] += $quantity;
                    } else {
                        // If the product does not exist, initialize the quantity with the current value
                        $array[$client][$product] = $quantity;
                    }
                }

                // Sort products for each client in descending order by quantity
                foreach($array as &$products){
                    arsort($products);
                }
            }

            // Return the mapped array
            return $array;
        }

        // This is the method to map the product and price info...
        private function mapProductPrice($data) {
            // This array will store the mapped information...
            $array = [];

            // Checks if the variable $data is not empty...
            if ($data !== false) {
                // Iterate over each row of data...
                foreach ($data as $row) {
                    // Extract the necessary data into separate variables...
                    $product = $row['DM_producto'];
                    $price = $row['DM_Precio'];
                    $quantity = $row['DM_Cantidad'];

                    // check if the product already exist in the array...
                    if (!isset($array[$product])) {
                        // if the product is not in the array, initialize an array for this product...
                        $array[$product] = [
                            'unit_prices' => [],
                            'total_price' => 0,
                            'total_quantity' => 0
                        ];
                    }

                    // update the current unit price in the array if is not present...
                    if (!isset($array[$product]['unit_prices'][$price])) {
                        $array[$product]['unit_prices'][$price] = $price;
                    }

                    // calculate the total price for the product and update the current total price...
                    $array[$product]['total_price'] += $price * $quantity;

                    // Update the total quantity for the product...
                    $array[$product]['total_quantity'] += $quantity;
                }
            }

            // return the require array...
            return $array;
        }


        // public functions...

        // This method helps us to get the products and the user that bought that product...
        public function getProductAndUser() {
            // this is the require query...
            $query = "SELECT DM_user_name, DM_producto, DM_Cantidad, DM_Fecha
            FROM `dm_ventas`
            WHERE `DM_Fecha` BETWEEN '2024-07-22' AND '2024-08-02';";

            // Check if the statement was prepared successfully
            try{
                $stmt = $this->conn->prepare($query);
                $stmt->execute();
                $result = $stmt->get_result();
                $data = $result->fetch_all(MYSQLI_ASSOC);

                // mapped data...
                $mappedData = $this->mapProductUser($data);

                return $mappedData; // Retorna el array directamente
            } catch(Exception $e){// If there was an error preparing the statement, output the error message
                echo "Error al obtener los datos: " . $e->getMessage();
                return false;
            }
        }

        // This method helps us define which product is the best seller, its total revenue, and who buys it the most...
        public function getProductAndPrice(){
            // this is the require query...
            $query = "SELECT DM_producto, DM_Precio, DM_Cantidad
            FROM `dm_ventas`
            WHERE `DM_Fecha` BETWEEN '2024-07-22' AND '2024-08-02';";

            //checkif the statement was prepared successfully...
            try{
                $stmt = $this->conn->prepare($query);
                $stmt->execute();
                $result = $stmt->get_result();
                $data = $result->fetch_all(MYSQLI_ASSOC);

                // mapped data...
                $mappedData = $this->mapProductPrice($data);

                return $mappedData; // return the data in the required format...
            } catch(Exception $e){
                echo "Error al obtener los datos: " . $e->getMessage();
                return false;
            }
        }
    }
?>