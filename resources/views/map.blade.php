<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Carte intéractive des données sur l'anacardier en Côte d'ivoire</title>
  <!-- Include Leaflet CSS and JS -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
  <!-- Include jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- Include Bootstrap CSS -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <!-- Include Bootstrap JS -->
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <script src="https://kit.fontawesome.com/130cf56de6.js" crossorigin="anonymous"></script>

  <style>
    html, body, #map { 
      height: 100%;
      margin: 0;
      padding: 0;
    }
    table{
      width: 100%;
    }
    table , td, th {
      border: 1px solid #595959;
      border-collapse: collapse;
    }
    td, th {
      padding: 3px;
      width: 30px;
      height: 25px;
    }
    th {
      background: #f0e6cc;
    }
    .even {
      background: #fbf8f0;
    }
    .odd {
      background: #fefcf9;
    }
  </style>
</head>
<body>

<div id="map"></div>

<!-- Bootstrap Modal -->

@foreach ($localites as $key => $citydata)

  <div class="modal fade" id="modal-city-{{ $key }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"><span id="modaltitle"></span>
              FICHE 
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">

          <div id="modal-info">
              <div class="row">
                  <div class="col-4">
                      <ul class="llist-group">
                          <li class="list-group-item- d-flex justify-content-between align-items-center">
                              <span>Producteur</span>
                            <span class="badge badge-primary badge-pill"><span id="txt_mld_producteur">{{ $citydata->nom_producteur }}</span></span>
                          </li>
                          <li class="list-group-item- d-flex justify-content-between align-items-center">
                              Cooperative
                            <span class="badge badge-primary badge-pill"><span style="font-weight:bold; font-size:0.65em;" id="txt_mld_cooperative">{{ $citydata->nom_cooperative }}</span></span>
                          </li>
                          <li class="list-group-item- d-flex justify-content-between align-items-center">
                              Region
                            <span class="badge badge-primary badge-pill"><span id="txt_mld_region">{{ $citydata->nom_region }}</span></span>
                          </li>
                          <li class="list-group-item- d-flex justify-content-between align-items-center">
                              Antenne
                            <span class="badge badge-primary badge-pill"><span id="txt_mld_antenne">{{ $citydata->antenne }}</span></span>
                          </li>
                          <li class="list-group-item- d-flex justify-content-between align-items-center">
                              Origine Semences
                            <span class="badge badge-primary badge-pill"><span id="txt_mld_originesemences">{{ $citydata->origine_semences }}</span></span>
                          </li>
                          <li class="list-group-item- d-flex justify-content-between align-items-center">
                              Date Observation
                            <span class="badge badge-primary badge-pill"><span id="txt_mld_dateobservation">{{ $citydata->date_observation }}</span></span>
                          </li>
                      </ul>
                  </div>
                  <div class="col-4">
                      <ul class="list-group">
                          <li class="list-group-item- d-flex justify-content-between align-items-center">
                              Superficie
                            <span class="badge badge-primary badge-pill"><span id="txt_mld_superficie">{{ $citydata->superficie }}Hect</span></span>
                          </li>
                          <li class="list-group-item- d-flex justify-content-between align-items-center">
                              Latitude
                            <span class="badge badge-primary badge-pill"><span id="txt_mld_longitude">{{ $citydata->latitude }}</span></span>
                          </li>
                          <li class="list-group-item- d-flex justify-content-between align-items-center">
                               Longitude
                            <span class="badge badge-primary badge-pill"><span id="txt_mld_latitude">{{ $citydata->longitude }}</span></span>
                          </li>
                          <li class="list-group-item- d-flex justify-content-between align-items-center">
                              Altitude
                            <span class="badge badge-primary badge-pill"><span id="txt_mld_altitude">{{ $citydata->altitude }}</span></span>
                          </li>
                          <li class="list-group-item- d-flex justify-content-between align-items-center">
                              Sous Prefecture
                            <span class="badge badge-primary badge-pill"><span id="txt_mld_sousprefecture">{{ $citydata->sous_prefecture }}</span></span>
                          </li>
                          <li class="list-group-item- d-flex justify-content-between align-items-center">
                              Mode Entretien
                            <span class="badge badge-primary badge-pill"><span id="txt_mld_modeentretien">{{ $citydata->mode_entretien }}</span></span>
                          </li>
                      </ul>
                  </div>
                  <div class="col-4">
                      <ul class="list-group">
                          <li class="list-group-item- d-flex justify-content-between align-items-center">
                              Localite
                            <span class="badge badge-primary badge-pill"><span id="txt_mld_localite">{{ $citydata->localite }}</span></span>
                          </li>
                          <li class="list-group-item- d-flex justify-content-between align-items-center">
                              Tonnage
                            <span class="badge badge-primary badge-pill"><span id="txt_mld_tonnage">{{ $citydata->tonnage }}</span></span>
                          </li>
                          <li class="list-group-item- d-flex justify-content-between align-items-center">
                              Traitement
                            <span class="badge badge-primary badge-pill"><span id="txt_mld_traitement">{{ $citydata->traitement }}</span></span>
                          </li>
                          <li class="list-group-item- d-flex justify-content-between align-items-center">
                              Age Verger
                            <span class="badge badge-primary badge-pill"><span id="txt_mld_ageverger">{{ $citydata->age_verger }}</span></span>
                          </li>
                          <li class="list-group-item- d-flex justify-content-between align-items-center">
                              Sol
                            <span class="badge badge-primary badge-pill"><span id="txt_mld_sol">{{ $citydata->sol }}</span></span>
                          </li>
                          <li class="list-group-item- d-flex justify-content-between align-items-center">
                              Semis
                            <span class="badge badge-primary badge-pill">
                              <span id="txt_mld_sol">
                                @foreach ($citydata->semis as $semis)
                                {{ $semis."," }}
                                @endforeach
                              </span>
                            </span>
                          </li>
                      </ul>
                  </div>
              </div>
          </div>

            @if ($citydata->datatype == "maladie")
              <div class="table-responsive">
                <table class="table table-hover table-striped table-sm table-bordered table-light">
                  <thead class="thead-dark">
                    <tr>
                      <th style="text-align: center;vertical-align: middle;" rowspan="3">Plant</th>
                      <th style="text-align: center;vertical-align: middle;" rowspan="3">Maladie</th>
                      <th style="text-align: center;vertical-align: middle;" colspan="18">Taux d’attaque sur l’arbre</th>
                    </tr>
                    <tr>
                      
                      <th style="text-align: center;" colspan="4">Tronc</th>
                      <th style="text-align: center;" colspan="4">Feuilles</th>
                      <th style="text-align: center;" colspan="4">Fleurs</th>
                      <th style="text-align: center;" colspan="4">Fruits</th>
                    </tr>
                    <tr>
                    
                      <th style="text-align: center;">0%</th>
                      <th style="text-align: center;">25%</th>
                      <th style="text-align: center;">50%</th>
                      <th style="text-align: center;">≥75%</th>
    
                      <th style="text-align: center;">0%</th>
                      <th style="text-align: center;">25%</th>
                      <th style="text-align: center;">50%</th>
                      <th style="text-align: center;">≥75%</th>
    
                      <th style="text-align: center;">0%</th>
                      <th style="text-align: center;">25%</th>
                      <th style="text-align: center;">50%</th>
                      <th style="text-align: center;">≥75%</th>
    
                      <th style="text-align: center;">0%</th>
                      <th style="text-align: center;">25%</th>
                      <th style="text-align: center;">50%</th>
                      <th style="text-align: center;">≥75%</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($citydata->releve as $key => $tdata)
                      <tr>
                          <td>{{ $tdata->numero_plant }}</td>
                          <td>{{ $tdata->DSE_NomCourant }}</td>
    
                          <td> @if($tdata->TA_tronc == 0) <i class="fa fa-check">  @endif </td>
                          <td> @if($tdata->TA_tronc > 0 && $tdata->TA_tronc <= 25) <i class="fa fa-check">  @endif </td>
                          <td> @if($tdata->TA_tronc > 25 && $tdata->TA_tronc <= 75) <i class="fa fa-check">  @endif </td>
                          <td> @if($tdata->TA_tronc > 75) <i class="fa fa-check">  @endif </td>
    
                          <td> @if($tdata->TA_feuilles == 0) <i class="fa fa-check">  @endif </td>
                          <td> @if($tdata->TA_feuilles > 0 && $tdata->TA_feuilles <= 25) <i class="fa fa-check">  @endif </td>
                          <td> @if($tdata->TA_feuilles > 25 && $tdata->TA_feuilles <= 75) <i class="fa fa-check">  @endif </td>
                          <td> @if($tdata->TA_feuilles > 75) <i class="fa fa-check">  @endif </td>
    
                          <td> @if($tdata->TA_fleurs == 0) <i class="fa fa-check">  @endif </td>
                          <td> @if($tdata->TA_fleurs > 0 && $tdata->TA_fleurs <= 25) <i class="fa fa-check">  @endif </td>
                          <td> @if($tdata->TA_fleurs > 25 && $tdata->TA_fleurs <= 75) <i class="fa fa-check">  @endif </td>
                          <td> @if($tdata->TA_fleurs > 75) <i class="fa fa-check">  @endif </td>
    
                          <td> @if($tdata->TA_fruits == 0) <i class="fa fa-check">  @endif </td>
                          <td> @if($tdata->TA_fruits > 0 && $tdata->TA_fruits <= 25) <i class="fa fa-check">  @endif </td>
                          <td> @if($tdata->TA_fruits > 25 && $tdata->TA_fruits <= 75) <i class="fa fa-check">  @endif </td>
                          <td> @if($tdata->TA_fruits > 75) <i class="fa fa-check">  @endif </td>
                      </tr>
                    @endforeach
    
                  </tbody>
                </table>
              </div>
            @else
              <div class="table-responsive">
                <table class="table table-hover table-striped table-sm table-bordered table-light">
                  <thead class="thead-dark">

                    <tr>
                      <th style="text-align: center;vertical-align: middle;" rowspan="2">N° pied</th>
                      <th style="text-align: center;vertical-align: middle;" rowspan="2">Insecte</th>
                      <th style="text-align: center;vertical-align: middle;" colspan="8">Organes attaqués / Nombre</th>
                      {{-- <th style="text-align: center;vertical-align: middle;" rowspan="2">Description</th> --}}
                    </tr>

                    <tr>
                      
                      <th style="text-align: center;">Tronc</th>
                      <th style="text-align: center;">Branches</th>
                      <th style="text-align: center;">Bourgeons</th>
                      <th style="text-align: center;">Feuilles</th>
                      <th style="text-align: center;">Fleurs</th>
                      <th style="text-align: center;">Fruits</th>
                      
                    </tr>
                    
                  </thead>
                  <tbody>
                    @foreach ($citydata->releve as $key => $tdata)
                      <tr>
                          <td style="text-align: center;">{{ $tdata->numero_pied }}</td>
                          <td style="text-align: center;">{{ $tdata->INSCT_NomCourant }}</td>
                          <td style="text-align: center;">{{ $tdata->nba_tronc }}</td>
                          <td style="text-align: center;">{{ $tdata->nba_branches }}</td>
                          <td style="text-align: center;">{{ $tdata->nba_bourgeons }}</td>
                          <td style="text-align: center;">{{ $tdata->nba_feuilles }}</td>
                          <td style="text-align: center;">{{ $tdata->nba_fleurs }}</td>
                          <td style="text-align: center;">{{ $tdata->nba_fruits }}</td>
                          {{-- <td style="text-align: center;">{{ $tdata->desc_attaque }}</td> --}}
                        </tr>
                    @endforeach
    
                  </tbody>
                </table>
              </div>
            @endif
         
          {{-- <div id="table">
              <table class="table table-bordered table-sm table-condensed table-hover table-striped mt-4"> <!-- Add table for the provided information -->
                <thead>
                  <tr style="border: 1px solid black;" id="modal-maladie-table-head">
                      <td>N° du plant</td>
                      <td>Maladie</td>
                      <td>
                        <!-- Nested grid for Column 3 -->
                        <div class="row">
                          <div class="col" style="border: 1px solid black;">
                            <strong>Taux d’attaque sur l’arbre</strong>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col" style="border: 1px solid black;">
                            <strong>Tronc</strong>
                          </div>
                          <div class="col" style="border: 1px solid black;">
                            <strong>Feuilles</strong>
                          </div>
                          <div class="col" style="border: 1px solid black;">
                            <strong>Fleurs</strong>
                          </div>
                          <div class="col" style="border: 1px solid black;">
                            <strong>Fruits</strong>
                          </div>
                        </div>
                        <div class="row">

                          <div class="col" style="border: 1px solid black;">
                            <strong>0%</strong>
                          </div>
                          <div class="col" style="border: 1px solid black;">
                            <strong>25% </strong>
                          </div>
                          <div class="col" style="border: 1px solid black;">
                            <strong>50%</strong>
                          </div>
                          <div class="col" style="border: 1px solid black;">
                            <strong>≥75%</strong>
                          </div>
                          
                          <div class="col" style="border: 1px solid black;">
                            <strong>0%</strong>
                          </div>
                          <div class="col" style="border: 1px solid black;">
                            <strong>25% </strong>
                          </div>
                          <div class="col" style="border: 1px solid black;">
                            <strong>50%</strong>
                          </div>
                          <div class="col" style="border: 1px solid black;">
                            <strong>≥75%</strong>
                          </div>
                          
                          <div class="col" style="border: 1px solid black;">
                            <strong>0%</strong>
                          </div>
                          <div class="col" style="border: 1px solid black;">
                            <strong>25% </strong>
                          </div>
                          <div class="col" style="border: 1px solid black;">
                            <strong>50%</strong>
                          </div>
                          <div class="col" style="border: 1px solid black;">
                            <strong>≥75%</strong>
                          </div>

                          <div class="col" style="border: 1px solid black;">
                            <strong>0%</strong>
                          </div>
                          <div class="col" style="border: 1px solid black;">
                            <strong>25% </strong>
                          </div>
                          <div class="col" style="border: 1px solid black;">
                            <strong>50%</strong>
                          </div>
                          <div class="col" style="border: 1px solid black;">
                            <strong>≥75%</strong>
                          </div>
                        </div>
                      </td>
                    </tr>
                </thead>
                <tbody id="modal-maladie-table-body">
                  <tr>
                    <td>Row 1, Cell 1</td>
                    <td>Row 1, Cell 2</td>
                    <td>
                      <!-- Nested grid for Column 3 -->
                      <div class="row">
                        <div class="col">
                          <strong>Title 1</strong>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col">
                          <strong>Title 2</strong>
                        </div>
                        <div class="col">
                          <strong>Title 3</strong>
                        </div>
                        <div class="col">
                          <strong>Title 4</strong>
                        </div>
                        <div class="col">
                          <strong>Title 5</strong>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col">
                          <strong>Title 6</strong>
                        </div>
                        <div class="col">
                          <strong>Title 7</strong>
                        </div>
                        <div class="col">
                          <strong>Title 8</strong>
                        </div>
                        <div class="col">
                          <strong>Title 9</strong>
                        </div>
                        <div class="col">
                          <strong>Title 10</strong>
                        </div>
                        <div class="col">
                          <strong>Title 11</strong>
                        </div>
                        <div class="col">
                          <strong>Title 12</strong>
                        </div>
                        <div class="col">
                          <strong>Title 13</strong>
                        </div>
                        <div class="col">
                          <strong>Title 14</strong>
                        </div>
                        <div class="col">
                          <strong>Title 15</strong>
                        </div>
                        <div class="col">
                          <strong>Title 16</strong>
                        </div>
                      </div>
                    </td>
                  </tr>
                </tbody>
                </table>
          </div> --}}

        </div>
      </div>
    </div>
  </div>

