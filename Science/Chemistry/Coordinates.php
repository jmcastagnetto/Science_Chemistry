<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Science_Chemistry_Coordinates
 *
 * PHP 5
 *
 * LICENSE: This source file is subject to version 3.0.1 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_01.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category   Science
 * @package    Science_Chemistry
 * @author     Jesus M. Castagnetto <jmcastagnetto@php.net>
 * @copyright  1997-2012 The PHP Group
 * @license    http://www.php.net/license/3_01.txt  PHP License 3.0.1
 * @version    2.0
 * @link       http://pear.php.net/package/Science_Chemistry
 */

/**
 * Utility class for defining 3D coordinates and its methods
 *
 */
class Science_Chemistry_Coordinates {

    /**
     * Array of tridimensional coordinates: (x, y, z)
     * 
     * @var     array
     */
    private $_coords;

    /**
     * Constructor for the class
     *
     * @param   array   $coords array of three floats (x,y,z)
     * @see init()
     * @access  public
     */
    function __construct($coords=null) {
        if (!is_null($coords)) {
            $this->init($coords);
        } else {
            $this->_coords = null
        }
    }

    /**
     * Initialize the coordinates
     *
     * @param   array  $coords array of three floats (x,y,z)
     * @throws  Science_Chemistry_BadCoordinatesException, if something other than a numeric array is passed
     * @access  public
     */
    function init($coords) {
        if (is_array($coords) && count($coords) == 3) {
            if (is_numeric($coords[0]) && is_numeric($coords[1]) && is_numeric($coords[2])) {
                $this->_coords = $coords;
            } else {
                throw new Science_Chemistry_BadCoordinatesException('Expecting a numeric array with three values');
            }
        } else {
            throw new Science_Chemistry_BadCoordinatesException('Expecting a numeric array with three values');
        }
    }

    /**
     * Cartesian distance calculation method
     *
     * @param   object  Science_Chemistry_Coordinates $coord
     * @return  float   distance
     * @throws  Science_Chemistry_BadCoordinatesException, if something other than an instance of Science_Chemistry_Coordinates
     * @access  public
     */
    function distance($cobj) {
        if (is_object($cobj) 
                && ($cobj instanceof Science_Chemistry_Coordinates)) {
            $xyz2 = $cobj->getCoordinates();
            $sum2 = 0;
            for ($i=0; $i<=2; $i++) {
                $sum2 += pow(($xyz2[$i] - $this->coords[$i]),2);
            }
            return sqrt($sum2);
        } else {
            throw new Science_Chemistry_BadCoordinatesException('Expecting an instance of Science_Chemistry_Coordinates');
        }
    }

    /**
     * Returns the array of coordinates
     *
     * @return  array   array (x,y,z) if initialized, null otherwise
     * @access  public
     */
    function getCoordinates() {
        return $this->_coords;
    }

    /**
     * Returns a string representation of the coordinates: x y z
     *
     * @return  string 
     * @access  public
     */
    function toString() {
        for ($i=0; $i<count($this->coords); $i++)
            $tmp[$i] = sprintf("%10.4f",$this->coords[$i]);
        return implode(" ",$tmp);
    }

    /**
     * Returns a CML representation of the coordinates
     *
     * @return  string
     * @access  public
     */
    function toCML() {
        $out = "<coordinate3 builtin=\"xyz3\">";
        $tmp = array();
        for ($i=0; $i < count($this->coords); $i++)
            $tmp[] = trim(sprintf("%10.4f", $this->coords[$i]));
        $out .= implode(" ",$tmp)."</coordinate3>\n";
        return $out;
    }

} // end of class Science_Chemistry_Coordinates

?>
