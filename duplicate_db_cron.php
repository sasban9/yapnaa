<?php 
$time=time();
 $command= "mysqldump -u root -pM0v!Lo@987 movilogl_movilo > /var/www/html/yapnaa/yapnaa_sql_backup_files/movilogl_movilo_$time.sql";
exec($command);

	?>