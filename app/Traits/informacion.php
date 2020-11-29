<?php

namespace App\Traits;

trait informacion
{
    public function horario_atencion()
    {
        $horario = array();

        $info['dia'] = 'Lunes';
        $info['abierto'] = true;
        $info['hora'] = '09:00am - 08:00pm';
        array_push($horario, $info);

        $info['dia'] = 'Martes';
        $info['abierto'] = true;
        $info['hora'] = '09:00am - 08:00pm';
        array_push($horario, $info);

        $info['dia'] = 'Miércoles';
        $info['abierto'] = true;
        $info['hora'] = '09:00am - 08:00pm';
        array_push($horario, $info);

        $info['dia'] = 'Jueves';
        $info['abierto'] = true;
        $info['hora'] = '09:00am - 08:00pm';
        array_push($horario, $info);

        $info['dia'] = 'Viernes';
        $info['abierto'] = true;
        $info['hora'] = '09:00am - 06:00pm';
        array_push($horario, $info);

        $info['dia'] = 'Sábado';
        $info['abierto'] = true;
        $info['hora'] = '10:00am - 02:00pm';
        array_push($horario, $info);

        $info['dia'] = 'Domingo';
        $info['abierto'] = false;
        $info['hora'] = 'Cerrado';
        array_push($horario, $info);

        return $horario;
    }

    public function ubicacion()
    {
        return 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1365.1219613136502!2d-90.50762561593345!3d14.590642134313708!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8589b52fb81e6f27%3A0xf162747952ece42e!2sMotores%20502!5e0!3m2!1ses!2sgt!4v1606601725372!5m2!1ses!2sgt';
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
}
