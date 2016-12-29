<?php

//
//
//      Copyright (C) 2016 Paul Halliday <paul.halliday@gmail.com>
//
//      This program is free software: you can redistribute it and/or modify
//      it under the terms of the GNU General Public License as published by
//      the Free Software Foundation, either version 3 of the License, or
//      (at your option) any later version.
//
//      This program is distributed in the hope that it will be useful,
//      but WITHOUT ANY WARRANTY; without even the implied warranty of
//      MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//      GNU General Public License for more details.
//
//      You should have received a copy of the GNU General Public License
//      along with this program.  If not, see <http://www.gnu.org/licenses/>.
//
//

include_once '.inc/session.php';
include_once '.inc/config.php';
include_once '.inc/functions.php';
include_once '.inc/countries.php';

dbC();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta content="text/html;charset=utf-8" http-equiv="Content-Type">
<meta content="utf-8" http-equiv="encoding">
<link rel="stylesheet" type="text/css" title="sidestyle" href=".css/squert-blue.css" />
<link rel="stylesheet" type="text/css" title="sidestyle" href=".css/cal-blue.css" />
<link rel="stylesheet" type="text/css" title="topstyle" href=".css/squert.css" />
<link rel="stylesheet" type="text/css" title="topstyle" href=".css/cal.css" />
<script type="text/javascript" src=".js/styleswitcher.js"></script>
<link rel="stylesheet" type="text/css" href=".css/styleswitcher.css" />

<link rel="stylesheet" type="text/css" href=".css/jquery-jvectormap-1.2.2.css" />
<link rel="stylesheet" type="text/css" href=".css/charts.css" />
<link rel="stylesheet" type="text/css" href=".css/spectrum.css" />
<script type="text/javascript" src=".js/jq.js"></script>
<script type="text/javascript" src=".js/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src=".js/squertFunctions-blue.js"></script>
<script type="text/javascript" src=".js/squertCal-blue.js"></script>
<script type="text/javascript" src=".js/squertMain.js"></script>
<script type="text/javascript" src=".js/squertBoxes.js"></script>
<script type="text/javascript" src=".js/squertCharts.js"></script>
<script type="text/javascript" src=".js/jquery-jvectormap-1.2.2.min.js"></script>
<script type="text/javascript" src=".js/jquery-jvectormap-world-mill-en.js"></script>
<script type="text/javascript" src=".js/d3/d3.min.js"></script>
<script type="text/javascript" src=".js/d3/sankey.js"></script>
<script type="text/javascript" src=".js/d3/packages.js"></script>
<script type="text/javascript" src=".js/spectrum.js"></script>

<meta name="mobile-web-app-capable" content="yes">
<link rel="shortcut icon" sizes="192x192" href="../apple-touch-icon.png">
<title id=title>Squert Security</title>
</head>
<body>
<div id=tab_group class=tab_group>
  <!-- <div id=t_sum class=tab>EVENTS</div> -->
  <a href="javascript:window.location.href=window.location.href"><div id=t_sum class=tab>EVENTS</div></a>
  <!--div id=t_inc class=tab>INCIDENTS</div-->
  <div id=t_ovr class=tab>SUMMARY</div>
  <!-- <div id=t_view class=tab>VIEWS</div> -->
  <a href="./IPs.pdf" target="_blank"><div class=tab_link>IP LIST</div></a>
  <a href="https://groups.google.com/forum/#!forum/security-onion" target="_blank"><div class=tab_link>FORUM</div></a>

  <div id=t_search class=search data-state=0>
    <!-- <div data-box=ret class="b_update icon"><img src=.css/refresh-15.png></div>
    <div data-box=ret class=icon><img data-val=1 class=botog src=.css/layout1.png title="Show/Hide panes"></div>
    <div data-box=ret class="b_update icon"><img title=refresh class="il ilb" src=.css/update.png></div>
    <div class="icon_notifier"><img src=.css/exc.png></div>
    <div data-box=cat class=icon id=ico01><img title="Event Comments" class="il ilb" src=.css/comment.png></div>
    <div data-box=ac class=icon id=ico02><img title="Auto Catagorized Events" class="il ilb" src=.css/autocat.png></div>
    <div data-box=sen class=icon id=ico03><img title="Toggle Sensors" class="il ilb" src=.css/sensor.png></div>
    <div data-box=srch class=icon id=ico05><img title="Search" class="il ilb" src=.css/ext.png></div>
    <div data-box=fltr class=icon id=ico04><img title="Filters" class="il ilb" src=.css/filter.png></div> -->
    <input class=search id=search type=text size=20 maxlength=1000><div id=clear_search class=iconr><img title="Clear search box" class=il src=.css/delete.png></div>
  </div>
  <div id=cal></div>
  <div class=timeline>
    <div id=loader class=loader><img class=ldimg src=".css/load.gif"></div> <!-- note: page won't work if loader is hidden -->
     <!-- <div class=t_pbar></div>
     <div class=t_stats></div> -->
  </div>
  <div class=db_links>
    <div class=db_linkt>view:</div>
    <div class=db_link data-val=ip data-state=1>IP</div>
    <div class=db_link data-val=sc>SOURCE COUNTRY</div>
    <div class=db_link data-val=dc>DESTINATION COUNTRY</div>
    <div class=db_linkt>type:</div>
    <!-- <div class=db_type data-type=cl>CLUSTER LAYOUT</div> -->
    <!-- <div class=db_type data-type=eb>EDGE BUNDLING</div> -->
    <!-- <div class=db_type data-type=hp>HIVE PLOT</div> -->
    <!-- <div class=db_type data-type=sk data-state=1>SANKEY DIAGRAM</div> -->
    <!-- <div class=db_save><span class=links>save as svg</span></div> -->
  </div>
