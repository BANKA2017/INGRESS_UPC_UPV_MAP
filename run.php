#!/usr/bin/env php
<?php
/* INGRESS UPC/UPV MAP CREATOR *
 * @banka2017 *
 * v1 *
 */
$import_file = file(dirname(__FILE__) . '/game_log.tsv');//import game_log.tsv
$upc = [];
$upv = [];
$uupc = null;
$uupv = null;
for ($x = 1;$x < count($import_file); $x++) {
    $origin_array = explode("\t",$import_file[$x]);
    if ($origin_array[3] == "captured portal") {
        $upc[] = $origin_array[2] . ',' . $origin_array[1];//upc++
        $upv[] = $origin_array[2] . ',' . $origin_array[1];//upv++
    } elseif (preg_match('/hacked friendly portal|created link|mod deployed|resonator deployed|hacked enemy portal|resonator upgraded/', $origin_array[3])) {
        $upv[] = $origin_array[2] . ',' . $origin_array[1];//upv++
    }
}
$upv = array_unique($upv);//去重
$upc = array_unique($upc);//去重
/*for iitc*/
//coming soon
/*for google maps(.kml) *
 * green - upc *
 * blue - upv *
 */
foreach ($upc as $single_upc) {
    $uupc .= '<Placemark><name/><styleUrl>#icon-1899-0288D1-nodesc</styleUrl><Point><coordinates>' . $single_upc . ',0</coordinates></Point></Placemark>';
}
foreach ($upv as $single_upv) {
    $uupv .= '<Placemark><name/><styleUrl>#icon-1899-0F9D58-nodesc</styleUrl><Point><coordinates>' . $single_upv . ',0</coordinates></Point></Placemark>';
}
file_put_contents(dirname(__FILE__) . '/upc_upv.kml','<?xml version="1.0" encoding="UTF-8"?><kml xmlns="http://www.opengis.net/kml/2.2"><Document><name>INGRESS UPC/UPV MAP</name><Style id="icon-1899-0288D1-nodesc-normal"><IconStyle><color>ffd18802</color><scale>1</scale><Icon><href>http://www.gstatic.com/mapspro/images/stock/503-wht-blank_maps.png</href></Icon><hotSpot x="32" xunits="pixels" y="64" yunits="insetPixels"/></IconStyle><LabelStyle><scale>0</scale></LabelStyle><BalloonStyle><text><![CDATA[<h3>$[name]</h3>]]></text></BalloonStyle></Style><Style id="icon-1899-0288D1-nodesc-highlight"><IconStyle><color>ffd18802</color><scale>1</scale><Icon><href>http://www.gstatic.com/mapspro/images/stock/503-wht-blank_maps.png</href></Icon><hotSpot x="32" xunits="pixels" y="64" yunits="insetPixels"/></IconStyle><LabelStyle><scale>1</scale></LabelStyle><BalloonStyle><text><![CDATA[<h3>$[name]</h3>]]></text></BalloonStyle></Style><StyleMap id="icon-1899-0288D1-nodesc"><Pair><key>normal</key><styleUrl>#icon-1899-0288D1-nodesc-normal</styleUrl></Pair><Pair><key>highlight</key><styleUrl>#icon-1899-0288D1-nodesc-highlight</styleUrl></Pair></StyleMap><Style id="icon-1899-0F9D58-nodesc-normal"><IconStyle><color>ff589d0f</color><scale>1</scale><Icon><href>http://www.gstatic.com/mapspro/images/stock/503-wht-blank_maps.png</href></Icon><hotSpot x="32" xunits="pixels" y="64" yunits="insetPixels"/></IconStyle><LabelStyle><scale>0</scale></LabelStyle><BalloonStyle><text><![CDATA[<h3>$[name]</h3>]]></text></BalloonStyle></Style><Style id="icon-1899-0F9D58-nodesc-highlight"><IconStyle><color>ff589d0f</color><scale>1</scale><Icon><href>http://www.gstatic.com/mapspro/images/stock/503-wht-blank_maps.png</href></Icon><hotSpot x="32" xunits="pixels" y="64" yunits="insetPixels"/></IconStyle><LabelStyle><scale>1</scale></LabelStyle><BalloonStyle><text><![CDATA[<h3>$[name]</h3>]]></text></BalloonStyle></Style><StyleMap id="icon-1899-0F9D58-nodesc"><Pair><key>normal</key><styleUrl>#icon-1899-0F9D58-nodesc-normal</styleUrl></Pair><Pair><key>highlight</key><styleUrl>#icon-1899-0F9D58-nodesc-highlight</styleUrl></Pair></StyleMap><Folder><name>UPC</name>' . $uupc .'</Folder><Folder><name>UPV</name>' . $uupv .'</Folder></Document></kml>');
echo "upc: " . count($upc) . ",upv: " . count($upv) . "\n";
