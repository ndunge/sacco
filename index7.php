<?php
//$value=19000;
function asDollars($value) {
  return '$' . number_format($value, 2);
  $pricetotal = asDollars($pricetotal);
  echo $pricetotal;
}
?>