</div>

<div class=lr>
  <div class=content-left>

    <div class=event_cont>
      <div class=label_l><span class=ec_label>FILTERING OPTIONS</span></div>
      <div class=secl id=sec_t5>
        <div data-box=sen class=icon id=ico03><img title="Toggle Sensors" class="il ilb" src=.css/autocat.png></div>
        <div data-box=fltr class=icon id=ico04><img title="Filters" class="il ilb" src=.css/filter.png></div>
        <div data-box=ac class=icon id=ico02><img title="Auto Catagorized Events" class="il ilb" src=.css/sensor.png></div>
        <div data-box=cat class=icon id=ico01><img title="Event Comments" class="il ilb" src=.css/comment.png></div>
        <div data-box=ret class="b_update icon"><img title="Refresh List to apply any changes" src=.css/refresh-17.png></div>
      </div>
    </div>

    <div class=event_cont>
      <div class=label_l><span class=ec_label>INFORMATION</span><div class=label_m><img data-sec=t2 title=show\hide class="il st" src=.css/darr.png></div></div>
      <div class=secl id=sec_t2 style="display:none;">
	<div class=info>&nbsp; Options shown below reflect currently defined interval.</div>
	<div class=info>&nbsp; Must refresh list to apply option changes.</div>
	<div class=info2 id=b_local>&nbsp; Current server time in <strong>LOCAL</strong> format <span class=clock_now id=clock_local>00:00:00</span></div>
	<div class=info2 id=b_utc>&nbsp; Current server time in <strong>UTC</strong> format <span class=clock_now id=clock_utc>00:00:00</span></div>

      </div>
    </div>

    <div class=event_cont>
      <div class=label_l><span class=ec_label>LIST VIEW OPTIONS</span><div class=label_m><img data-sec=t3 title=show\hide class="il st" src=.css/uarr.png></div></div>
      <div class=secl id=sec_t3>
	<script type="text/javascript">
		function toggle_dates(id) {
		   var k55 = document.getElementById(id);
		   if(k55.style.display == 'block')
		   k55.style.display = 'none';
		   else
		   k55.style.display = 'block';
		}
	</script>
	<div class=info2>&nbsp; Time interval of listed events.</div>
        <div class=time_filter onclick="toggle_dates('cal');"></div>
        <br>
        <div class=label>Show time in Local format</div><label class="switch"><input type="checkbox" id=ts_utc><div class="slider"></div></label>
	<!-- <input class=dt_utc id=ts_utc type="checkbox"> -->
	<br>
		<!-- this script is for the Auto page refresh checkbox function -->
		<script language="Javascript">
		var reloading;
		function checkReloading() {
		    if (window.location.hash=="") {
		        reloading=setTimeout("window.location.reload();", 300000); // 1000 = 1 second, 300000 = 5 minutes
		        document.getElementById("reloadCB").checked=true;
		    }
		}
		function toggleAutoRefresh(cb) {
		    if (cb.checked) {
		        window.location.replace("");
		        reloading=setTimeout("window.location.reload();", 300000);
		    } else {
		        window.location.replace("#");
		        clearTimeout(reloading);
		    }
		}
		window.onload=checkReloading;
		</script>
	<div class=label>Auto 5 minute page refresh</div><label class="switch2"><input type="checkbox" onclick="toggleAutoRefresh(this);" id="reloadCB"><div class="slider2"></div></label>

        <div class=label>Filtered by classification</div><div class=class_filter></div>
        <div class=label>Filtered by scensor</div><div class=sensor_filter></div>
        <div class=label>Show uncategorized only</div><div id=rt class=tvalue_on>on</div>
        <div class=label>Group by signature</div><div id=gr class=tvalue_on>on</div>
	<br><br><br><br>


        <!-- <div class=label>Refresh List</div><div data-box=ret class="b_update icon"><img src=.css/refresh-15.png></div> -->
      </div>
    </div>

    <div class=event_cont>
      <div class=label_l><span class=ec_label>EVENT CLASSIFICATION</span><div class=label_m><img data-sec=c title=show\hide class="il st" src=.css/uarr.png></div></div>
      <div class=secl id=sec_c>  

        <div id=b_class-2 class=label_c data-c=2 data-cn=ES>
        <div class=b_ES>ES</div>Escalated</div><div data-type=st id=c-2 class=value_link>-</div>

        <div id=b_class-11 class=label_c data-c=11 data-cn=C1>
        <div class=b_C1>C1</div>Compromised L1</div><div data-type=st id=c-11 class=value_link>-</div>

        <div id=b_class-12 class=label_c data-c=12 data-cn=C2>
        <div class=b_C2>C2</div>Compromised L2</div><div data-type=st id=c-12 class=value_link>-</div>
      
        <div id=b_class-13 class=label_c data-c=13 data-cn=C3>
        <div class=b_C3>C3</div>Attempted Access</div><div data-type=st id=c-13 class=value_link>-</div>

        <div id=b_class-14 class=label_c data-c=14 data-cn=C4>
        <div class=b_C4>C4</div>Denial of Service</div><div data-type=st id=c-14 class=value_link>-</div>
      
        <div id=b_class-15 class=label_c data-c=15 data-cn=C5>
        <div class=b_C5>C5</div>Policy Violation</div><div data-type=st id=c-15 class=value_link>-</div>

        <div id=b_class-16 class=label_c data-c=16 data-cn=C6>
        <div class=b_C6>C6</div>Recon</div><div data-type=st id=c-16 class=value_link>-</div>
      
        <div id=b_class-17 class=label_c data-c=17 data-cn=C7>
        <div class=b_C7>C7</div>Malicious</div><div data-type=st id=c-17 class=value_link>-</div>

        <div id=b_class-1 class=label_c data-c=1 data-cn=NA>
        <div class=b_NA>NA</div>No Action Needed</div><div data-type=st id=c-1 class=value_link>-</div>

        <div class=label_c>
        <div class=b_RT>RT</div>RealTime info</div>
      
      </div>
    </div>

    <div class=event_cont>
      <div class=label_l><span class=ec_label>EVENT PRIORITY</span><div class=label_m><img data-sec=p title=show\hide class="il st" src=.css/darr.png></div></div>
      <div class=secl id=sec_p">
        <div class=priority_filter></div>
        <div class=label_p><span class="label_p-high">High</span></div><div id=pr_1 class=value>-</div>
        <div class=label_p><span class="label_p-med">Medium</span></div><div id=pr_2 class=value>-</div>
        <div class=label_p><span class="label_p-low">Low</span></div><div id=pr_3 class=value>-</div>
        <div class=label_p><span class="label_p-other">Other</span></div><div id=pr_4 class=value>-</div>
      </div>
    </div>

    <div class=event_cont>
      <div class=label_l><span class=ec_label>EVENT SUMMARY</span><div class=label_m><img data-sec=s title=show\hide class="il st" src=.css/darr.png></div></div>
      <div class=secl id=sec_s style="display:none;">  
        <div class=label_s>Queued events</div><div id=qtotal class=value>-</div>
        <div class=label_s>Total events</div><div id=etotal class=value>-</div>
        <div class=label_s>Total signatures</div><div id=esignature class=value>-</div>
        <div class=label_s>Total sources</div><div id=esrc class=value>-</div>
        <div class=label_s>Total destinations</div><div id=edst class=value>-</div>
      </div>
    </div>


    <div class=event_cont>
      <div class=label_l><span class=ec_label>HISTORY</span>
        <img title="View in pop-out" id=pi class=pop src=.css/po.png>
        <div class=label_m><img data-sec=h title=show\hide class="il st" src=.css/darr.png></div>  
      </div>
      <div class=secl id=sec_h style="display:none;">
        <div id=h_box class=h_box></div>
      </div>
    </div>

  </div>
  
  <div class=content-right>
    <div id=t_sum_content class=content>
      <div id=aaa-00 class=aaa>
	  <div class=times id=times>
	  <span class=info2>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Events for selected time interval, charted by time of day.</span>
	  <br>
	  </div>
	  <script type="text/javascript">
	    function toggle_visibility(id) {
	       var e = document.getElementById(id);
	       if(e.style.display == 'block')
	          e.style.display = 'none';
	       else
	          e.style.display = 'block';
	    }
	  </script>
	  <span class=times-toggle>Time of day chart <a onclick="toggle_visibility('times');"><img data-sec=h title=show\hide class="il st" src=.css/darr.png></a></span>
	  <br>
	  <span class=info2>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Events for selected time interval, sorted based on sidebar viewing options.</span>
      </div>
    </div>
  </div>

  <div class=rl>
    <div id=t_view_content class=content>
      <div id=db_help class="hide label100">This view shows source and destination connections. The width of each ribbon indicates the volume of events. If a source and destination are linked with a red line then an event has occured in both directions (A -> B, B -> A). When no filters are present and only a single event exists, lone hosts that are associated with other lone hosts are not shown. Nodes can be repositioned by clicking on the desired node and then dragging it to a new position. IPs can be added as filters by double clicking their label. When you are on this page and a filter is in place the 'enter' key will take you to the events. To recreate the view (with the filter) click the update link.</div>
      <div class=db_view></div> 
    </div>
    <div id=t_inc_content class=content>&nbsp;Not broken, just not done.</div>
    <div id=t_ovr_content class=content>
      <br>     
      <div class=onepane>
        <div class=ovbl>GEOGRAPHIC DISTRIBUTION</div><div id=ovmapstat class=ovstat></div><div class=ovbi id=ov_map_msg></div><div class=ovsl id=ov_map_sl></div>
        <div id=ov_map></div>
      </div>
      <div class=onepane>
        <div class=ovbl>TOP SIGNATURES</div><div id=ovestat class=ovstat></div><div class=ovbi id=ov_signature_msg></div><div class=ovsl id=ov_signature_sl></div>
        <div id=ov_signature></div>
      </div>
      <div class=twopane>
        <div class=leftpane>
          <div class=ovbl>TOP SOURCE IPS</div><div class=ovbi id=ov_srcip_msg></div><div class=ovsl id=ov_srcip_sl></div>
          <div id=ov_srcip></div>
        </div>
        <div class=rightpane> 
          <div class=ovbl>TOP DESTINATION IPS</div><div class=ovbi id=ov_dstip_msg></div><div class=ovsl id=ov_dstip_sl></div>
          <div id=ov_dstip></div>
        </div>
      </div>
      <div class=twopane>
        <div class=leftpane>
          <div class=ovbl>TOP SOURCE COUNTRIES</div><div class=ovbi id=ov_srccc_msg></div><div class=ovsl id=ov_srccc_sl></div>
          <div id=ov_srccc></div>
        </div>
        <div class=rightpane> 
          <div class=ovbl>TOP DESTINATION COUNTRIES</div><div class=ovbi id=ov_dstcc_msg></div><div class=ovsl id=ov_dstcc_sl></div>
          <div id=ov_dstcc></div>
        </div>
      </div>
      <div class=twopane>
        <div class=leftpane>
          <div class=ovbl>TOP SOURCE PORTS</div><div class=ovbi id=ov_srcpt_msg></div><div class=ovsl id=ov_srcpt_sl></div>
          <div id=ov_srcpt></div>
        </div>
        <div class=rightpane> 
          <div class=ovbl>TOP DESTINATION PORTS</div><div class=ovbi id=ov_dstpt_msg></div><div class=ovsl id=ov_dstpt_sl></div>
          <div id=ov_dstpt></div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class=box id=cat_box>
  <div class=cat_top>
    <div class=box_label id=cat_box_label>COMMENTS</div>
    <div title="close" class="box_close" data-box=cat><img class=il src=.css/close.png></div>
    <div title=refresh class=cat_refresh><img class=il src=.css/reload.png></div>
    <div id=ovcstat class="box_stat"></div>
  </div>
  <div>
    <div class=box_label>These are the comments you've previously used to classify events.</div>
  </div>
  <div class=cm_controls>
    <div class=cat_l1>COMMENT:</div>
    <div class=cat_r1><input class=cat_msg_txt type=text maxlength=255></div>
    <div class=cat_l1>CLASSIFICATION:</div>
    <div class=cat_r1 id=cw_buttons>
      <div class=b_ES data-n=2>ES</div>
      <div class=b_C1 data-n=11>C1</div>
      <div class=b_C2 data-n=12>C2</div>
      <div class=b_C3 data-n=13>C3</div>
      <div class=b_C4 data-n=14>C4</div>
      <div class=b_C5 data-n=15>C5</div>
      <div class=b_C6 data-n=16>C6</div>
      <div class=b_C7 data-n=17>C7</div>
      <div class=b_NA data-n=1>NA</div>
      <!-- Will require a mod to sguil (DeleteEventIDList) -->
      <!--&nbsp;&nbsp;<span class=links data-n=0>apply comment only</span>-->
    </div>
    <div class=cat_note>&nbsp;&nbsp;<b>Note:</b> you can click a comment below to reuse it (followed by a classification action) <b>or</b> click on the "F" icon followed by "enter" to use as a filter<br></div>
 
  </div>
  <div class=cm_tbl></div>
