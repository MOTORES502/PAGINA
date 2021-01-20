<?php

namespace App\Traits;

trait informacion
{
    public function horario_atencion()
    {
        $horario = array();

        $info['dia'] = 'Lunes';
        $info['abierto'] = true;
        $info['hora'] = '09:00am - 06:00pm';
        array_push($horario, $info);

        $info['dia'] = 'Martes';
        $info['abierto'] = true;
        $info['hora'] = '09:00am - 06:00pm';
        array_push($horario, $info);

        $info['dia'] = 'Miércoles';
        $info['abierto'] = true;
        $info['hora'] = '09:00am - 06:00pm';
        array_push($horario, $info);

        $info['dia'] = 'Jueves';
        $info['abierto'] = true;
        $info['hora'] = '09:00am - 06:00pm';
        array_push($horario, $info);

        $info['dia'] = 'Viernes';
        $info['abierto'] = true;
        $info['hora'] = '09:00am - 06:00pm';
        array_push($horario, $info);

        $info['dia'] = 'Sábado';
        $info['abierto'] = true;
        $info['hora'] = '09:00am - 04:00pm';
        array_push($horario, $info);

        $info['dia'] = 'Domingo';
        $info['abierto'] = false;
        $info['hora'] = 'Previa cita';
        array_push($horario, $info);

        return $horario;
    }

    public function ubicacion()
    {
        return 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3861.6262195937147!2d-90.47409588458166!3d14.563354789826167!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8589b54abca4fb7d%3A0x5297f2aeeb687770!2sMotores%20502!5e0!3m2!1ses-419!2sgt!4v1609108422407!5m2!1ses-419!2sgt';
    }

    public function canales()
    {
        $canales = array();

        $info['url'] = 'https://www.facebook.com/motores502/';
        $info['icon'] = 'fa fa-facebook';
        array_push($canales, $info);

        $info['url'] = 'https://twitter.com/502Motores';
        $info['icon'] = 'fa fa-twitter';
        array_push($canales, $info);

        $info['url'] = 'https://www.youtube.com/channel/UC7vwmnOmvkS19pdZjBczAVw';
        $info['icon'] = 'fa fa-youtube-play';
        array_push($canales, $info);

        $info['url'] = 'https://www.instagram.com/motores502/';
        $info['icon'] = 'fa fa-instagram';
        array_push($canales, $info);

        return $canales;
    }

    public function multas()
    {
        $multas = array();

        $titulos = array();
        $informacion = array();
        $titulos['titulo'] = 'CAPITAL';
        
        $info['logo'] = 'PNC.png';
        $info['nombre'] = 'Multas Policia Nacional Civil';
        $info['link'] = 'https://sistemas.transito.gob.gt/consultaremisiones/consultaremisiones';

        array_push($informacion, $info);

        $info['logo'] = 'PMT-guatemala.png';
        $info['nombre'] = 'Multas EMETRA';
        $info['link'] = 'http://especiales.muniguate.com/remisiones.htm';

        array_push($informacion, $info);

        $info['logo'] = 'PMT-santa-catariana-pinula.png';
        $info['nombre'] = 'Multas Santa Catarina Pinula';
        $info['link'] = 'http://www.consultas.scp.gob.gt/transito/';

        array_push($informacion, $info);

        $info['logo'] = 'PMT-mixco.png';
        $info['nombre'] = 'Multas EMIXTRA';
        $info['link'] = 'https://consultas.munimixco.gob.gt/app/pagov2/';

        array_push($informacion, $info);

        $info['logo'] = 'PMT-Villa-nueva.png';
        $info['nombre'] = 'Multas Villa Nueva';
        $info['link'] = 'https://www.villanueva.gob.gt/constancias-y-solvencias';

        array_push($informacion, $info);

        $titulos['dato'] = $informacion;

        array_push($multas, $titulos);

        $titulos = array();
        $informacion = array();
        $titulos['titulo'] = 'Departamentales';

        $info['logo'] = 'Palencia.png';
        $info['nombre'] = 'Multas Palencia';
        $info['link'] = 'http://consultamulta.munipalencia.gob.gt/';

        array_push($informacion, $info);

        $info['logo'] = 'San_Lucas.png';
        $info['nombre'] = 'Multas San Lucas Sacatepequez';
        $info['link'] = 'http://www.munisanlucas.gob.gt/Municipalidad_de_San_Lucas/Consulta_de_Remisiones.html';

        array_push($informacion, $info);

        $info['logo'] = 'Logo-Muni-Escuintla-multas.jpg';
        $info['nombre'] = 'Multas Escuintla';
        $info['link'] = 'http://www.municipalidad-escuintla.gob.gt/';

        array_push($informacion, $info);

        $titulos['dato'] = $informacion;

        array_push($multas, $titulos);

        $titulos = array();
        $informacion = array();
        $titulos['titulo'] = 'PAGO DE Impuesto de circulación';

        $info['logo'] = 'sat.jpg';
        $info['nombre'] = 'Declaraguate';
        $info['link'] = 'https://portal.sat.gob.gt/portal/impuesto-de-circulacion/';

        array_push($informacion, $info);

        $titulos['dato'] = $informacion;

        $info['logo'] = 'sat.jpg';
        $info['nombre'] = 'Impresión de calcomanía';
        $info['link'] = 'https://portal.sat.gob.gt/portal/impresion_calcomania/';

        array_push($informacion, $info);

        $titulos['dato'] = $informacion;

        $info['logo'] = 'sat.jpg';
        $info['nombre'] = 'Omisos e Incumplimientos';
        $info['link'] = 'https://portal.sat.gob.gt/portal/incumplimientos/';

        array_push($informacion, $info);

        $titulos['dato'] = $informacion;

        $info['logo'] = 'sat.jpg';
        $info['nombre'] = 'Impresión de RTU';
        $info['link'] = 'https://portal.sat.gob.gt/portal/consulta-registro-tributario-unificado/';

        array_push($informacion, $info);

        $titulos['dato'] = $informacion;

        array_push($multas, $titulos);

        return $multas;
    }
}
