# adb tcpip 5555
# adb connect 192.168.225.209
# echo $((16#000002f1))
# echo $((16#000006f8))

while true; do # forever
    adb shell input tap 760 1785 				# like
    echo $(date +%s)": tapped!"
done