# adb shell getevent -l
while true; do
    # adb shell input tap 762 1663 				# like
    timestamp=$(date +%s)
	mkdir data/$timestamp # mkdir with current time
	echo $timestamp 
	echo "entering details page"
    adb shell input tap 400 850 				# tap on image; enter details page
    sleep .7								# allow app to catch up before capturing screenshot
    echo "capturing main screenshot"
    adb shell screencap /sdcard/screen.png
    adb pull /sdcard/screen.png data/$timestamp/main.png
	for i in $(seq 1 1 3)
	do
		echo "initiating swipe for main page"
		adb shell input swipe 400 900 400 300 200 # vertical swipe on image
		echo "saving screenshot"
		adb shell screencap /sdcard/screen.png
    	adb pull /sdcard/screen.png data/$timestamp/"main_"$i.png
	done
	adb shell input swipe 400 300 400 900 50 # vertical swipe on image to get it back to images
	for i in $(seq 1 1 5)
	do
		echo "initiating swipe for images"
		adb shell input swipe 800 850 100 850 100 # horizontal swipe on image
		echo "saving screenshot"
		adb shell screencap /sdcard/screen.png
    	adb pull /sdcard/screen.png data/$timestamp/$i.png
	done
	echo "exiting details page"
	adb shell input tap 875 1650 				# tap on like; exit details page
    	    	
	# java -cp scrollscreenshot-latest.jar com.pgssoft.scrollscreenshot.ScrollScreenShot -i 0 --pathsdk /home/rijumone/Android/Sdk -c 2 #scrolling screenshot of page, not working as expected

    sleep .5	# allow app to catch up before next iteration
done