</div>

<div class=box id=sen_box>
  <div class=sen_top>
    <div class=box_label>SENSORS</div>
    <div title="close" class="box_close" data-box=sen><img class=il src=.css/close.png></div> 
  </div>
  <div>
    <div class=box_label>Check the sensors you wish to view, close this window, then Refresh list.</div>
  </div>
  <div class=sen_controls></div>
  <div class=sen_tbl></div>
</div>

<div class=box id=fltr_box>
  <div class=fltr_top>
    <div class=box_label>FILTERS and URLs</div>
    <div title="close" class="box_close" data-box=fltr><img class=il src=.css/close.png></div>
    <div title=add class=filter_new><img class=il src=.css/add.png></div>
    <div title=refresh class=filter_refresh><img class=il src=.css/reload.png></div>
    <div title=help class=filter_help><img class=il src=.css/help.png></div>
  </div>
  <div>
    <div class=box_label>You can create your own automated filters here.</div>
  </div>
  <div class=hp_links>
    <div class=hp_typet>type:</div>
    <div class="hp_type hp_type_active" data-val=filter>FILTER</div>
    <div class=hp_type data-val=url>URL</div>
  </div>
  <div class=fltr_tbl></div>
</div>

<div class=box id=ac_box>
  <div class=ac_top>
    <div class=box_label>AUTOCAT</div>
    <div title="close" class="box_close" data-box=ac><img class=il src=.css/close.png></div>
    <div title=add class=ac_new><img class=il src=.css/add.png></div>
    <div title=refresh class=ac_refresh><img class=il src=.css/reload.png></div>
    <!-- <div title=help class=ac_help><img class=il src=.css/help.png></div> -->
    <script language="JavaScript">function MM_openBrWindow(theURL,winName,features){window.open(theURL,winName,features);}</script>
    <a href="javascript:;" onClick="MM_openBrWindow('categories.png','Category Definitions','width=564,height=356')"><div class=ac_help title="Category Definitions"><img class=il src=.css/help.png></div></a>
    <div id=ovacstat class="box_stat hide"></div>
  </div>
  <div>
    <div class=box_label>New additions and disables only affect future events, not historical.
    <!-- <br>#sudo /usr/sbin/nsm_server_ps-restart -->
    <!-- <br><a href="javascript:;" onClick="MM_openBrWindow('.scripts/restart-nsm.php','Restart NSM Now','width=250,height=50')" class="ac_view"><img src=.css/reload.png>Restart sguil service now</a> -->
    </div>
  </div>
  <div class=ac_tbl></div>
