# for i in $(seq 3 -1 1)
# 	do
# 		res=$((1 - i))
# 		echo $res
# 		if [ "$res" -lt 0 ]
# 		then
# 			res=$((res * -1))
# 		fi
# 		if [ $i -eq 1 ]
# 		then
# 			echo "working once"
# 		fi
# 		echo $res
# 	done
# adb shell getevent -l
# adb tcpip 5555
# echo $((16#00000727)) # convert hex to decimal
# city="Mumbai"
city="Bengaluru"
# dir_to_save="/media/rijumone/7FA69FA47B202A2C/Downloads/tmp/data/"
dir_to_save="/media/rijumone/BE02-5C63/Download/tmp/data/"
# echo dir_to_save
mkdir $dir_to_save$city

# switch to full screen
adb shell settings put global policy_control immersive.status=*
# switch off full screen
# adb shell settings put global policy_control null*

while true; do # forever
    # adb shell input tap 762 1663 				# like
    timestamp=$(date +%s)
	mkdir $dir_to_save$city/$timestamp # mkdir with current time
	echo $timestamp 
	echo "entering details page"
    adb shell input tap 606 1496 				# tap on image; enter details page
    sleep .7								# allow app to catch up before capturing screenshot
    echo "capturing main screenshot"
    adb shell screencap /sdcard/screen.png
    adb pull /sdcard/screen.png $dir_to_save$city/$timestamp/main.png
	for i in $(seq 1 1 3)
	do
		echo "initiating swipe for main page"
		adb shell input swipe 400 900 400 180 200 # vertical swipe on page
		echo "saving screenshot"
		adb shell screencap /sdcard/screen.png
    	adb pull /sdcard/screen.png $dir_to_save$city/$timestamp/"main_"$i.png
		
		# compare current screenshot to last captured screenshot
		filesize_current=$(stat -c%s $dir_to_save$city/$timestamp/"main_"$i.png)
		filesize_last=$(stat -c%s $dir_to_save$city/$timestamp/"main_"$((i - 1)).png)
		difference=$((filesize_current - filesize_last))
		# echo $difference
		if [ "$difference" -lt 0 ]
		then
			difference=$((difference * -1))
		fi
		echo $difference
		if [ "$difference" -lt 10 ] # difference in file size is less than 10 bytes
		then
			rm $dir_to_save$city/$timestamp/"main_"$i.png # delete current screenshot
			break
		fi
		
	done
	adb shell input swipe 400 300 400 900 50 # vertical swipe on page to get it back to images
	for i in $(seq 1 1 5)
	do
		echo "initiating swipe for images"
		adb shell input swipe 800 850 100 850 100 # horizontal swipe on image
		sleep .5	# allow app to catch up to ensure screenshot accuracy
		echo "saving screenshot"
		adb shell screencap /sdcard/screen.png
    	adb pull /sdcard/screen.png $dir_to_save$city/$timestamp/$i.png

    	# compare current screenshot to last captured screenshot
    	if [ $i -eq 1 ]
		then
			filesize_current=$(stat -c%s $dir_to_save$city/$timestamp/main.png)
		else
			filesize_current=$(stat -c%s $dir_to_save$city/$timestamp/$i.png)
		fi
		filesize_last=$(stat -c%s $dir_to_save$city/$timestamp/$((i - 1)).png)
		difference=$((filesize_current - filesize_last))
		# echo $difference
		if [ "$difference" -lt 0 ]
		then
			difference=$((difference * -1))
		fi
		echo $difference
		if [ "$difference" -lt 10 ] # difference in file size is less than 10 bytes
		then
			rm $dir_to_save$city/$timestamp/$i.png # delete current screenshot
			break
		fi
	done
	echo "exiting details page"
	adb shell input tap 715 1831 				# tap on like; exit details page
	# adb shell input tap 900 1663 				# tap on like; exit details page
    	    	
	# java -cp scrollscreenshot-latest.jar com.pgssoft.scrollscreenshot.ScrollScreenShot -i 0 --pathsdk /home/rijumone/Android/Sdk -c 2 #scrolling screenshot of page, not working as expected

    sleep .5	# allow app to catch up before next iteration
done