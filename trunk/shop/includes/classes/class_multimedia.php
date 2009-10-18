<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2009 by the OOS Development Team.
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

/** ensure this file is being included by a parent file */
defined( 'OOS_VALID_MOD' ) or die( 'Direct Access to this location is not allowed.' );

/**
 * getID3()
 *
 * getID3() is a PHP script that extracts useful information (such as ID3 tags,
 * bitrate, playtime, etc.) from MP3s & other multimedia file formats (Ogg, WMA,
 * WMV, ASF, WAV, AVI, AAC, VQF, FLAC, MusePack, Real, QuickTime, Monkey's Audio,
 * MIDI and more).
 *
 * {@link http://www.getid3.org/ Latest release of this class}
 */
require_once 'thirdparty/getid3/getid3/getid3.php';


/**
 * Class Multimedia.
 *
 * @category   OOS [OSIS Online Shop]
 * @package    Multimedia getID3   getID3
 * @copyright  Copyright (c) 2003 - 2009 by the OOS Development Team. (http://www.oos-shop.de/)
 * @license    http://www.gnu.org/licenses/gpl.html GNU General Public License
 */
class MM extends getID3
{

    /**
     * Constructor
     */
     public function __construct()
     {

         $this->getID3();

     }

}
