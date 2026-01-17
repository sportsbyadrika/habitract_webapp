<?php
foreach ($bills as $bill) {
    echo "Month: ".$bill->bill_month."<br>";
    echo "Total: ₹".$bill->total_amount."<br>";
}