</div>

<div class=box id=srch_box>
  <div class=srch_top>
    <div class=box_label id=srch_box_label>EXTERNAL LOOKUP</div>
    <div title="close" class="box_close" data-box=srch><img class=il src=.css/close.png></div>
    <div id=srch_stat_msg class="box_stat hide"></div> 
  </div>
  <div class=lu_links>
    <div class=lu_typet>type:</div>
    <div class="lu_type lu_type_active" data-val=esc>ELASTICSEARCH</div>
    <div class=lu_type data-val=url>URL</div>
  </div>
  <div class=srch_controls>
    <div class=cat_l1>QUERY:</div>
    <div class=cat_r1><input class=srch_txt type=text maxlength=255 value="*"></div>
    <div class=clear_srch><img title=clear class=il src=.css/delete.png></div>
    <div class=cat_l1>TERMS:</div>
    <div class=cat_r1 id=srchterms></div>
    <div id=el_tdc>
      <div class=cat_l1>INTERVAL:</div>
      <div class=cat_r1 id=srchint>
        <input id=el_start class=el_ts type=text maxlength=19>
        &nbsp;&nbsp;-&gt; &nbsp;&nbsp;
        <input id=el_end class=el_ts type=text maxlength=19>
      </div>
      <div class=cat_l1>
        <div class=srch_do><img title=search class=il src=.css/search.png></div>
      </div>
      <div class=cat_r1 id=srchsrc>
         <b>no</b> sources are selected
      </div>
    </div>
  </div>
  <div class=srch_tbl></div>
