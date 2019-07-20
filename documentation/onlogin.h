:put ("VC_ALIAS, UPTIME, REMOVE_DELAY");
{
 :local price ("price");
 :local date [/system clock get date ];
 :local time [/system clock get time ];
 :local uptime (4h);
 [/system scheduler add \
  disabled=no \
  interval=$uptime \
  name=$user \
  on-event="[/ip hotspot active remove [find where user=$user]]; [/ip hotspot user set limit-uptime=1s [find where name=$user]]; [/sys sch re [find where name=$user]]; [/sys script run [find where name=$user]]; [/sys script re [find where name=$user]];" \
  start-date=$date \
  start-time=$time \
 ];
 [/system script add \
  name=$user \
  source=":local date [/system clock get date ]; :local time [/system clock get time ]; :local grace_period (1d); [/system scheduler add disabled=no interval=\$grace_period name=$user comment=$date-$time on-event= \"[/ip hotspot user remove [find where name=$user]]; [/ip hotspot active remove [find where user=$user]]; [/sys sch re [find where name=$user]]\"]" \
 ];
 :local bln [:pick $date 0 3];
 :local thn [:pick $date 7 11];
 [
  :local profile [:put [/ip hotspot user get $user profile]];
  :local comment [:put [/ip hotspot user get $user comment]];
  :local agen [:put [:pick $comment 0 [:find $comment ".|."]]];
  /system script add \
  name="$date.|.$time.|.$user.|.$profile.|.$price.|.$comment" \
  owner="$bln$thn" \
  source=$date \
  comment=mikhgen_sales \
 ]
}