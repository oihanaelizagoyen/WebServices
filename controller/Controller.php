<?php
    ini_set('display_errors',1);
    ini_set('display_startup_errors',error_reporting(E_ALL));

    include __DIR__ ."/../model/Model.php";
    include __DIR__ ."/../view/View.php";

    if(isset($_GET['accion'])) {
        $accion = $_GET['accion'];
    } elseif(isset($_POST['accion'])) {
        $accion = $_POST['accion'];
    } else {
        $accion = 'home';
    }

    switch ($accion) {
        case 'home':
            vMostrarHome(obtenerDatosPagina(), obtenerCategorias());
            break;
        case 'abrirCategoria':
            if(isset($_GET['id'])) {
                $id_categoria = $_GET['id'];
                vMostrarCategoria(obtenerDatosPagina(), obtenerCategorias(), $id_categoria);
            } else {
                echo "Hola";
                vMostrarHome(obtenerDatosPagina(), obtenerCategorias());
            }
            break;
        case 'registrar':
            if(isset($_POST['nombre']) &&
                isset($_POST['apellidos']) &&
                isset($_POST['correo']) &&
                isset($_POST['contrasena']) &&
                isset($_POST['direccion']) &&
                isset($_POST['pais']) &&
                isset($_POST['cAutonoma']) &&
                isset($_POST['provincia']) &&
                isset($_POST['municipio']) &&
                isset($_POST['imgPerfil']) &&
                isset($_POST['lunesIni']) &&
                isset($_POST['lunesFin']) &&
                isset($_POST['martesIni']) &&
                isset($_POST['martesFin']) &&
                isset($_POST['miercolesIni']) &&
                isset($_POST['miercolesFin']) &&
                isset($_POST['juevesIni']) &&
                isset($_POST['juevesFin']) &&
                isset($_POST['viernesIni']) &&
                isset($_POST['viernesFin']) &&
                isset($_POST['sabadoIni']) &&
                isset($_POST['sabadoFin']) &&
                isset($_POST['domingoIni']) &&
                isset($_POST['domingoFin']) &&
                isset($_POST['experiencia'])) {

                $nombre = $_POST['nombre'] . ", " . $_POST['apellidos'];
                $correo = $_POST['correo'];
                $contrasena = $_POST['contrasena'];
                $direccion = $_POST['direccion'];
                $pais = $_POST['pais'];
                $cAutonoma = $_POST['cAutonoma'];
                $provincia = $_POST['provincia'];
                $municipio = $_POST['municipio'];
                $imgPerfil = $_POST['imgPerfil'];
                $lunesIni = $_POST['lunesIni'];
                $lunesFin = $_POST['lunesFin'];
                $martesIni = $_POST['martesIni'];
                $martesFin = $_POST['martesFin'];
                $miercolesIni = $_POST['miercolesIni'];
                $miercolesFin = $_POST['miercolesFin'];
                $juevesIni = $_POST['juevesIni'];
                $juevesFin = $_POST['juevesFin'];
                $viernesIni = $_POST['viernesIni'];
                $viernesFin = $_POST['viernesFin'];
                $sabadoIni = $_POST['sabadoIni'];
                $sabadoFin = $_POST['sabadoFin'];
                $domingoIni = $_POST['domingoIni'];
                $domingoFin = $_POST['domingoFin'];
                $experiencia = $_POST['experiencia'];

                $vehiculo = 0;

                if(isset($_POST['vehiculo'])){
                    if ($_POST['vehiculo'] == 'on'){
                        $vehiculo = 1;
                    }
                } else {
                    $vehiculo = 0;
                }

                //Datos para crear empresa
                $TimeSlots_ = array(
                    "@odata.type" => "#microsoft.graph.bookingWorkTimeSlot",
                    "startTime" => "00:01:00.0000000",
                    "endTime" => "23:59:00.0000000");
                $TimeSlots = array($TimeSlots_);
                $businessHoursMonday = array(
                    "@odata.type" => "#microsoft.graph.bookingWorkHours",
                    "day@odata.type" => "#microsoft.graph.dayOfWeek",
                    "day" => "monday",
                    "timeSlots@odata.type" => "#Collection(microsoft.graph.bookingWorkTimeSlot)",
                    "timeSlots" => $TimeSlots
                );
                $businessHoursTuesday = array(
                    "@odata.type" => "#microsoft.graph.bookingWorkHours",
                    "day@odata.type" => "#microsoft.graph.dayOfWeek",
                    "day" => "tuesday",
                    "timeSlots@odata.type" => "#Collection(microsoft.graph.bookingWorkTimeSlot)",
                    "timeSlots" => $TimeSlots
                );
                $businessHoursWednesday = array(
                    "@odata.type" => "#microsoft.graph.bookingWorkHours",
                    "day@odata.type" => "#microsoft.graph.dayOfWeek",
                    "day" => "wednesday",
                    "timeSlots@odata.type" => "#Collection(microsoft.graph.bookingWorkTimeSlot)",
                    "timeSlots" => $TimeSlots
                );
                $businessHoursThursday = array(
                    "@odata.type" => "#microsoft.graph.bookingWorkHours",
                    "day@odata.type" => "#microsoft.graph.dayOfWeek",
                    "day" => "thursday",
                    "timeSlots@odata.type" => "#Collection(microsoft.graph.bookingWorkTimeSlot)",
                    "timeSlots" => $TimeSlots
                );
                $businessHoursFriday = array(
                    "@odata.type" => "#microsoft.graph.bookingWorkHours",
                    "day@odata.type" => "#microsoft.graph.dayOfWeek",
                    "day" => "friday",
                    "timeSlots@odata.type" => "#Collection(microsoft.graph.bookingWorkTimeSlot)",
                    "timeSlots" => $TimeSlots
                );
                $businessHoursSaturday = array(
                    "@odata.type" => "#microsoft.graph.bookingWorkHours",
                    "day@odata.type" => "#microsoft.graph.dayOfWeek",
                    "day" => "saturday",
                    "timeSlots@odata.type" => "#Collection(microsoft.graph.bookingWorkTimeSlot)",
                    "timeSlots" => $TimeSlots
                );
                $businessHoursSunday = array(
                    "@odata.type" => "#microsoft.graph.bookingWorkHours",
                    "day@odata.type" => "#microsoft.graph.dayOfWeek",
                    "day" => "sunday",
                    "timeSlots@odata.type" => "#Collection(microsoft.graph.bookingWorkTimeSlot)",
                    "timeSlots" => $TimeSlots
                );
                $businessHours = array($businessHoursMonday, $businessHoursTuesday, $businessHoursWednesday, $businessHoursThursday, $businessHoursFriday, $businessHoursSaturday, $businessHoursSunday);

                $address = array(
                    "city" => $municipio,
                    "countryOrRegion" => $pais,
                    "state" => $provincia,
                    "street" => $direccion
                );

                $datos_empresa = array(
                    "displayName" => $nombre . "_empresa" . rand(1, 10000),
                    "address" => $address,
                    "timeZone" => "Europe/Paris",
                    "workingHours@odata.type" => "#Collection(microsoft.graph.bookingWorkHours)",
                    "businessHours" => $businessHours,
                    "defaultCurrencyIso" => "EUR"
                );

                $empresa = crearEmpresaApi($datos_empresa);
                if (isset($empresa['id'])){

                    $id_empresa = $empresa['id'];

                    //Datos para crear usuario
                    $workingHours = array();

                    $ini_horas = explode(":", $lunesIni);
                    $fin_horas = explode(":", $lunesFin);
                    $int_ini_hora = (int) $ini_horas[0];
                    $int_fin_hora = (int) $fin_horas[0];
                    if (($int_ini_hora - $int_fin_hora) != 0){
                        $TimeSlots_ = array(
                            "@odata.type" => "#microsoft.graph.bookingWorkTimeSlot",
                            "startTime" => $lunesIni,
                            "endTime" => $lunesFin);
                        $TimeSlots = array($TimeSlots_);
                        $businessHoursMonday = array(
                            "@odata.type" => "#microsoft.graph.bookingWorkHours",
                            "day@odata.type" => "#microsoft.graph.dayOfWeek",
                            "day" => "monday",
                            "timeSlots@odata.type" => "#Collection(microsoft.graph.bookingWorkTimeSlot)",
                            "timeSlots" => $TimeSlots
                        );
                        $workingHours[] = $businessHoursMonday;
                    }

                    $ini_horas = explode(":", $martesIni);
                    $fin_horas = explode(":", $martesFin);
                    $int_ini_hora = (int) $ini_horas[0];
                    $int_fin_hora = (int) $fin_horas[0];
                    if (($int_ini_hora - $int_fin_hora) != 0){
                        $TimeSlots_ = array(
                            "@odata.type" => "#microsoft.graph.bookingWorkTimeSlot",
                            "startTime" => $martesIni,
                            "endTime" => $martesFin);
                        $TimeSlots = array($TimeSlots_);
                        $businessHoursTuesday = array(
                            "@odata.type" => "#microsoft.graph.bookingWorkHours",
                            "day@odata.type" => "#microsoft.graph.dayOfWeek",
                            "day" => "tuesday",
                            "timeSlots@odata.type" => "#Collection(microsoft.graph.bookingWorkTimeSlot)",
                            "timeSlots" => $TimeSlots
                        );
                        $workingHours[] = $businessHoursTuesday;
                    }

                    $ini_horas = explode(":", $miercolesIni);
                    $fin_horas = explode(":", $miercolesFin);
                    $int_ini_hora = (int) $ini_horas[0];
                    $int_fin_hora = (int) $fin_horas[0];
                    if (($int_ini_hora - $int_fin_hora) != 0){
                        $TimeSlots_ = array(
                            "@odata.type" => "#microsoft.graph.bookingWorkTimeSlot",
                            "startTime" => $miercolesIni,
                            "endTime" => $miercolesFin);
                        $TimeSlots = array($TimeSlots_);
                        $businessHoursWednesday = array(
                            "@odata.type" => "#microsoft.graph.bookingWorkHours",
                            "day@odata.type" => "#microsoft.graph.dayOfWeek",
                            "day" => "wednesday",
                            "timeSlots@odata.type" => "#Collection(microsoft.graph.bookingWorkTimeSlot)",
                            "timeSlots" => $TimeSlots
                        );
                        $workingHours[] = $businessHoursWednesday;
                    }

                    $ini_horas = explode(":", $juevesIni);
                    $fin_horas = explode(":", $juevesFin);
                    $int_ini_hora = (int) $ini_horas[0];
                    $int_fin_hora = (int) $fin_horas[0];
                    if (($int_ini_hora - $int_fin_hora) != 0){
                        $TimeSlots_ = array(
                            "@odata.type" => "#microsoft.graph.bookingWorkTimeSlot",
                            "startTime" => $juevesIni,
                            "endTime" => $juevesFin);
                        $TimeSlots = array($TimeSlots_);
                        $businessHoursThursday = array(
                            "@odata.type" => "#microsoft.graph.bookingWorkHours",
                            "day@odata.type" => "#microsoft.graph.dayOfWeek",
                            "day" => "thursday",
                            "timeSlots@odata.type" => "#Collection(microsoft.graph.bookingWorkTimeSlot)",
                            "timeSlots" => $TimeSlots
                        );
                        $workingHours[] = $businessHoursThursday;
                    }

                    $ini_horas = explode(":", $viernesIni);
                    $fin_horas = explode(":", $viernesFin);
                    $int_ini_hora = (int) $ini_horas[0];
                    $int_fin_hora = (int) $fin_horas[0];
                    if (($int_ini_hora - $int_fin_hora) != 0){
                        $TimeSlots_ = array(
                            "@odata.type" => "#microsoft.graph.bookingWorkTimeSlot",
                            "startTime" => $viernesIni,
                            "endTime" => $viernesFin);
                        $TimeSlots = array($TimeSlots_);
                        $businessHoursFriday = array(
                            "@odata.type" => "#microsoft.graph.bookingWorkHours",
                            "day@odata.type" => "#microsoft.graph.dayOfWeek",
                            "day" => "friday",
                            "timeSlots@odata.type" => "#Collection(microsoft.graph.bookingWorkTimeSlot)",
                            "timeSlots" => $TimeSlots
                        );
                        $workingHours[] = $businessHoursFriday;
                    }

                    $ini_horas = explode(":", $sabadoIni);
                    $fin_horas = explode(":", $sabadoFin);
                    $int_ini_hora = (int) $ini_horas[0];
                    $int_fin_hora = (int) $fin_horas[0];
                    if (($int_ini_hora - $int_fin_hora) != 0){
                        $TimeSlots_ = array(
                            "@odata.type" => "#microsoft.graph.bookingWorkTimeSlot",
                            "startTime" => $sabadoIni,
                            "endTime" => $sabadoFin);
                        $TimeSlots = array($TimeSlots_);
                        $businessHoursSaturday = array(
                            "@odata.type" => "#microsoft.graph.bookingWorkHours",
                            "day@odata.type" => "#microsoft.graph.dayOfWeek",
                            "day" => "saturday",
                            "timeSlots@odata.type" => "#Collection(microsoft.graph.bookingWorkTimeSlot)",
                            "timeSlots" => $TimeSlots
                        );
                        $workingHours[] = $businessHoursSaturday;
                    }

                    $ini_horas = explode(":", $domingoIni);
                    $fin_horas = explode(":", $domingoFin);
                    $int_ini_hora = (int) $ini_horas[0];
                    $int_fin_hora = (int) $fin_horas[0];
                    if (($int_ini_hora - $int_fin_hora) != 0){
                        $TimeSlots_ = array(
                            "@odata.type" => "#microsoft.graph.bookingWorkTimeSlot",
                            "startTime" => $domingoIni,
                            "endTime" => $domingoFin);
                        $TimeSlots = array($TimeSlots_);
                        $businessHoursSunday = array(
                            "@odata.type" => "#microsoft.graph.bookingWorkHours",
                            "day@odata.type" => "#microsoft.graph.dayOfWeek",
                            "day" => "sunday",
                            "timeSlots@odata.type" => "#Collection(microsoft.graph.bookingWorkTimeSlot)",
                            "timeSlots" => $TimeSlots
                        );
                        $workingHours[] = $businessHoursSunday;
                    }

                    $datos_empleado = array(
                        "@odata.type" => "#microsoft.graph.bookingStaffMember",
                        "availabilityIsAffectedByPersonalCalendar" => "true",
                        "displayName" => $nombre,
                        "emailAddress" => $correo,
                        "role" => "administrator",
                        "timeZone" => "Europe/Paris",
                        "useBusinessHours" => "false",
                        "workingHours@odata.type" => "#Collection(microsoft.graph.bookingWorkHours)",
                        "workingHours" => $workingHours
                    );

                    $empleado = crearEmpleadoApi($datos_empleado, $id_empresa);

                    if (isset($empleado['id'])){
                        $id_empleado = $empleado['id'];

                        $comprobacion = crearEmpleadoDb($id_empleado, $contrasena, $vehiculo, $correo, $experiencia, $id_empresa);

                        if ($comprobacion = "ok"){
                            //iniciar sesion
                            vMostrarHome(obtenerDatosPagina(), obtenerCategorias());
                        } else {
                            //Error al crear el empleado en la base de datos
                            vMostrarHome(obtenerDatosPagina(), obtenerCategorias(), "error_empleado_db");
                        }

                    } else {
                        //Error al crear el empleado
                        vMostrarHome(obtenerDatosPagina(), obtenerCategorias(), "error_empleado_api");
                    }

                } else {
                    //Error al crear la empresa
                    vMostrarHome(obtenerDatosPagina(), obtenerCategorias(), "error_empresa_api");
                }
            } else {
                //Error al enviar el formulario
                vMostrarHome(obtenerDatosPagina(), obtenerCategorias());
            }


            break;
        case 'token':
            if(isset($_POST['ftoken'])) {
                $token = $_POST['ftoken'];
                setcookie("graph_token", $token, time() + (1800));
                echo "Token guardado";
            } else {
                echo "falta token";
            }
            break;

    }