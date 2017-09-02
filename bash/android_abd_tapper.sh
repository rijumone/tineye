# adb shell getevent -l
while true; do
    # adb shell input tap 366 1800 		# not interested
    adb shell input tap 752 1800 			# like
    sleep .5
done