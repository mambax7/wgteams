<?php
/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/
/**
 * wgTeams module for xoops
 *
 * @copyright       The XOOPS Project (https://xoops.org)
 * @license         GPL 2.0 or later
 * @package         wgteams
 * @author          Goffy - Wedega.com - Email:<webmaster@wedega.com> - Website:<https://wedega.com>
 */
 
require_once __DIR__ . '/common.php';
 
// ---------------- Admin Main ----------------
\define('_MI_WGTEAMS_NAME', 'wgTeams');
\define('_MI_WGTEAMS_DESC', 'Dieses Modul dient zur Präsentation Ihrer Teams');
// ---------------- Admin Menu ----------------
\define('_MI_WGTEAMS_ADMENU1', 'Dashboard');
\define('_MI_WGTEAMS_ADMENU3', 'Teams');
\define('_MI_WGTEAMS_ADMENU4', 'Mitglieder');
\define('_MI_WGTEAMS_ADMENU2', 'Infofelder');
\define('_MI_WGTEAMS_ADMENU5', 'Beziehungen');
\define('_MI_WGTEAMS_ADMENU6', 'Feedback');
\define('_MI_WGTEAMS_ADMENU7', 'Wartung');
\define('_MI_WGTEAMS_ADMENU8', 'Klonen');
\define('_MI_WGTEAMS_ABOUT', 'Über');
// ---------------- Admin Nav ----------------
\define('_MI_WGTEAMS_ADMIN_PAGER', 'Admin Listenzeilen');
\define('_MI_WGTEAMS_ADMIN_PAGER_DESC', 'Anzahl der Zeilen für Listen im Admin-Bereich');
// User
\define('_MI_WGTEAMS_USER_PAGER', 'User Listenzeilen');
\define('_MI_WGTEAMS_USER_PAGER_DESC', 'Anzahl der Zeilen für Listen im Mitglieder-Bereich');
// Submenu
\define('_MI_WGTEAMS_SMNAME1', 'Teams');
// Blocks
\define('_MI_WGTEAMS_TEAMSMEMBERS_BLOCK', 'Block Team/Mitglieder Standard');
\define('_MI_WGTEAMS_TEAMSMEMBERS_BLOCK_DESC', 'Zeigt Teams mit den damit verbundenen Mitgliedern');
\define('_MI_WGTEAMS_TEAMS_BLOCK', 'Block Teams');
\define('_MI_WGTEAMS_TEAMS_BLOCK_DESC', 'Zeigt eine Liste der Teams');
\define('_MI_WGTEAMS_TEAMSMEMBERS_BLOCK_EXTENDED', 'Block Team/Mitglieder erweitert');
\define('_MI_WGTEAMS_TEAMSMEMBERS_BLOCK_EXTENDED_DESC', 'Zeigt Teams mit den damit verbundenen Mitgliedern');
// Config
\define('_MI_WGTEAMS_EDITOR', 'Editor');
\define('_MI_WGTEAMS_EDITOR_DESC', 'Bitte Editor für die Eingabefelder wählen');
\define('_MI_WGTEAMS_KEYWORDS', 'Schlüsselwörter');
\define('_MI_WGTEAMS_KEYWORDS_DESC', 'Bitte hier die gewünschten Schlüsselwörter eingeben (getrennt durch einen Beistrich)');
\define('_MI_WGTEAMS_IMG_MAXSIZE', 'Maximale Größe');
\define('_MI_WGTEAMS_IMG_MAXSIZE_DESC', 'Definieren Sie bitte die maximale Größe für einen Dateiupload');
\define('_MI_WGTEAMS_SIZE_MB', 'MB');
\define('_MI_WGTEAMS_IMG_MIMETYPES', 'Mime-Types');
\define('_MI_WGTEAMS_IMG_MIMETYPES_DESC', 'Definieren Sie bitte die zulässigen Dateitypen');
\define('_MI_WGTEAMS_MAXWIDTH', 'Maximale Breite für Bilder');
\define('_MI_WGTEAMS_MAXWIDTH_DESC', 'Definieren Sie die maximale Breite, auf die die hochgeladenen Bilder automatisch verkleinert werden sollen (in pixel)<br>0 bedeutet, dass Bilder die Originalgröße behalten. <br>Sofern das Originalbild kleiner sein sollte, so wird dieses nicht vergrößert.');
\define('_MI_WGTEAMS_MAXHEIGHT', 'Maximale Höhe für Bilder');
\define('_MI_WGTEAMS_MAXHEIGHT_DESC', 'Definieren Sie die maximale Höhe, auf die die hochgeladenen Bilder automatisch verkleinert werden sollen (in pixel)<br>0 bedeutet, dass Bilder die Originalgröße behalten. <br>Sofern das Originalbild kleiner sein sollte, so wird dieses nicht vergrößert.');
\define('_MI_WGTEAMS_MAXWIDTH_IMGEDITOR', 'Maximale Breite für bearbeitete Bilder');
\define('_MI_WGTEAMS_MAXWIDTH_IMGEDITOR_DESC', 'Definieren Sie die maximale Breite, auf die die im Bildeditor bearbeiteten Bilder automatisch verkleinert werden sollen (in pixel)<br>0 bedeutet, dass Bilder die Originalgröße behalten. <br>Sofern das Originalbild kleiner sein sollte, so wird dieses nicht vergrößert.');
\define('_MI_WGTEAMS_MAXHEIGHT_IMGEDITOR', 'Maximale Höhe für bearbeitete Bilder');
\define('_MI_WGTEAMS_MAXHEIGHT_IMGEDITOR_DESC', 'Definieren Sie die maximale Höhe, auf die die  im Bildeditor bearbeiteten Bilder automatisch verkleinert werden sollen (in pixel)<br>0 bedeutet, dass Bilder die Originalgröße behalten. <br>Sofern das Originalbild kleiner sein sollte, so wird dieses nicht vergrößert.');
\define('_MI_WGTEAMS_STARTPAGE', 'Startseite');
\define('_MI_WGTEAMS_STARTPAGE_DESC', 'Definieren Sie bitte, welche Informationen beim Modulaufruf (index.php) angezeigt werden sollen');
\define('_MI_WGTEAMS_STARTPAGE_LIST', 'Eine Übersichtsliste mit allen Teams (ohne Teammitglieder)');
\define('_MI_WGTEAMS_STARTPAGE_ALL', 'Alle Teams mit allen Mitgliedern');
\define('_MI_WGTEAMS_STARTPAGE_FIRST', 'Das erste Team');
\define('_MI_WGTEAMS_SHOW_TEAMNAME', 'Teamname anzeigen');
\define('_MI_WGTEAMS_SHOW_TEAMNAME_DESC', "Definieren Sie bitte, ob der Teamname angezeigt werden soll oder nicht");
\define('_MI_WGTEAMS_LABELS_MEMBER', 'Bezeichnungsfelder Mitgliederinfos anzeigen');
\define('_MI_WGTEAMS_LABELS_MEMBER_DESC', "Definieren Sie bitte, ob vor den jeweiligen Mitgliederinformationen ein Bezeichnungsfeld angezeigt werden soll, z.B. vor dem Namen wie 'Vor- und Zuname' angezeigt. Wenn sie 'Nein' wählen, wird nur der Name selbst, die Telefonnummer selbst, usw. angezeigt");
\define('_MI_WGTEAMS_LABELS_INFOFIELD', 'Bezeichnungsfelder Infofelder anzeigen');
\define('_MI_WGTEAMS_LABELS_INFOFIELD_DESC', "Definieren Sie bitte, ob vor den jeweiligen Informationen der zusätzlichen Infofelder ein Bezeichnungsfeld angezeigt werden soll. Wenn sie 'Nein' wählen, wird nur die jeweilige Information der zusätzlichen Infofelder angezeigt");
\define('_MI_WGTEAMS_SHOWBREADCRUMBS', 'Breadcrumb-Navigation anzeigen');
\define('_MI_WGTEAMS_SHOWBREADCRUMBS_DESC', 'Definieren Sie bitte, ob eine Breadcrumb-Navigation angezeigt werden soll.');
\define('_MI_WGTEAMS_SHOWCOPYRIGHT', 'Copyright anzeigen');
\define('_MI_WGTEAMS_SHOWCOPYRIGHT_DESC', 'Sie können das Copyright bei den wgTeams-Seiten entfernen, jedoch wird ersucht, an einer beliebigen Stelle einen Backlink auf www.wedega.com anzubringen');
//version 2.0.2
\define('_MI_WGTEAMS_USEDETAILS', 'Verwende Details');
\define('_MI_WGTEAMS_USEDETAILS_DESC', 'Definieren Sie bitte, ob Details zu Mitgliederinformationen angezeigt werden sollen');
\define('_MI_WGTEAMS_USEDETAILS_NONE', 'Feature Details nicht verwenden. Es werden immer alle Informationen angezeigt');
\define('_MI_WGTEAMS_USEDETAILS_TAB', 'Zeige Details auf neuem Tab');
\define('_MI_WGTEAMS_USEDETAILS_MODAL', 'Zeige Details in modalem Fenster');
// ---------------- End ----------------
