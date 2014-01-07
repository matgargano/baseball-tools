<?php
Namespace Baseball_tools;

class Basball_tools_helper {
    public static function convert_height( $inches ) {
        $inches = (int)$inches;
        if ( ! is_numeric( $inches ) ) {
          return false;
        }
        $feet_unit = '&#39;';
        $inches_unit = '&#34;';
        $feet = floor( $inches/12 );
        $inches = $inches % 12;
        return $feet . $feet_unit . $inches . $inches_unit;
    }
}