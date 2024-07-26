<?php
    // Here we have all the required queries to get data from the data mart...

    class Queries_DM{
        private $conn;

        public function __construct($db){
            $this->conn = $db;
        }

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
    }
?>