</div>

<div class=pickbox>
  <div class=srch_top>
    <div class=box_label id=pickbox_label></div>
    <div title="close" class="pickbox_close"><img class=il src=.css/close.png></div>
  </div>
  <div class=pickbox_tbl></div>
</div>

<div class=bottom>
  <div id=t_usr class=user data-c_usr=<?php echo $sUser;?>>Squert&nbsp;Network&nbsp;Security&nbsp;-&nbsp;&nbsp;<b><?php echo $sUser;?></b>&nbsp;&nbsp;|<span id=logout class=logout>LOGOUT</span></div>
  <div class=b_tray></div>
  <div class=b_class><span class=class_msg></span>&nbsp;</div>
  <!-- <div class=b_clock id=b_utc><span class=clock_lbl>UTC</span> <span id=clock_utc>00:00:00</span></div> -->
  <!-- <div class=b_clock id=b_local><span class=clock_lbl>LOCAL</span> <span id=clock_local>00:00:00</span></div> -->
  <!-- <div><span><a href="#" onclick="setActiveStyleSheet('sidestyle'); return false;">Side style</a> &nbsp;&nbsp; <a href="#" onclick="setActiveStyleSheet('topstyle'); return false;">Top style</a></span></div> -->
    <div>
	<nav id="primary_nav_wrap">
	<ul>
	<li><a href="#">Styles</a>
    	<ul>
    	  <!-- <li><a href="#" onclick="setActiveStyleSheet('sidestyle'); return false;">Side blue</a></li> -->
    	  <!-- <li><a href="#" onclick="setActiveStyleSheet('topstyle'); return false;">Top red</a></li> -->
    	  <!-- <li><a href="index.php" target="_blank">Red</a></li> -->
    	  <li><a href="#" onclick="window.location='index.php'+window.location.search;">Red</a></li>
    	</ul>
  	</li>
	</ul>
	</nav>
    </div>
  </div>  
</div>

<input id=event_sort type=hidden value="DESC">
<input id=event_sum type=hidden value="0">
<input id=cat_sum type=hidden value="0">
<input id=user_tz type=hidden value="<?php echo $_SESSION['tzoffset'];?>">
<input id=sel_tab type=hidden value="<?php echo $_SESSION['sTab'];?>">

</body>
</html>
