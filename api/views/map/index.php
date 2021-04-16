<?php

use common\models\Language;

$this->title = Yii::t('frontend', 'Radar maps');
?>
    <div id="map"></div>
    <script>
        function initMap() {
            <?php if($city && $city->lat && $city->lng) { ?>
                var myLatLng = {lat: <?=$city->lat?>, lng: <?=$city->lng?>};
                var zoom = 10;
            <?php } else { ?>
                var myLatLng = {lat: 41.4450174, lng: 64.8666701};
                var zoom = 6;
            <?php } ?>

            var map = new google.maps.Map(document.getElementById('map'), {
                center: myLatLng,
                zoom: zoom
            });

            <?php for($i = 0; $i < count($radars); $i++) {
            $image = '/uploads/site/speed-limit.png';
            if ($radars[$i]->type == 1) $image = '/uploads/site/stop.png';
            ?>
            var infowindow<?=$i?> = new google.maps.InfoWindow({
                content: '<?=Yii::t('frontend', 'Radar type ' . $radars[$i]->type)?>'
            });

            var marker<?=$i?> = new google.maps.Marker({
                map: map,
                position: {lat: <?=$radars[$i]->lat?>, lng: <?=$radars[$i]->lng?>},
                icon: '<?=$image?>',
                title: '<?=Yii::t('frontend', 'Radar type ' . $radars[$i]->type)?>'
            });
            marker<?=$i?>.addListener('click', function () {
                infowindow<?=$i?>.open(map, marker<?=$i?>);
            });
            <?php } ?>
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB_x1j3WR5rH6hMDlm2_wfcVK7EI-30fx8&callback=initMap&language=<?= Language::getCurrent()->url ?>"
            async defer></script>
<?php

$this->registerCss('
    #map {
        width: 100%;
        height: 400px;
    }
');