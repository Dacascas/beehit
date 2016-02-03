<?php

$bee_text = '';

foreach($this->bees->bee as $name_bee => $bees_value) {
    $bee_text .= "<div style='float:left;width:100%'><p>$name_bee</p>";

    foreach($bees_value as $bee_key => $bee) {
        $bee_text .= "<div style='float:left;' align='center'><img src='../image/{$this->bees->config[$name_bee]['image']}' width='100'/><br />";

        if($bee['health']) {
            $bee_text .= "<input type='radio' id='bee' name='bee' value='$name_bee;$bee_key' style='display: none'/>";
        }

        $bee_text .= "<span>$bee[health]</span></div>";
    }
    $bee_text .= '<br /></div>';
}

$html = <<<HTML
<html>
<head>
<title>BeeHitter Game</title>
<script src="https://code.jquery.com/jquery-1.12.0.min.js" type="text/javascript"></script>
<script src="../js/bee.js" type="text/javascript"></script>
</head>
<body>
<form name="beeDashboard" method="post">
$bee_text
<input type="submit" name="hit" value="BeeHit" />
<input type="submit" name="reset" value="Reset" disabled/>
</form>
</body>
</body>
</html>
HTML;
