<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>localhost</title>
    <style>
        .styleText {
            font-family: 'Montserrat-Bold', sans-serif;
            color: black;
            margin-top: 30px;
            margin-left: 200px;
        }

        .positionImage {
            position: absolute;
            left: 40px;
            top: 5px;
        }
        
        .tableShow {
            margin-top:20px;
        }

        #table_id {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #table_id td, #table_id th {
            text-align: center;
            border: 2px solid black;
            padding: 8px;
        }

        #table_id th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: center;
            background-color: white;
            color: black;
        }

        #wrapper {
            text-align: center;
        }
        #yourdiv {
            display: inline-block;
        }

    </style>
</head>
<body style="margin: 50px;">
    <div class="row">
        <div class="col-3 align-self-start">
            <div class="positionImage">
            @php
                $path = public_path('/images/Logo.jpg');
                $type = pathinfo($path, PATHINFO_EXTENSION);
                $data = file_get_contents($path);
                $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
            @endphp
                <img src="{{$base64}}" width="140px">
            </div>
        </div>
        <div class="col-4">
            <div class="styleText">
                <strong>Fecha:</strong> {{$date}}<br>
                <strong>Nombre:</strong> {{$name}}<br>
            </div>
        </div>
    </div>

    <div class="row">&nbsp;</div>
    <div class="row">&nbsp;</div>

    <div id="wrapper">    
        <div id="yourdiv"><h1>Registro Militar {{$dateSelect}}</h1></div>
    </div>

    <div class="col-12">

        <div class="tableShow">
            <table id="table_id" class="table table-bordered mb-5 display">
                <thead>
                    <tr class="table-title">
                        <th scope="col" rowspan="4">N/O</th>
                        <th scope="col" rowspan="4">Grado <br> Especialidad</th>
                        <th scope="col" rowspan="4">Apellidos y Nombres</th>
                        <th scope="col" rowspan="4">Edad</th>
                        <th scope="col" rowspan="4">Género</th>
                        <th scope="col" rowspan="4">Talla</th>
                        <th scope="col" rowspan="4">Peso</th>
                        <th scope="col" colspan="12">Primer Dia</th>
                        <th scope="col" colspan="3">Segundo Dia</th>
                        <th scope="col" colspan="2" rowspan="3">PUNTAJE</th>
                        <th scope="col" rowspan="4">Resultado <br> del <br> Control</th>
                    </tr>
                    <tr class="table-title">
                        <th scope="col" colspan="3">Barras (M) o <br> Suspensión (F)</th>
                        <th scope="col" colspan="3">Abdominales</th>
                        <th scope="col" colspan="3">Carrera 2,400 mts</th>
                        <th scope="col" colspan="3">Pista de Combate</th>
                        <th scope="col" colspan="3">Natacion: 25 mts</th>
                    </tr>
                    <tr class="table-title">
                        <th scope="col" colspan="3">COEF2</th>
                        <th scope="col" colspan="3">COEF1</th>
                        <th scope="col" colspan="3">COEF1</th>
                        <th scope="col" colspan="3">COEF3</th>
                        <th scope="col" colspan="3">COEF2</th>
                    </tr>
                    <tr class="table-title">
                        <th scope="col">Rep</th>
                        <th scope="col">Nota</th>
                        <th scope="col">Ptos</th>
                        <th scope="col">Rep</th>
                        <th scope="col">Nota</th>
                        <th scope="col">Ptos</th>
                        <th scope="col">Tiemp</th>
                        <th scope="col">Nota</th>
                        <th scope="col">Ptos</th>
                        <th scope="col">Tiemp</th>
                        <th scope="col">Nota</th>
                        <th scope="col">Ptos</th>
                        <th scope="col">Tiemp</th>
                        <th scope="col">Nota</th>
                        <th scope="col">Ptos</th>
                        <th scope="col">Total</th>
                        <th scope="col">PROM <br> (#)</th>
                    </tr>

                </thead>
                <tbody>
                @foreach($dataRecord as $key => $item)
                    <tr>
                        <td> {{$key+1}} </td>
                        <td> {{$item->specialty}} </td>
                        <td> {{$item->name}} </td>
                        <td> {{$item->age}} </td>
                        <td> {{$item->gender == 0? 'Masculino' : 'Femenino' }} </td>
                        <td> {{$item->size != null? $item->size : "-"}} </td>
                        <td> {{$item->weight != null? $item->weight : "-"}} </td>
                        @for ($i = 0; $i < 5; $i++)
                            <td> {{ (count($item->evaluates)-1) >= $i? $item->evaluates[$i]->repTiemp != null? $item->evaluates[$i]->repTiemp : "-" : "-" }} </td>
                            <td> {{ (count($item->evaluates)-1) >= $i? $item->evaluates[$i]->note != null? $item->evaluates[$i]->note : "-" : "-"  }} </td>
                            <td> {{ (count($item->evaluates)-1) >= $i? $item->evaluates[$i]->pts != null? $item->evaluates[$i]->pts : "-" : "-" }} </td>
                        @endfor
                        <td> {{$item->total}} </td>
                        <td> {{$item->average}} </td>
                        <td> {{$item->result != null? $item->result : "-"}} </td>
                    </tr>
                @endforeach 
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>