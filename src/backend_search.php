<!--    <script>
        $(document).ready(function(){
            $('.search-box input[type="text"]').on("keyup input", function(){
                /* Get input value on change */
                var inputVal = $(this).val();
                var resultDropdown = $(this).siblings(".result");
                if(inputVal.length){
                    $.get("backend_search.php", {term: inputVal}).done(function(data){
                        // Display the returned data in browser
                        resultDropdown.html(data);
                    });
                } else{
                    resultDropdown.empty();
                }
            });

            // Set search input value on click of result item
            $(document).on("click", ".result p", function(){
                $(this).parents(".search-box").find('input[type="text"]').val($(this).text());
                $(this).parent(".result").empty();
            });
        });
    </script>-->

<?php
/* Attempt MySQL server connection. */
$config = parse_ini_file('../../private/db-config.ini');
$conn = new mysqli($config['servername'], $config['username'],
$config['password'], $config['dbname']);
// Check connection
if ($conn->connect_error)
{
    $errorMsgDB = "Connection failed: " . $conn->connect_error;
    $success = false;
    alert($errorMsgDB);
}
 
if(isset($_REQUEST["term"])){
    $param_term = $_REQUEST["term"] . '%';
    
    // Prepare a select statement
    $stmt = $conn->prepare("SELECT * FROM app_list WHERE name LIKE ?");
    // Bind variables to the prepared statement as parameters
    $stmt->bind_param("s", $param_term);
    
        // Attempt to execute the prepared statement
        if($stmt->execute()){
            $result = $stmt->get_result();
            
            // Check number of rows in the result set
            if ($result->num_rows > 0){
                // Fetch result rows as an associative array
                while($row = $result->fetch_assoc()){
                    echo "<p>" . $row["name"] . "</p>";
                }
            } 
            else{
                echo "<p>No matches found</p>";
            }
        } 
        else{
            $errorMsg = "Execute failed: (" . $stmt->errno . ") " . 
                        $stmt->error;
            $success = false;
        }
    }
$stmt->close();
// close connection
mysqli_close($link);
?>