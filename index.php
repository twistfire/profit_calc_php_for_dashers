<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Decision Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 2px;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: calc(100vh - 4px); /* Adjusts height to account for the body margin */
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            box-sizing: border-box; /* Ensures padding doesn't affect width */
        }
        h1 {
            text-align: center;
            color: #333;
        }
        label {
            margin-bottom: 6px;
            display: block;
            color: #555;
        }
        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box; /* Ensures padding doesn't affect width */
        }
        input[type="submit"] {
            width: 100%;
            background-color: #28a745;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            box-sizing: border-box; /* Ensures padding doesn't affect width */
        }
        input[type="submit"]:hover {
            background-color: #218838;
        }
        .result {
            margin-top: 20px;
            text-align: center;
        }
        .result p {
            font-size: 1.1em;
            color: #333;
        }
        .result a {
            display: block;
            margin-top: 20px;
            color: #007bff;
            text-decoration: none;
        }
        .result a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Accept or Decline the Dash Order?</h1> 
    Decision Support for Dashers
    <form action="" method="post">
        <label>MPG for car used:</label>
        <input type="text" name="mpg_rate" value="<?php echo isset($_POST['mpg_rate']) ? $_POST['mpg_rate'] : 31; ?>">

        <label>Miles for Order:</label>
        <input type="text" name="miles_for_order" value="<?php echo isset($_POST['miles_for_order']) ? $_POST['miles_for_order'] : 8; ?>">

        <label>~ Time for Order Execution (min.):</label>
        <input type="text" name="time_for_order" value="<?php echo isset($_POST['time_for_order']) ? $_POST['time_for_order'] : 15; ?>">

        <label>Fuel Price (USD/Gal.):</label>
        <input type="text" name="fuel_price" value="<?php echo isset($_POST['fuel_price']) ? $_POST['fuel_price'] : 2.8; ?>">

        <label>Additional Costs / Mile (maintenance, insurance, etc.):</label>
        <input type="text" name="average_price_per_mile" value="<?php echo isset($_POST['average_price_per_mile']) ? $_POST['average_price_per_mile'] : 0.21; ?>">

        <label>Potential Reward (USD):</label>
        <input type="text" name="reward_for_order" value="<?php echo isset($_POST['reward_for_order']) ? $_POST['reward_for_order'] : 8; ?>">

        <input type="submit" value="Submit">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // Get the form data
        $mpg_rate = floatval($_POST['mpg_rate']);
        $miles_for_order = floatval($_POST['miles_for_order']);
        $time_for_order = floatval($_POST['time_for_order']);
        $fuel_price = floatval($_POST['fuel_price']);
        $average_price_per_mile = floatval($_POST['average_price_per_mile']);
        $reward_for_order = floatval($_POST['reward_for_order']);

        // Calculate fuel cost
        $fuel_cost = ($miles_for_order / $mpg_rate) * $fuel_price;

        // Calculate total cost
        $total_cost = $fuel_cost + ($miles_for_order * $average_price_per_mile);

        // Calc benefits
        $absolute_benefit = $reward_for_order - $total_cost;
        $relative_benefit = ($absolute_benefit / $reward_for_order) * 100;

        // Make a decision
        if ($reward_for_order >= $total_cost) {
            $decision = "Accept";
        } else {
            $decision = "Decline";
        }

        // Calculate the cost per hour, assuming the user inputs the execution time in minutes
        $price_per_hour = $absolute_benefit / ($time_for_order / 60);

        // Display the result
        echo "<div class='result'>";
        echo "<p>Decision: <strong>$decision</strong></p>";
        echo "<p>Absolute Benefit: <strong>$" . number_format($absolute_benefit, 2) . "</strong></p>";
        echo "<p>Relative Benefit: <strong>" . number_format($relative_benefit, 2) . "%</strong></p>";
        echo "<p>Estimated Price per Hour: <strong>$" . number_format($price_per_hour, 2) . "/hour</strong></p>";
        echo "<a href=''>Go Back</a>";
        echo "</div>";
    }
    ?>
</div>

</body>
</html>
