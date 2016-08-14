  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >
    <link rel="stylesheet" href="/work/teste/css/style.css" >
    <meta name="viewport" content="width=device-width, initial-scale=1">
  </head>
  <body>
    <div class="container">
        <div class="row">
            <div class="tempo">
                  <?php
                    date_default_timezone_set('CET');
                    $city = "Blumenau";
                    $city_visitante = "";
                    ?>
                    <div class="clear5"></div>
                    <form action="" method="post">
                        <input type="text" name="radio" placeholder="Digite sua cidade:" value="">
                        <input type="submit" name="submit" value="OK" />
                    </form>
                    <?php
                    if (isset($_POST['submit'])) {
                        if(isset($_POST['radio'])){
                         $city_visitante = $_POST['radio'];  //  Displaying Selected Value
                        }
                    }
                    if($city_visitante != ""){
                        $city = $city_visitante;
                    }                    
                    $BASE_URL = "http://query.yahooapis.com/v1/public/yql";
                    $yql_query = 'select * from weather.forecast where woeid in (select woeid from geo.places(1) where text="'.$city.'") and u="c"';
                    $yql_query_url = $BASE_URL . "?q=" . urlencode($yql_query) . "&format=json&country=brazil&lang=pt-br";
                    // Make call with cURL
                    $session = curl_init($yql_query_url);
                    curl_setopt($session, CURLOPT_RETURNTRANSFER,true);
                    $json = curl_exec($session);
                    // Convert JSON to PHP object
                    $phpObj =  json_decode($json);
                    //var_dump($phpObj);
                    $fcast=$phpObj->query->results->channel->item->forecast;
                    ?>                  
                  <h1>CIDADE: <?php echo $city;?> </h1>
                  <?php $i = 0; foreach($fcast as $witem){
                    if($i < 4){
                        $fdate=DateTime::createFromFormat('j M Y', $witem->date);
                        ?>
                        <div class="col-sm-3">
                            <div class="item">
                                <?php $codigo_yahoo = $witem->code;                               
                                if($codigo_yahoo == 1 ){ $codigo_yahoo = "Tempestade tropical";}
                                if($codigo_yahoo == 2 ){ $codigo_yahoo = "furacão";}
                                if($codigo_yahoo == 3 ){ $codigo_yahoo = "Tempestades severas";}
                                if($codigo_yahoo == 4 ){ $codigo_yahoo = "Tempestades";}
                                if($codigo_yahoo == 11 ){ $codigo_yahoo = "Pancadas de chuva";}
                                if($codigo_yahoo == 12 ){ $codigo_yahoo = "Pancadas de chuva";}
                                if($codigo_yahoo == 25 ){ $codigo_yahoo = "Frio";}
                                if($codigo_yahoo == 26 ){ $codigo_yahoo = "Nublado";}
                                if($codigo_yahoo == 27 ){ $codigo_yahoo = "Maior tempo nublado (Noite)";}
                                if($codigo_yahoo == 28 ){ $codigo_yahoo = "Maior tempo nublado (Dia)";}
                                if($codigo_yahoo == 29 ){ $codigo_yahoo = "Parcialmente nublado (Noite)";}
                                if($codigo_yahoo == 30 ){ $codigo_yahoo = "Parcialmente nublado (Dia)";}
                                if($codigo_yahoo == 31 ){ $codigo_yahoo = "Tempo limpo (Noite)";}
                                if($codigo_yahoo == 32 ){ $codigo_yahoo = "Ensolarado";}
                                if($codigo_yahoo == 33 ){ $codigo_yahoo = "Justo ( noite)";}
                                if($codigo_yahoo == 34 ){ $codigo_yahoo = "Justo ( dia)";}
                                if($codigo_yahoo == 35 ){ $codigo_yahoo = "ombrófila mista e granizo";}
                                if($codigo_yahoo == 36 ){ $codigo_yahoo = "Quente";}
                                if($codigo_yahoo == 37 ){ $codigo_yahoo = "Trovoadas isoladas";}
                                if($codigo_yahoo == 38 || $codigo_yahoo == 39 ){ $codigo_yahoo = "Trovoadas dispersas";}
                                if($codigo_yahoo == 40 ){ $codigo_yahoo = "Chuvas esparsas";}
                                if($codigo_yahoo == 44 ){ $codigo_yahoo = "Parcialmente nublado";}
                                if($codigo_yahoo == 45 ){ $codigo_yahoo = "Trovoadas isoladas";}
                                if($codigo_yahoo == 47 ){ $codigo_yahoo = "Trovoadas isoladas";}
                                if($codigo_yahoo == 3200 ){ $codigo_yahoo = "Não encontrado";}
                                ?>
                                <div>
                                    <p><?php echo $codigo_yahoo; ?></p>
                                    <p>Dia: <?php echo $fdate->format('d/m/y').'&nbsp;'; ?></p>
                                </div>
                            </div>
                        </div>
                    <?php $i++;
                    }
                };?>
                <div class="clear5"></div>
                <div class="col-sm-4">
                <h1>Próximos dias:</h1>
                <?php $i = 0; foreach($fcast as $witem){
                    if($i < 4){
                        $fdate=DateTime::createFromFormat('j M Y', $witem->date);?>
                            <div>
                                <p>Dia: <?php echo $fdate->format('d/m/y').'&nbsp;'; ?></p>
                            </div>
                            <div>
                                <p>Maior: <?php echo $witem->high; ?>°C</p>
                                <p>Menor: <?php echo $witem->low;?>°C</p>
                            </div>
                            <div class="dividir"></div>
                    <?php $i++;
                    }
                };?>
                </div>
                <div class="col-sm-4 praia">
                <h1>Praia:</h1>
                <?php $i = 0;  foreach($fcast as $witem){
                    $maior = $witem->high;
                    if($i < 4){
                        $fdate=DateTime::createFromFormat('j M Y', $witem->date);?>
                            <div>
                                <p>Dia: <?php echo $fdate->format('d/m/y').'&nbsp;'; ?></p>
                            </div>
                            <div>
                                <p>Maior: <?php echo $maior; ?>°C</p>
                                <p>Menor: <?php echo $witem->low;?>°C</p>
                                <h5>Tempo <?php if($maior > 25){ echo "<span id='bom'>bom</span>";}else{ echo "<span id='ruim'>ruim</span>";}?> para ir a praia.</h5>
                            </div>
                            <div class="dividir"></div>
                    <?php $i++;
                    }
                };?>
                </div>
               <div class="col-sm-4">
                    <h1>Gráfico:</h1>
                    <?php $i=0; foreach($fcast as $witem){
                        $maior = $witem->high;
                        if($i < 4){
                            $fdate=DateTime::createFromFormat('j M Y', $witem->date);?>
                            <div class="col-xs-3 grafico_main">
                                <div class="grafico">
                                    <span id="maior" style="height: <?php echo $maior; ?>0px;"></span>
                                    <span id="menor" style="height: <?php echo $witem->low;?>0px;"></span>
                                </div>
                                <div class="clear"></div>
                                <div>
                                    <p>Dia: <?php echo $fdate->format('d/m/y').'&nbsp;'; ?></p>
                                </div>
                            </div>
                       <?php $i++;}
                    }; ?>
               </div>
               <div class="clear"></div>
            </div>
        </div>
    </div>
  </body>