<?php namespace XoopsModules\Wgteams;

use Xmf\Request;
use XoopsModules\Wgteams;
use XoopsModules\Wgteams\Common;

/**
 * Class Utility
 */
class Utility
{
    use Common\VersionChecks; //checkVerXoops, checkVerPhp Traits

    use Common\ServerStats; // getServerStats Trait

    use Common\FilesManagement; // Files Management Trait

    //--------------- Custom module methods -----------------------------
}