@endforeach

<script type="text/javascript" src="{{ asset('assets/js/regions.js') }}"></script>


<script>

  // Initialize Leaflet map
  var map = L.map('map').setView([7.54, -5.5471], 8); // Center on Ivory Coast with appropriate zoom level

  // Add tile layer
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
  }).addTo(map);

  function getRandomColor() {
    var letters = '0123456789ABCDEF';
    var color = '#';
      for (var i = 0; i < 6; i++) {
        color += letters[Math.floor(Math.random() * 16)];
      }
    return color;
}


  function getColor(d) {
            return  d > 1000 ? '#800026' :
                    d > 500 ? '#BD0026' :
                    d > 200 ? '#E31A1C' :
                    d > 100 ? '#FC4E2A' :
                    d > 50 ? '#FD8D3C' :
                    d > 20 ? '#FEB24C' :
                    d > 10 ? '#FED976' : '#800026'; // getRandomColor();
        }

        function style(feature) {
            return {
                weight: 3,
                opacity: 1,
                color: 'white',
                dashArray: '3',
                fillOpacity: 0.6,
                fillColor: getColor(feature.properties.density)
            };
        }

        function highlightFeature(e) {
            const layer = e.target;

            layer.setStyle({
                weight: 2,
                color: '#F51E0F96',
                dashArray: '',
                fillOpacity: 0.2
            });

            layer.bringToFront();

            //info.update(layer.feature.properties);
        }

        /* global statesData */
        const geojson = L.geoJson(statesData, {
            style,
            onEachFeature
        }).addTo(map);

        function resetHighlight(e) {
            geojson.resetStyle(e.target);
            //info.update();
        }

        function zoomToFeature(e) {
            resetHighlight(e);
            map.fitBounds(e.target.getBounds());
            highlightFeature(e);
        }

        function onEachFeature(feature, layer) {
            layer.on({
                mouseover: highlightFeature,
                mouseout: resetHighlight,
                click: zoomToFeature
            });
        }

  // Define marker coordinates and information
  var data = {!! json_encode($localites) !!}

  // Add markers to the map
  data.forEach(function(city) {
    var marker = L.marker([city.latitude,city.longitude]).addTo(map);
    marker.bindPopup('<b>' + city.localite + '</b><br>' + city.nom_region);
    marker.on('click', function() {

      $("#modal-city-"+city.keyid).modal('show');

    });
  });

</script>

</body>
</html>
